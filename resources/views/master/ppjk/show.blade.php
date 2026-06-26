@extends('layouts.app')
@section('title', 'Detail PPJK')
@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail PPJK</h2>
            <p class="text-gray-500">{{ $ppjk->code }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('master.ppjk.edit', $ppjk) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('master.ppjk.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Kode</dt><dd class="text-sm font-medium">{{ $ppjk->code }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor Izin</dt><dd class="text-sm font-medium">{{ $ppjk->nomor_izin ?? '-' }}</dd></div>
            <div class="col-span-2"><dt class="text-sm text-gray-500">Nama Perusahaan</dt><dd class="text-sm font-medium">{{ $ppjk->nama_perusahaan }}</dd></div>
            <div><dt class="text-sm text-gray-500">PIC</dt><dd class="text-sm font-medium">{{ $ppjk->pic ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Email</dt><dd class="text-sm font-medium">{{ $ppjk->email ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Phone</dt><dd class="text-sm font-medium">{{ $ppjk->phone ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Masa Berlaku Izin</dt><dd class="text-sm font-medium">{{ $ppjk->masa_berlaku_izin?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Jenis Layanan</dt><dd class="text-sm font-medium">{{ $ppjk->jenis_layanan ?? '-' }}</dd></div>
            <div class="col-span-2"><dt class="text-sm text-gray-500">Alamat</dt><dd class="text-sm font-medium">{{ $ppjk->alamat ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $ppjk->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $ppjk->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat</dt><dd class="text-sm font-medium">{{ $ppjk->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>
</div>
@endsection
