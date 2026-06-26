@extends('layouts.app')
@section('title', 'Kontrak Subkon')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Kontrak Subkon</h2>
            <p class="text-gray-500">Kelola kontrak kerja dengan vendor subkon</p>
        </div>
        <a href="{{ route('master.armada.kontrak.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Kontrak Baru</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor Kontrak</th>
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Mulai</th>
                    <th class="px-6 py-3">Berakhir</th>
                    <th class="px-6 py-3">Nilai</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($kontraks as $k)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $k->nomor_kontrak }}</td>
                    <td class="px-6 py-4 text-sm">{{ $k->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $k->jenis }}</td>
                    <td class="px-6 py-4 text-sm">{{ $k->tanggal_mulai?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $k->tanggal_berakhir?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $k->nilai_kontrak ? 'Rp ' . number_format($k->nilai_kontrak, 0, ',', '.') : '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($k->status == 'aktif') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $k->status ?? 'aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('master.armada.kontrak.show', $k) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada kontrak subkon</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $kontraks->links() }}</div>
</div>
@endsection