@extends('layouts.app')
@section('title', 'Outstanding')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Outstanding</h2>
            <p class="text-gray-500">Tagihan yang belum dibayar</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs text-gray-500">Total Outstanding</p>
                <p class="text-lg font-bold {{ $type == 'ap' ? 'text-red-600' : 'text-green-600' }}">Rp {{ number_format($total, 0, ',', '.') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('laporan.outstanding', ['type' => 'ar']) }}" class="px-3 py-1.5 rounded-lg text-xs {{ $type == 'ar' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700' }}">AR</a>
                <a href="{{ route('laporan.outstanding', ['type' => 'ap']) }}" class="px-3 py-1.5 rounded-lg text-xs {{ $type == 'ap' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700' }}">AP</a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">{{ $type == 'ar' ? 'Customer' : 'Vendor' }}</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jatuh Tempo</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $item->nomor_ap ?? $item->nomor_ar }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->customer?->nama ?? $item->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $item->tipe }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->tanggal?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($item->status == 'overdue') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">{{ $item->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada outstanding</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection