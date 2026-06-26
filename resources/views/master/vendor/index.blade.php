@extends('layouts.app')
@section('title', 'Master Vendor')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Master Vendor</h2>
            <p class="text-gray-500">Kelola data vendor transport, gudang, trucking</p>
        </div>
        <a href="{{ route('master.vendor.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah Vendor</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($vendors as $vendor)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $vendor->code }}</td>
                    <td class="px-6 py-4 text-sm">{{ $vendor->nama }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $vendor->tipe) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $vendor->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $vendor->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $vendor->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $vendor->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('master.vendor.show', $vendor) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('master.vendor.edit', $vendor) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data vendor</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $vendors->links() }}</div>
</div>
@endsection
