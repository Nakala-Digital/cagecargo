@extends('layouts.app')
@section('title', 'Finance')
@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-navy">Finance</h2>
        <p class="text-gray-500">Overview keuangan dan invoice</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-teal">
            <p class="text-sm text-gray-500 font-medium">Total Revenue</p>
            <p class="text-3xl font-bold text-navy mt-1">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <p class="text-sm text-gray-500 font-medium">Outstanding</p>
            <p class="text-3xl font-bold text-navy mt-1">Rp {{ number_format($outstanding ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-500 font-medium">Total Cost</p>
            <p class="text-3xl font-bold text-navy mt-1">Rp {{ number_format($totalCost ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <h3 class="text-lg font-semibold text-navy">Daftar Invoice</h3>
        <div class="space-x-2">
            <a href="{{ route('finance.profit') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Profit Analysis</a>
            <a href="{{ route('finance.export') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Export Data</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">No Invoice</th>
                    <th class="px-6 py-3">Job Order</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Jatuh Tempo</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-teal">{{ $inv->nomor_invoice }}</td>
                    <td class="px-6 py-4 text-sm">{{ $inv->jobOrder?->nomor_jo ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $inv->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($inv->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $inv->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($inv->status == 'paid') bg-green-100 text-green-700
                            @elseif($inv->status == 'unpaid') bg-red-100 text-red-700
                            @elseif(in_array($inv->status, ['partial', 'partially_paid'])) bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $inv->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('finance.show', $inv) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada invoice</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $invoices->links() }}</div>
</div>
@endsection
