<?php

namespace App\Http\Controllers;

use App\Models\PengeluaranArmada;
use App\Models\Armada;
use Illuminate\Http\Request;

class PengeluaranArmadaController extends Controller
{
    public function index(Request $request)
    {
        $query = PengeluaranArmada::with(['armada', 'driver', 'jobOrder']);

        if ($request->jenis) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->armada_id) {
            $query->where('armada_id', $request->armada_id);
        }
        if ($request->start_date) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        $pengeluaran = $query->latest()->paginate(20);
        $armada = Armada::where('status', 'aktif')->get();
        $total = $query->sum('jumlah');

        return view('operasional.pengeluaran.index', compact('pengeluaran', 'armada', 'total'));
    }

    public function approve(PengeluaranArmada $pengeluaran)
    {
        $pengeluaran->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Pengeluaran disetujui.');
    }

    public function reject(Request $request, PengeluaranArmada $pengeluaran)
    {
        $pengeluaran->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Pengeluaran ditolak.');
    }
}
