@extends('layouts.app')
@section('title', 'Master Container')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Master Container</h2>
            <p class="text-gray-500">Kelola data container</p>
        </div>
        <a href="{{ route('master.container.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah Container</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">No Container</th>
                    <th class="px-6 py-3">Size</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Shipping Line</th>
                    <th class="px-6 py-3">Seal Number</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Lokasi</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($containers as $container)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $container->nomor_container }}</td>
                    <td class="px-6 py-4 text-sm">{{ $container->size }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $container->type) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $container->shippingLine?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $container->seal_number ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $container->status == 'available' ? 'bg-green-100 text-green-700' : ($container->status == 'in_use' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700') }}">{{ str_replace('_', ' ', $container->status) }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $container->lokasi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('master.container.show', $container) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('master.container.edit', $container) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data container</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $containers->links() }}</div>
</div>
@endsection
