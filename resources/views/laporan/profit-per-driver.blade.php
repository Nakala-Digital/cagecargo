@extends('layouts.app')
@section('title', 'Profit per Driver')
@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-navy">Profit per Driver</h2>
        <p class="text-gray-500">Analisa profitabilitas per driver</p>
    </div>

    <form method="GET" class="flex gap-4 items-end bg-white rounded-xl shadow-sm p-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Dari</label>
            <input type="date" name="from" value="{{ $from ?? '' }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
            <input type="date" name="to" value="{{ $to ?? '' }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
        </div>
        <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Filter</button>
        <a href="{{ route('laporan.profit-per-driver') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Reset</a>
    </form>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Driver</th>
                    <th class="px-6 py-3">Revenue</th>
                    <th class="px-6 py-3">Total Cost</th>
                    <th class="px-6 py-3">Profit</th>
                    <th class="px-6 py-3">Margin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($drivers as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $row->d->nama }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($row->revenue, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($row->totalCost, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm font-medium {{ $row->profit >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($row->profit, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $row->margin >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $row->margin }}%</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection