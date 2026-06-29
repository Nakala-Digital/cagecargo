@extends('layouts.app')
@section('title', 'Aging AR/AP')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Aging AR/AP</h2>
            <p class="text-gray-500">Analisa umur piutang & utang</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('laporan.aging', ['type' => 'ar']) }}" class="px-4 py-2 rounded-lg text-sm {{ $type == 'ar' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">AR (Piutang)</a>
            <a href="{{ route('laporan.aging', ['type' => 'ap']) }}" class="px-4 py-2 rounded-lg text-sm {{ $type == 'ap' ? 'bg-teal text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">AP (Utang)</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
        @foreach(['0-30', '31-60', '61-90', '90+'] as $bucket)
        <div class="bg-white rounded-xl shadow-sm p-4">
            <p class="text-sm font-semibold text-gray-600 mb-1">{{ $bucket }} Hari</p>
            <p class="text-2xl font-bold {{ $bucket == '90+' ? 'text-red-600' : 'text-navy' }}">Rp {{ number_format($aging[$bucket]['total'], 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400">{{ $aging[$bucket]['items']->count() }} item</p>
        </div>
        @endforeach
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">{{ $type == 'ar' ? 'Customer' : 'Vendor' }}</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Jatuh Tempo</th>
                    <th class="px-6 py-3">Umur (Hari)</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Bucket</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php $allItems = collect(); @endphp
                @foreach($aging as $bucket => $data)
                @php $allItems = $allItems->concat($data['items']->map(fn($i) => ['item' => $i, 'bucket' => $bucket])); @endphp
                @endforeach
                @forelse($allItems->sortByDesc(fn($i) => $i['item']->jumlah) as $row)
                @php $item = $row['item']; $bucket = $row['bucket']; @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $item->nomor_ap ?? $item->nomor_ar }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->customer?->nama ?? $item->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->tanggal?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item->jatuh_tempo ? now()->diffInDays($item->jatuh_tempo, false) : '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            @if($bucket == '90+') bg-red-100 text-red-700
                            @elseif($bucket == '61-90') bg-orange-100 text-orange-700
                            @elseif($bucket == '31-60') bg-yellow-100 text-yellow-700
                            @else bg-green-100 text-green-700 @endif">{{ $bucket }} hari</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada item</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection