@extends('layouts.app')
@section('title', 'Detail Surat Jalan')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Surat Jalan</h2>
            <p class="text-gray-500">{{ $suratJalan->nomor_surat_jalan }}</p>
        </div>
        <div class="space-x-2">
            <form method="POST" action="{{ route('operasional.surat-jalan.dummy-invoice', $suratJalan) }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Generate Invoice</button>
            </form>
            <a href="{{ route('operasional.surat-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Nomor Surat Jalan</dt><dd class="text-sm font-medium">{{ $suratJalan->nomor_surat_jalan }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full
                @if($suratJalan->status == 'diterbitkan') bg-blue-100 text-blue-700
                @elseif($suratJalan->status == 'dalam_perjalanan') bg-yellow-100 text-yellow-700
                @elseif($suratJalan->status == 'selesai') bg-green-100 text-green-700
                @else bg-red-100 text-red-700 @endif">{{ str_replace('_', ' ', $suratJalan->status) }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Job Order</dt><dd class="text-sm font-medium"><a href="{{ route('operasional.job-order.show', $suratJalan->jobOrder) }}" class="text-teal hover:text-teal-600">{{ $suratJalan->jobOrder?->nomor_jo ?? '-' }}</a></dd></div>
            <div><dt class="text-sm text-gray-500">Customer</dt><dd class="text-sm font-medium">{{ $suratJalan->jobOrder?->customer?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Armada</dt><dd class="text-sm font-medium">{{ $suratJalan->armada?->nomor_polisi ?? '-' }} ({{ $suratJalan->armada?->jenisArmada?->nama ?? $suratJalan->armada?->jenis_kendaraan ?? '-' }})</dd></div>
            <div><dt class="text-sm text-gray-500">Driver</dt><dd class="text-sm font-medium">{{ $suratJalan->driver?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tujuan</dt><dd class="text-sm font-medium">{{ $suratJalan->tujuan }}</dd></div>
            <div><dt class="text-sm text-gray-500">Rute</dt><dd class="text-sm font-medium">{{ $suratJalan->rute ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Berangkat</dt><dd class="text-sm font-medium">{{ $suratJalan->tanggal_berangkat?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Perkiraan Kembali</dt><dd class="text-sm font-medium">{{ $suratJalan->tanggal_perkiraan_kembali?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tanggal Kembali</dt><dd class="text-sm font-medium">{{ $suratJalan->tanggal_kembali?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jenis Muatan</dt><dd class="text-sm font-medium">{{ $suratJalan->jenis_muatan ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Berat Muatan</dt><dd class="text-sm font-medium">{{ $suratJalan->berat_muatan ? number_format($suratJalan->berat_muatan, 0, ',', '.') . ' kg' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Biaya Angkut</dt><dd class="text-sm font-medium">{{ $suratJalan->biaya_angkut ? 'Rp ' . number_format($suratJalan->biaya_angkut, 0, ',', '.') : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat Oleh</dt><dd class="text-sm font-medium">{{ $suratJalan->createdBy?->name ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Catatan</dt><dd class="text-sm font-medium">{{ $suratJalan->catatan ?? '-' }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Update Status</h3>
        <form method="POST" action="{{ route('operasional.surat-jalan.status', $suratJalan) }}" class="flex items-end gap-4">
            @csrf @method('PATCH')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    <option value="diterbitkan" @if($suratJalan->status == 'diterbitkan') selected @endif>Diterbitkan</option>
                    <option value="dalam_perjalanan" @if($suratJalan->status == 'dalam_perjalanan') selected @endif>Dalam Perjalanan</option>
                    <option value="selesai" @if($suratJalan->status == 'selesai') selected @endif>Selesai</option>
                    <option value="bermasalah" @if($suratJalan->status == 'bermasalah') selected @endif>Bermasalah</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" value="{{ $suratJalan->tanggal_kembali?->format('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <input type="text" name="catatan" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" value="{{ $suratJalan->catatan }}">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Update</button>
        </form>
    </div>
</div>
@endsection
