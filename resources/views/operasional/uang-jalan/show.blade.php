@extends('layouts.app')
@section('title', 'Detail Uang Jalan')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Uang Jalan</h2>
            <p class="text-gray-500">{{ $uangJalan->nomor_uang_jalan }}</p>
        </div>
        <div class="space-x-2">
            @if($uangJalan->status == 'draft')
            <form method="POST" action="{{ route('operasional.uang-jalan.approve', $uangJalan) }}" class="inline" onsubmit="return confirm('Setujui & cairkan uang jalan ini?')">
                @csrf
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm hover:bg-green-700">Setujui & Cairkan</button>
            </form>
            @endif
            <a href="{{ route('operasional.uang-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Nomor</dt><dd class="text-sm font-medium">{{ $uangJalan->nomor_uang_jalan }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $uangJalan->status == 'approved' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ $uangJalan->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Surat Jalan</dt><dd class="text-sm font-medium"><a href="{{ route('operasional.surat-jalan.show', $uangJalan->suratJalan) }}" class="text-teal hover:text-teal-600">{{ $uangJalan->suratJalan?->nomor_surat_jalan ?? '-' }}</a></dd></div>
            <div><dt class="text-sm text-gray-500">Armada</dt><dd class="text-sm font-medium">{{ $uangJalan->armada?->nomor_polisi ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Driver</dt><dd class="text-sm font-medium">{{ $uangJalan->driver?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal</dt><dd class="text-sm font-medium">{{ $uangJalan->tanggal?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Cair</dt><dd class="text-sm font-medium">{{ $uangJalan->tanggal_dicairkan?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat Oleh</dt><dd class="text-sm font-medium">{{ $uangJalan->createdBy?->name ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Disetujui Oleh</dt><dd class="text-sm font-medium">{{ $uangJalan->approvedBy?->name ?? '-' }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Rincian Biaya</h3>
        <div class="space-y-3">
            @foreach(['solar' => 'Solar', 'tol' => 'Tol', 'parkir' => 'Parkir', 'makan_driver' => 'Makan Driver', 'preman' => 'Preman/Akamsi', 'komisi_driver' => 'Komisi Driver', 'lainnya' => 'Lainnya'] as $key => $label)
            @if($uangJalan->$key > 0)
            <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                <span class="text-sm text-gray-600">{{ $label }}</span>
                <span class="text-sm font-medium">Rp {{ number_format($uangJalan->$key, 0, ',', '.') }}</span>
            </div>
            @endif
            @endforeach
            <div class="flex justify-between py-2 border-t-2 border-navy">
                <span class="text-sm font-bold text-navy">TOTAL</span>
                <span class="text-sm font-bold text-navy">Rp {{ number_format($uangJalan->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if($uangJalan->keterangan)
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-600 mb-2">Keterangan</h3>
        <p class="text-sm">{{ $uangJalan->keterangan }}</p>
    </div>
    @endif

    @if($uangJalan->bukti)
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-600 mb-2">Bukti</h3>
        <a href="{{ asset('storage/' . $uangJalan->bukti) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Lihat Bukti
        </a>
    </div>
    @endif
</div>
@endsection