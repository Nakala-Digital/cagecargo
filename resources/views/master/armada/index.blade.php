@extends('layouts.app')
@section('title', 'Master Armada')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Master Armada</h2>
            <p class="text-gray-500">Kelola data armada kendaraan</p>
        </div>
        <a href="{{ route('master.armada.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah Armada</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">No Polisi</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Merk</th>
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">GPS Device</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($armadas as $armada)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $armada->nomor_polisi }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $armada->jenis_kendaraan) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $armada->merk ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $armada->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $armada->gps_device_id ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $armada->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $armada->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('master.armada.show', $armada) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('master.armada.edit', $armada) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data armada</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $armadas->links() }}</div>
</div>
@endsection
