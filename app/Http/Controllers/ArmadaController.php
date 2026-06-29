<?php

namespace App\Http\Controllers;

use App\Models\Armada;
use App\Models\Vendor;
use App\Models\JenisArmada;
use App\Models\KontrakSubkon;
use App\Models\DokumenIzin;
use App\Models\PengeluaranArmada;
use App\Models\BudgetArmada;
use App\Models\SuratJalan;
use App\Models\ApArmada;
use App\Models\ArArmada;
use App\Traits\HasFileUpload;
use Illuminate\Http\Request;

class ArmadaController extends Controller
{
    use HasFileUpload;

    public function index()
    {
        $armadas = Armada::with(['vendor', 'jenisArmada', 'kontrak'])->latest()->paginate(10);
        return view('master.armada.index', compact('armadas'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', 'aktif')->get();
        $jenisArmada = JenisArmada::where('status', 'aktif')->get();
        $kontraks = KontrakSubkon::where('status', 'aktif')->get();
        return view('master.armada.create', compact('vendors', 'jenisArmada', 'kontraks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_polisi' => 'required|unique:armada',
            'jenis_kendaraan' => 'required',
            'merk' => 'nullable',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
            'nomor_mesin' => 'nullable',
            'nomor_rangka' => 'nullable',
            'kapasitas' => 'nullable|numeric',
            'vendor_id' => 'nullable|exists:vendors,id',
            'gps_device_id' => 'nullable',
            'rfid_tag' => 'nullable',
            'jenis_armada_id' => 'nullable|exists:jenis_armada,id',
            'jenis_kepemilikan' => 'required|in:milik_sendiri,subkon_armada,subkon_driver,subkon_keduanya',
            'kontrak_id' => 'nullable|exists:kontrak_subkon,id',
            'harga_sewa' => 'nullable|numeric',
            'tanggal_ganti_oli_terakhir' => 'nullable|date',
            'jarak_tempuh_ganti_oli' => 'nullable|integer',
            'tanggal_service_terakhir' => 'nullable|date',
            'jarak_tempuh_service' => 'nullable|integer',
        ]);

        Armada::create($validated);

        return redirect()->route('master.armada.index')
            ->with('success', 'Armada berhasil ditambahkan.');
    }

    public function show(Armada $armada)
    {
        $armada->load([
            'vendor', 'jenisArmada', 'kontrak', 'dokumen', 'izin',
            'pengeluaran' => fn($q) => $q->latest()->take(20),
            'budgetBulanIni',
            'suratJalan' => fn($q) => $q->latest()->take(10),
        ]);
        $totalPengeluaranBulanIni = $armada->pengeluaran()
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->sum('jumlah');
        return view('master.armada.show', compact('armada', 'totalPengeluaranBulanIni'));
    }

    public function edit(Armada $armada)
    {
        $vendors = Vendor::where('status', 'aktif')->get();
        $jenisArmada = JenisArmada::where('status', 'aktif')->get();
        $kontraks = KontrakSubkon::where('status', 'aktif')->get();
        return view('master.armada.edit', compact('armada', 'vendors', 'jenisArmada', 'kontraks'));
    }

    public function update(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'nomor_polisi' => 'required|unique:armada,nomor_polisi,' . $armada->id,
            'jenis_kendaraan' => 'required',
            'merk' => 'nullable',
            'tahun' => 'nullable|integer|min:2000|max:' . date('Y'),
            'nomor_mesin' => 'nullable',
            'nomor_rangka' => 'nullable',
            'kapasitas' => 'nullable|numeric',
            'vendor_id' => 'nullable|exists:vendors,id',
            'gps_device_id' => 'nullable',
            'rfid_tag' => 'nullable',
            'status' => 'required',
            'jenis_armada_id' => 'nullable|exists:jenis_armada,id',
            'jenis_kepemilikan' => 'required|in:milik_sendiri,subkon_armada,subkon_driver,subkon_keduanya',
            'kontrak_id' => 'nullable|exists:kontrak_subkon,id',
            'harga_sewa' => 'nullable|numeric',
            'tanggal_ganti_oli_terakhir' => 'nullable|date',
            'jarak_tempuh_ganti_oli' => 'nullable|integer',
            'tanggal_service_terakhir' => 'nullable|date',
            'jarak_tempuh_service' => 'nullable|integer',
        ]);

        $armada->update($validated);

        return redirect()->route('master.armada.index')
            ->with('success', 'Armada berhasil diperbarui.');
    }

    public function destroy(Armada $armada)
    {
        $armada->update(['status' => 'nonaktif']);
        return redirect()->route('master.armada.index')
            ->with('success', 'Armada dinonaktifkan.');
    }

    // Pengeluaran Armada
    public function pengeluaran(Armada $armada)
    {
        $pengeluaran = $armada->pengeluaran()->with('driver', 'jobOrder')->latest()->paginate(20);
        return view('master.armada.pengeluaran', compact('armada', 'pengeluaran'));
    }

    public function storePengeluaran(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:solar,sparepart,tol,parkir,preman,makan_driver,service,ban,pajak,asuransi,lainnya',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'volume_solar' => 'nullable|numeric',
            'lokasi' => 'nullable',
            'driver_id' => 'nullable|exists:drivers,id',
            'job_order_id' => 'nullable|exists:job_orders,id',
            'keterangan' => 'nullable',
            'bukti' => 'nullable|file|max:5120',
        ]);

        $validated['armada_id'] = $armada->id;
        $validated['bukti'] = $this->uploadFile($request, 'bukti', 'uploads/pengeluaran');
        PengeluaranArmada::create($validated);

        // Update level solar jika pengisian solar
        if ($validated['jenis'] === 'solar' && isset($validated['volume_solar'])) {
            $armada->increment('level_solar', $validated['volume_solar']);
            $armada->update(['tanggal_isi_solar_terakhir' => $validated['tanggal']]);
        }

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat.');
    }

    // Budget Armada
    public function budget(Armada $armada)
    {
        $budgets = $armada->budget()->orderBy('bulan', 'desc')->get();
        return view('master.armada.budget', compact('armada', 'budgets'));
    }

    public function storeBudget(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'bulan' => 'required|date_format:Y-m',
            'alokasi_solar' => 'nullable|numeric',
            'alokasi_sparepart' => 'nullable|numeric',
            'alokasi_tol_parkir' => 'nullable|numeric',
            'alokasi_lainnya' => 'nullable|numeric',
        ]);

        $validated['armada_id'] = $armada->id;
        BudgetArmada::updateOrCreate(
            ['armada_id' => $armada->id, 'bulan' => $validated['bulan']],
            $validated
        );

        return redirect()->back()->with('success', 'Budget berhasil disimpan.');
    }

    // Izin Armada
    public function izin(Armada $armada)
    {
        $izin = $armada->izin()->get();
        return view('master.armada.izin', compact('armada', 'izin'));
    }

    public function storeIzin(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'jenis_perijinan' => 'required',
            'nomor_izin' => 'nullable',
            'penerbit' => 'nullable',
            'tanggal_terbit' => 'nullable|date',
            'masa_berlaku' => 'required|date',
            'biaya_perpanjangan' => 'nullable|numeric',
            'sticker_number' => 'nullable',
            'keterangan' => 'nullable',
            'file_izin' => 'nullable|file|max:5120',
        ]);

        $validated['file_izin'] = $this->uploadFile($request, 'file_izin', 'uploads/izin');
        $armada->izin()->create($validated);

        return redirect()->back()->with('success', 'Data izin berhasil ditambahkan.');
    }
}
