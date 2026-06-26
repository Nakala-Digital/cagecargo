@extends('layouts.app')
@section('title', 'Detail Driver')
@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Driver</h2>
            <p class="text-gray-500">{{ $driver->nik }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('master.driver.edit', $driver) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('master.driver.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">NIK</dt><dd class="text-sm font-medium">{{ $driver->nik }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nama Lengkap</dt><dd class="text-sm font-medium">{{ $driver->nama }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor SIM</dt><dd class="text-sm font-medium">{{ $driver->nomor_sim ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Masa Berlaku SIM</dt><dd class="text-sm font-medium">{{ $driver->masa_berlaku_sim?->format('d M Y') ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Nomor HP</dt><dd class="text-sm font-medium">{{ $driver->nomor_hp ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Email</dt><dd class="text-sm font-medium">{{ $driver->email ?? '-' }}</dd></div>
            <div class="col-span-2"><dt class="text-sm text-gray-500">Alamat</dt><dd class="text-sm font-medium">{{ $driver->alamat ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Vendor</dt><dd class="text-sm font-medium">{{ $driver->vendor?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $driver->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $driver->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat</dt><dd class="text-sm font-medium">{{ $driver->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>
</div>
@endsection
