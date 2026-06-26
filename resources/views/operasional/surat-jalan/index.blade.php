@extends('layouts.app')
@section('title', 'Surat Jalan')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Surat Jalan</h2>
            <p class="text-gray-500">Monitoring surat jalan armada</p>
        </div>
        <a href="{{ route('operasional.surat-jalan.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Terbitkan Surat Jalan</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Armada</th>
                    <th class="px-6 py-3">Driver</th>
                    <th class="px-6 py-3">Tujuan</th>
                    <th class="px-6 py-3">Berangkat</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suratJalan as $sj)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $sj->nomor_surat_jalan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $sj->jobOrder?->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $sj->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $sj->driver?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $sj->tujuan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $sj->tanggal_berangkat?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($sj->status == 'diterbitkan') bg-blue-100 text-blue-700
                            @elseif($sj->status == 'dalam_perjalanan') bg-yellow-100 text-yellow-700
                            @elseif($sj->status == 'selesai') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ str_replace('_', ' ', $sj->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('operasional.surat-jalan.show', $sj) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada surat jalan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $suratJalan->links() }}</div>
</div>
@endsection