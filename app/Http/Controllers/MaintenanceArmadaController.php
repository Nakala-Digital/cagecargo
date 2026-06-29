<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceArmada;
use App\Models\Armada;
use App\Models\Vendor;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;

class MaintenanceArmadaController extends Controller
{
    use HasFileUpload;

    public function index(Request $request)
    {
        $query = MaintenanceArmada::with(['armada', 'vendor']);

        if ($request->armada_id) {
            $query->where('armada_id', $request->armada_id);
        }
        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->from) {
            $query->whereDate('tanggal', '>=', $request->from);
        }
        if ($request->to) {
            $query->whereDate('tanggal', '<=', $request->to);
        }

        $data = $query->latest('tanggal')->paginate(20);
        $armada = Armada::where('status', 'aktif')->get();
        $totalBiaya = $query->sum('total_biaya');

        return view('operasional.maintenance.index', compact('data', 'armada', 'totalBiaya'));
    }

    public function create()
    {
        $armada = Armada::where('status', 'aktif')->get();
        $vendors = Vendor::where('status', 'aktif')->get();
        return view('operasional.maintenance.create', compact('armada', 'vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'armada_id' => 'required|exists:armada,id',
            'tanggal' => 'required|date',
            'jenis' => 'required',
            'deskripsi' => 'nullable',
            'vendor_id' => 'nullable|exists:vendors,id',
            'biaya_part' => 'nullable|numeric',
            'biaya_jasa' => 'nullable|numeric',
            'nomor_nota' => 'nullable',
            'km_tempuh' => 'nullable|integer',
            'jadwal_berikutnya' => 'nullable|date',
            'keterangan' => 'nullable',
            'bukti' => 'nullable|file|max:5120',
        ]);

        $validated['biaya_part'] = $validated['biaya_part'] ?? 0;
        $validated['biaya_jasa'] = $validated['biaya_jasa'] ?? 0;
        $validated['total_biaya'] = $validated['biaya_part'] + $validated['biaya_jasa'];

        $validated['bukti'] = $this->uploadFile($request, 'bukti', 'uploads/maintenance');

        MaintenanceArmada::create($validated);

        return redirect()->route('operasional.maintenance.index')
            ->with('success', 'Data maintenance berhasil dicatat.');
    }

    public function show(MaintenanceArmada $maintenance)
    {
        $maintenance->load(['armada', 'vendor']);
        return view('operasional.maintenance.show', compact('maintenance'));
    }
}
