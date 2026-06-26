@extends('layouts.app')
@section('title', 'Detail Armada')
@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Armada</h2>
            <p class="text-gray-500">{{ $armada->nomor_polisi }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('master.armada.edit', $armada) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('master.armada.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Nomor Polisi</dt><dd class="text-sm font-medium">{{ $armada->nomor_polisi }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jenis Kendaraan</dt><dd class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $armada->jenis_kendaraan) }}</dd></div>
            <div><dt class="text-sm text-gray-500">Merk</dt><dd class="text-sm font-medium">{{ $armada->merk ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tahun</dt><dd class="text-sm font-medium">{{ $armada->tahun ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor Mesin</dt><dd class="text-sm font-medium">{{ $armada->nomor_mesin ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor Rangka</dt><dd class="text-sm font-medium">{{ $armada->nomor_rangka ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Kapasitas</dt><dd class="text-sm font-medium">{{ $armada->kapasitas ? number_format($armada->kapasitas, 0, ',', '.') . ' kg' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Vendor</dt><dd class="text-sm font-medium">{{ $armada->vendor?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">GPS Device ID</dt><dd class="text-sm font-medium">{{ $armada->gps_device_id ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">RFID Tag</dt><dd class="text-sm font-medium">{{ $armada->rfid_tag ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $armada->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $armada->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat</dt><dd class="text-sm font-medium">{{ $armada->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>

    @if($armada->dokumen->count())
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Dokumen Armada</h3>
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Nomor</th>
                    <th class="px-4 py-2">Terbit</th>
                    <th class="px-4 py-2">Expired</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($armada->dokumen as $d)
                <tr class="text-sm">
                    <td class="px-4 py-2">{{ $d->jenis_dokumen }}</td>
                    <td class="px-4 py-2">{{ $d->nomor_dokumen }}</td>
                    <td class="px-4 py-2">{{ $d->tanggal_terbit?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $d->tanggal_expired?->format('d M Y') ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Informasi Kepemilikan & Kontrak</h3>
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Jenis Armada</dt><dd class="text-sm font-medium">{{ $armada->jenisArmada?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jenis Kepemilikan</dt><dd class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $armada->jenis_kepemilikan ?? '-') }}</dd></div>
            @if($armada->kontrak)
            <div><dt class="text-sm text-gray-500">Nomor Kontrak</dt><dd class="text-sm font-medium">{{ $armada->kontrak->nomor_kontrak }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nilai Kontrak</dt><dd class="text-sm font-medium">{{ $armada->kontrak->nilai_kontrak ? 'Rp ' . number_format($armada->kontrak->nilai_kontrak, 0, ',', '.') : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Masa Berlaku</dt><dd class="text-sm font-medium">{{ $armada->kontrak->tanggal_mulai?->format('d M Y') }} - {{ $armada->kontrak->tanggal_berakhir?->format('d M Y') }}</dd></div>
            @endif
            <div><dt class="text-sm text-gray-500">Harga Sewa</dt><dd class="text-sm font-medium">{{ $armada->harga_sewa ? 'Rp ' . number_format($armada->harga_sewa, 0, ',', '.') : '-' }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Perawatan & Solar</h3>
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Level Solar</dt><dd class="text-sm font-medium">{{ $armada->level_solar ? $armada->level_solar . '%' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Isi Solar Terakhir</dt><dd class="text-sm font-medium">{{ $armada->tanggal_isi_solar_terakhir?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Ganti Oli Terakhir</dt><dd class="text-sm font-medium">{{ $armada->tanggal_ganti_oli_terakhir?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jarak Tempuh Ganti Oli</dt><dd class="text-sm font-medium">{{ $armada->jarak_tempuh_ganti_oli ? number_format($armada->jarak_tempuh_ganti_oli, 0, ',', '.') . ' km' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Service Terakhir</dt><dd class="text-sm font-medium">{{ $armada->tanggal_service_terakhir?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jarak Tempuh Service</dt><dd class="text-sm font-medium">{{ $armada->jarak_tempuh_service ? number_format($armada->jarak_tempuh_service, 0, ',', '.') . ' km' : '-' }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Surat Jalan</h3>
        @if($armada->suratJalan->count())
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">Nomor</th>
                    <th class="px-4 py-2">Tujuan</th>
                    <th class="px-4 py-2">Berangkat</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($armada->suratJalan->sortByDesc('tanggal_berangkat')->take(10) as $sj)
                <tr class="text-sm">
                    <td class="px-4 py-2">{{ $sj->nomor_surat_jalan }}</td>
                    <td class="px-4 py-2">{{ $sj->tujuan }}</td>
                    <td class="px-4 py-2">{{ $sj->tanggal_berangkat?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-2"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $sj->status == 'selesai' ? 'bg-green-100 text-green-700' : ($sj->status == 'dalam_perjalanan' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700') }}">{{ str_replace('_', ' ', $sj->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-sm text-gray-400">Belum ada surat jalan.</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Pengeluaran</h3>
        @php $totalPengeluaran = $armada->pengeluaran->sum('jumlah'); @endphp
        @if($armada->pengeluaran->count())
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($armada->pengeluaran->sortByDesc('tanggal')->take(10) as $p)
                <tr class="text-sm">
                    <td class="px-4 py-2">{{ $p->tanggal?->format('d M Y') }}</td>
                    <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $p->jenis) }}</td>
                    <td class="px-4 py-2">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td class="px-4 py-2"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $p->status == 'approved' ? 'bg-green-100 text-green-700' : ($p->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $p->status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 text-right text-sm font-semibold text-navy">
            Total: Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </div>
        @else
        <p class="text-sm text-gray-400">Belum ada pengeluaran.</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Budget {{ now()->format('F Y') }}</h3>
        @php $budget = $armada->budgetBulanIni; @endphp
        @if($budget)
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1">Solar</p>
                <p class="text-sm font-medium">Alokasi: Rp {{ number_format($budget->alokasi_solar, 0, ',', '.') }}</p>
                <p class="text-sm font-medium">Realisasi: Rp {{ number_format($budget->realisasi_solar, 0, ',', '.') }}</p>
                <p class="text-sm font-medium {{ $budget->sisa_solar < 0 ? 'text-red-600' : 'text-green-600' }}">Sisa: Rp {{ number_format($budget->sisa_solar, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1">Sparepart</p>
                <p class="text-sm font-medium">Alokasi: Rp {{ number_format($budget->alokasi_sparepart, 0, ',', '.') }}</p>
                <p class="text-sm font-medium">Realisasi: Rp {{ number_format($budget->realisasi_sparepart, 0, ',', '.') }}</p>
                <p class="text-sm font-medium {{ $budget->sisa_sparepart < 0 ? 'text-red-600' : 'text-green-600' }}">Sisa: Rp {{ number_format($budget->sisa_sparepart, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1">Tol & Parkir</p>
                <p class="text-sm font-medium">Alokasi: Rp {{ number_format($budget->alokasi_tol_parkir, 0, ',', '.') }}</p>
                <p class="text-sm font-medium">Realisasi: Rp {{ number_format($budget->realisasi_tol_parkir, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 mb-1">Lainnya</p>
                <p class="text-sm font-medium">Alokasi: Rp {{ number_format($budget->alokasi_lainnya, 0, ',', '.') }}</p>
                <p class="text-sm font-medium">Realisasi: Rp {{ number_format($budget->realisasi_lainnya, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="mt-3 p-3 bg-navy-50 rounded-lg flex justify-between">
            <span class="text-sm font-semibold text-navy">Total Alokasi: Rp {{ number_format($budget->total_alokasi, 0, ',', '.') }}</span>
            <span class="text-sm font-semibold text-navy">Total Realisasi: Rp {{ number_format($budget->total_realisasi, 0, ',', '.') }}</span>
        </div>
        @else
        <p class="text-sm text-gray-400">Belum ada budget untuk bulan ini.</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6 mb-8">
        <h3 class="text-lg font-semibold text-navy mb-4">Perijinan</h3>
        @if($armada->izin->count())
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Nomor</th>
                    <th class="px-4 py-2">Penerbit</th>
                    <th class="px-4 py-2">Terbit</th>
                    <th class="px-4 py-2">Masa Berlaku</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($armada->izin as $i)
                <tr class="text-sm">
                    <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $i->jenis_perijinan) }}</td>
                    <td class="px-4 py-2">{{ $i->nomor_izin }}</td>
                    <td class="px-4 py-2">{{ $i->penerbit ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $i->tanggal_terbit?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $i->masa_berlaku?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-2"><span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $i->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $i->status }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p class="text-sm text-gray-400">Belum ada data perijinan.</p>
        @endif
    </div>
</div>
@endsection
