<?php

namespace App\Http\Controllers;

use App\Models\UangJalan;
use App\Models\SuratJalan;
use App\Models\Armada;
use App\Models\Driver;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UangJalanController extends Controller
{
    use HasFileUpload;

    public function index(Request $request)
    {
        $query = UangJalan::with(['suratJalan.jobOrder.customer', 'armada', 'driver']);

        if ($request->surat_jalan_id) {
            $query->where('surat_jalan_id', $request->surat_jalan_id);
        }
        if ($request->armada_id) {
            $query->where('armada_id', $request->armada_id);
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->from) {
            $query->whereDate('tanggal', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        $uangJalan = $query->latest()->paginate(15);
        $armada = Armada::where('status', 'aktif')->get();

        return view('operasional.uang-jalan.index', compact('uangJalan', 'armada'));
    }

    public function create()
    {
        $suratJalan = SuratJalan::with('jobOrder.customer', 'armada', 'driver')
            ->whereIn('status', ['diterbitkan', 'dalam_perjalanan'])
            ->whereDoesntHave('uangJalan')
            ->get();
        $armada = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status', 'aktif')->get();
        return view('operasional.uang-jalan.create', compact('suratJalan', 'armada', 'drivers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_jalan_id' => 'required|exists:surat_jalan,id',
            'armada_id' => 'required|exists:armada,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'tanggal' => 'required|date',
            'solar' => 'nullable|numeric',
            'tol' => 'nullable|numeric',
            'parkir' => 'nullable|numeric',
            'makan_driver' => 'nullable|numeric',
            'preman' => 'nullable|numeric',
            'komisi_driver' => 'nullable|numeric',
            'lainnya' => 'nullable|numeric',
            'keterangan' => 'nullable',
            'bukti' => 'nullable|file|max:5120',
        ]);

        $validated['nomor_uang_jalan'] = 'UJ-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        $validated['created_by'] = auth()->id();

        $fields = ['solar', 'tol', 'parkir', 'makan_driver', 'preman', 'komisi_driver', 'lainnya'];
        $total = 0;
        foreach ($fields as $f) {
            $validated[$f] = $validated[$f] ?? 0;
            $total += $validated[$f];
        }
        $validated['total'] = $total;

        $validated['bukti'] = $this->uploadFile($request, 'bukti', 'uploads/uang-jalan');

        UangJalan::create($validated);

        return redirect()->route('operasional.uang-jalan.index')
            ->with('success', 'Uang Jalan berhasil dicatat.');
    }

    public function show(UangJalan $uangJalan)
    {
        $uangJalan->load(['suratJalan.jobOrder.customer', 'armada.jenisArmada', 'driver', 'createdBy', 'approvedBy']);
        return view('operasional.uang-jalan.show', compact('uangJalan'));
    }

    public function approve(UangJalan $uangJalan)
    {
        $uangJalan->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'tanggal_dicairkan' => now(),
        ]);
        return redirect()->back()->with('success', 'Uang Jalan disetujui & dicairkan.');
    }
}
