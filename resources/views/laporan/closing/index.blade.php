@extends('layouts.app')
@section('title', 'Closing Bulanan')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Closing Bulanan</h2>
            <p class="text-gray-500">Riwayat closing bulanan</p>
        </div>
        <a href="{{ route('laporan.closing.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Closing Bulan</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Bulan</th>
                    <th class="px-6 py-3">Tanggal Closing</th>
                    <th class="px-6 py-3">Revenue</th>
                    <th class="px-6 py-3">Cost</th>
                    <th class="px-6 py-3">Profit</th>
                    <th class="px-6 py-3">Closed By</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($closings as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $c->bulan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $c->tanggal_closing?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($c->total_revenue, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($c->total_cost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm font-medium {{ $c->total_profit >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($c->total_profit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $c->closedBy?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('laporan.closing.show', $c) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada closing bulanan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $closings->links() }}</div>
</div>
@endsection