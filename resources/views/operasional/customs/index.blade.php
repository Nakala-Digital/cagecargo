@extends('layouts.app')
@section('title', 'Customs Clearance')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Customs Clearance</h2>
            <p class="text-gray-500">Kelola data kepabeanan</p>
        </div>
        <a href="{{ route('operasional.customs.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah Customs</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor JO</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">No PIB/PEB</th>
                    <th class="px-6 py-3">Jalur</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($customsList as $customs)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-teal">{{ $customs->jobOrder?->nomor_jo ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $customs->jobOrder?->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $customs->jenis }}</td>
                    <td class="px-6 py-4 text-sm">{{ $customs->nomor_pib_peb ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($customs->jalur == 'hijau') bg-green-100 text-green-700
                            @elseif($customs->jalur == 'kuning') bg-yellow-100 text-yellow-700
                            @elseif($customs->jalur == 'merah') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($customs->jalur ?? '-') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($customs->status == 'waiting_clearance') bg-yellow-100 text-yellow-700
                            @elseif($customs->status == 'under_inspection') bg-blue-100 text-blue-700
                            @elseif($customs->status == 'released') bg-green-100 text-green-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $customs->status ?? '-')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('operasional.customs.show', $customs) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('operasional.customs.edit', $customs) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data customs</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $customsList->links() }}</div>
</div>
@endsection
