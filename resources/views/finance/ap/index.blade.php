@extends('layouts.app')
@section('title', 'A/P Armada')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">A/P Armada</h2>
            <p class="text-gray-500">Utang usaha armada ke vendor</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs text-gray-500">Total Unpaid</p>
                <p class="text-lg font-bold text-red-600">Rp {{ number_format($totalUnpaid, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">Overdue</p>
                <p class="text-lg font-bold text-orange-600">Rp {{ number_format($totalOverdue, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('finance.ap.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Catat AP</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor AP</th>
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">Job Order</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jatuh Tempo</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ap as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $item->nomor_ap }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jobOrder?->nomor_jo ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $item->tipe }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($item->status == 'paid') bg-green-100 text-green-700
                            @elseif($item->status == 'overdue') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if($item->status != 'paid')
                        <form method="POST" action="{{ route('finance.ap.pay', $item) }}" class="inline" onsubmit="return confirm('Bayar AP ini?')">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-800 font-medium">Bayar</button>
                        </form>
                        @else
                        <span class="text-gray-400">Lunas</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="px-6 py-8 text-center text-gray-500">Belum ada data AP</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $ap->links() }}</div>
</div>
@endsection
