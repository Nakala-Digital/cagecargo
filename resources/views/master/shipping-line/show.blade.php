@extends('layouts.app')
@section('title', 'Detail Shipping Line')
@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Shipping Line</h2>
            <p class="text-gray-500">{{ $shippingLine->code }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('master.shipping-line.edit', $shippingLine) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('master.shipping-line.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Kode</dt><dd class="text-sm font-medium">{{ $shippingLine->code }}</dd></div>
            <div class="col-span-2"><dt class="text-sm text-gray-500">Nama Perusahaan</dt><dd class="text-sm font-medium">{{ $shippingLine->nama }}</dd></div>
            <div><dt class="text-sm text-gray-500">Email</dt><dd class="text-sm font-medium">{{ $shippingLine->email ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Phone</dt><dd class="text-sm font-medium">{{ $shippingLine->phone ?? '-' }}</dd></div>
            <div class="col-span-2"><dt class="text-sm text-gray-500">Alamat</dt><dd class="text-sm font-medium">{{ $shippingLine->alamat ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $shippingLine->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $shippingLine->status }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat</dt><dd class="text-sm font-medium">{{ $shippingLine->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>
</div>
@endsection
