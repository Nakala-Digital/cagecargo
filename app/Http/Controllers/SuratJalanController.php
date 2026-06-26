<?php

namespace App\Http\Controllers;

use App\Models\SuratJalan;
use App\Models\JobOrder;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\ArArmada;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratJalanController extends Controller
{
    public function index()
    {
        $suratJalan = SuratJalan::with(['jobOrder.customer', 'armada', 'driver'])
            ->latest()->paginate(15);
        return view('operasional.surat-jalan.index', compact('suratJalan'));
    }

    public function create()
    {
        $jobOrders = JobOrder::with('customer')->whereNotIn('status', ['draft', 'closed'])->get();
        $armada = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status', 'aktif')->get();
        return view('operasional.surat-jalan.create', compact('jobOrders', 'armada', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_order_id' => 'required|exists:job_orders,id',
            'armada_id' => 'required|exists:armada,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'tujuan' => 'required',
            'rute' => 'nullable',
            'tanggal_berangkat' => 'required|date',
            'tanggal_perkiraan_kembali' => 'nullable|date',
            'jenis_muatan' => 'nullable',
            'berat_muatan' => 'nullable|numeric',
            'biaya_angkut' => 'nullable|numeric',
            'catatan' => 'nullable',
        ]);

        $validated['nomor_surat_jalan'] = 'SJ-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        $validated['created_by'] = auth()->id();
        $validated['status'] = 'diterbitkan';

        $suratJalan = SuratJalan::create($validated);
        $this->createArFromSuratJalan($suratJalan);

        return redirect()->route('operasional.surat-jalan.index')
            ->with('success', 'Surat Jalan berhasil diterbitkan.');
    }

    public function show(SuratJalan $suratJalan)
    {
        $suratJalan->load(['jobOrder.customer', 'armada.jenisArmada', 'driver', 'createdBy']);
        return view('operasional.surat-jalan.show', compact('suratJalan'));
    }

    public function updateStatus(Request $request, SuratJalan $suratJalan)
    {
        $validated = $request->validate([
            'status' => 'required|in:diterbitkan,dalam_perjalanan,selesai,bermasalah',
            'tanggal_kembali' => 'nullable|date',
            'catatan' => 'nullable',
        ]);

        $suratJalan->update($validated);
        $this->createArFromSuratJalan($suratJalan->fresh(['jobOrder.customer']));

        return redirect()->back()->with('success', 'Status Surat Jalan diperbarui.');
    }

    private function createArFromSuratJalan(SuratJalan $suratJalan): void
    {
        $suratJalan->loadMissing('jobOrder.customer');

        if (!$suratJalan->biaya_angkut || !$suratJalan->jobOrder?->customer_id) {
            return;
        }

        $ar = ArArmada::firstOrNew(['referensi' => 'SJ:' . $suratJalan->nomor_surat_jalan]);
        $ar->fill([
            'nomor_ar' => $ar->nomor_ar ?: 'AR-' . date('Ymd') . '-' . Str::upper(Str::random(6)),
            'job_order_id' => $suratJalan->job_order_id,
            'customer_id' => $suratJalan->jobOrder->customer_id,
            'tipe' => 'surat_jalan',
            'jumlah' => $suratJalan->biaya_angkut,
            'tanggal' => $suratJalan->tanggal_berangkat,
            'jatuh_tempo' => $suratJalan->tanggal_berangkat?->copy()->addDays(14),
            'status' => $ar->status ?: 'unpaid',
            'keterangan' => 'Auto dummy A/R dari Surat Jalan ' . $suratJalan->nomor_surat_jalan,
        ])->save();
    }
}
