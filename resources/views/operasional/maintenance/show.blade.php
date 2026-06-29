@extends('layouts.app')
@section('title', 'Detail Maintenance')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Maintenance</h2>
            <p class="text-gray-500">{{ $maintenance->armada?->nomor_polisi }} - {{ str_replace('_', ' ', $maintenance->jenis) }}</p>
        </div>
        <a href="{{ route('operasional.maintenance.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Armada</dt><dd class="text-sm font-medium">{{ $maintenance->armada?->nomor_polisi }} ({{ $maintenance->armada?->jenis_kendaraan }})</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal</dt><dd class="text-sm font-medium">{{ $maintenance->tanggal?->format('d M Y') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jenis</dt><dd class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $maintenance->jenis) }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full
                @if($maintenance->status == 'selesai') bg-green-100 text-green-700
                @elseif($maintenance->status == 'dijadwalkan') bg-blue-100 text-blue-700
                @else bg-yellow-100 text-yellow-700 @endif">{{ $maintenance->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Deskripsi</dt><dd class="text-sm font-medium">{{ $maintenance->deskripsi ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Vendor</dt><dd class="text-sm font-medium">{{ $maintenance->vendor?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Biaya Part</dt><dd class="text-sm font-medium">Rp {{ number_format($maintenance->biaya_part, 0, ',', '.') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Biaya Jasa</dt><dd class="text-sm font-medium">Rp {{ number_format($maintenance->biaya_jasa, 0, ',', '.') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Total Biaya</dt><dd class="text-sm font-bold text-navy">Rp {{ number_format($maintenance->total_biaya, 0, ',', '.') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor Nota</dt><dd class="text-sm font-medium">{{ $maintenance->nomor_nota ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">KM Tempuh</dt><dd class="text-sm font-medium">{{ $maintenance->km_tempuh ? number_format($maintenance->km_tempuh, 0, ',', '.') . ' km' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jadwal Berikutnya</dt><dd class="text-sm font-medium">{{ $maintenance->jadwal_berikutnya?->format('d M Y') ?? '-' }}</dd></div>
        </dl>
        @if($maintenance->keterangan)
        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
            <p class="text-xs text-gray-500 mb-1">Keterangan</p>
            <p class="text-sm">{{ $maintenance->keterangan }}</p>
        </div>
        @endif
        @if($maintenance->bukti)
        <div class="mt-4">
            <h3 class="text-sm font-semibold text-gray-600 mb-2">Bukti</h3>
            <a href="{{ asset('storage/' . $maintenance->bukti) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Lihat Bukti
            </a>
        </div>
        @endif
    </div>
</div>
@endsection