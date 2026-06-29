@extends('layouts.app')
@section('title', 'Reminder Jatuh Tempo')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Reminder Jatuh Tempo</h2>
            <p class="text-gray-500">Tagihan yang akan & sudah jatuh tempo (14 hari)</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.reminder', ['type' => 'ar']) }}" class="px-3 py-1.5 rounded-lg text-xs {{ $type == 'ar' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700' }}">AR</a>
            <a href="{{ route('laporan.reminder', ['type' => 'ap']) }}" class="px-3 py-1.5 rounded-lg text-xs {{ $type == 'ap' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700' }}">AP</a>
        </div>
    </div>

    @if($items->isEmpty())
    <div class="bg-white rounded-xl shadow-sm p-8 text-center">
        <p class="text-gray-500">Tidak ada tagihan yang perlu diingatkan dalam 14 hari ke depan.</p>
    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">{{ $type == 'ar' ? 'Customer' : 'Vendor' }}</th>
                    <th class="px-6 py-3">Jatuh Tempo</th>
                    <th class="px-6 py-3">Sisa Hari</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Prioritas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($items as $item)
                @php
                    $daysLeft = now()->diffInDays($item->jatuh_tempo, false);
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $item->nomor_ap ?? $item->nomor_ar }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->customer?->nama ?? $item->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jatuh_tempo?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm {{ $daysLeft < 0 ? 'text-red-600 font-bold' : ($daysLeft <= 3 ? 'text-orange-600 font-bold' : '') }}">
                        {{ $daysLeft < 0 ? 'Terlambat ' . abs($daysLeft) . ' hari' : $daysLeft . ' hari lagi' }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($daysLeft < 0) bg-red-100 text-red-700
                            @elseif($daysLeft <= 3) bg-orange-100 text-orange-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            @if($daysLeft < 0) Overdue
                            @elseif($daysLeft <= 3) Urgent
                            @else Mendekati @endif
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection