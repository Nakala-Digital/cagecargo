@extends('layouts.app')
@section('title', 'Detail Container')
@section('content')
<div class="max-w-3xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Container</h2>
            <p class="text-gray-500">{{ $container->nomor_container }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('master.container.edit', $container) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('master.container.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div class="col-span-2"><dt class="text-sm text-gray-500">Nomor Container</dt><dd class="text-sm font-medium">{{ $container->nomor_container }}</dd></div>
            <div><dt class="text-sm text-gray-500">Size</dt><dd class="text-sm font-medium">{{ $container->size }}</dd></div>
            <div><dt class="text-sm text-gray-500">Type</dt><dd class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $container->type) }}</dd></div>
            <div><dt class="text-sm text-gray-500">Shipping Line</dt><dd class="text-sm font-medium">{{ $container->shippingLine?->nama ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Seal Number</dt><dd class="text-sm font-medium">{{ $container->seal_number ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Lokasi</dt><dd class="text-sm font-medium">{{ $container->lokasi ?? '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Max Weight</dt><dd class="text-sm font-medium">{{ $container->max_weight ? number_format($container->max_weight, 0, ',', '.') . ' kg' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Tare Weight</dt><dd class="text-sm font-medium">{{ $container->tare_weight ? number_format($container->tare_weight, 0, ',', '.') . ' kg' : '-' }}</dd></div>
            <div><dt class="text-sm text-gray-500">Status</dt><dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $container->status == 'available' ? 'bg-green-100 text-green-700' : ($container->status == 'in_use' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">{{ str_replace('_', ' ', $container->status) }}</span></dd></div>
            <div><dt class="text-sm text-gray-500">Dibuat</dt><dd class="text-sm font-medium">{{ $container->created_at->format('d M Y H:i') }}</dd></div>
        </dl>
    </div>
</div>
@endsection
