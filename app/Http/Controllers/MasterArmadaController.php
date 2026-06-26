<?php

namespace App\Http\Controllers;

use App\Models\JenisArmada;
use App\Models\KontrakSubkon;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterArmadaController extends Controller
{
    // Jenis Armada
    public function jenisIndex()
    {
        $jenis = JenisArmada::latest()->paginate(10);
        return view('master.armada.jenis.index', compact('jenis'));
    }

    public function jenisStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tipe_kendaraan' => 'required',
            'harga_sewa' => 'nullable|numeric',
            'satuan' => 'required',
            'keterangan' => 'nullable',
        ]);

        JenisArmada::create($validated);
        return redirect()->back()->with('success', 'Jenis Armada ditambahkan.');
    }

    public function jenisUpdate(Request $request, JenisArmada $jenisArmada)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tipe_kendaraan' => 'required',
            'harga_sewa' => 'nullable|numeric',
            'satuan' => 'required',
            'status' => 'required',
            'keterangan' => 'nullable',
        ]);

        $jenisArmada->update($validated);
        return redirect()->back()->with('success', 'Jenis Armada diperbarui.');
    }

    // Kontrak Subkon
    public function kontrakIndex()
    {
        $kontraks = KontrakSubkon::with('vendor', 'armada')->latest()->paginate(10);
        return view('master.armada.kontrak.index', compact('kontraks'));
    }

    public function kontrakCreate()
    {
        $vendors = Vendor::where('status', 'aktif')->whereIn('tipe', ['transport', 'trucking', 'umum'])->get();
        return view('master.armada.kontrak.create', compact('vendors'));
    }

    public function kontrakStore(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'jenis' => 'required|in:armada,driver,keduanya',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'nilai_kontrak' => 'nullable|numeric',
            'keterangan' => 'nullable',
        ]);

        $validated['nomor_kontrak'] = 'KTR-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        KontrakSubkon::create($validated);

        return redirect()->route('master.armada.kontrak.index')
            ->with('success', 'Kontrak subkon berhasil dibuat.');
    }

    public function kontrakShow(KontrakSubkon $kontrakSubkon)
    {
        $kontrakSubkon->load('vendor', 'armada');
        return view('master.armada.kontrak.show', compact('kontrakSubkon'));
    }
}
