@extends('layouts.app')
@section('title', 'Profit Analysis')
@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-navy">Profit Analysis</h2>
        <p class="text-gray-500">Analisis profit per job order</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Customer</label>
                <select name="customer_id" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    <option value="">Semua Customer</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ request('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700 text-sm">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Job Order</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3 text-right">Revenue</th>
                    <th class="px-6 py-3 text-right">Cost</th>
                    <th class="px-6 py-3 text-right">Profit</th>
                    <th class="px-6 py-3 text-right">Margin</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($profits as $item)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-teal">{{ $item['nomor_jo'] }}</td>
                    <td class="px-6 py-4 text-sm">{{ $item['customer'] }}</td>
                    <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($item['revenue'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-right">Rp {{ number_format($item['cost'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-right font-medium {{ $item['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">Rp {{ number_format($item['profit'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm text-right">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $item['margin'] >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ number_format($item['margin'], 1) }}%
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50 font-semibold text-sm">
                <tr>
                    <td colspan="2" class="px-6 py-3">Total</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format(collect($profits)->sum('revenue'), 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format(collect($profits)->sum('cost'), 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format(collect($profits)->sum('profit'), 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right">{{ number_format(collect($profits)->sum('revenue') > 0 ? (collect($profits)->sum('profit') / collect($profits)->sum('revenue') * 100) : 0, 1) }}%</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="mt-4">{{ $profits->links() ?? '' }}</div>
</div>
@endsection
