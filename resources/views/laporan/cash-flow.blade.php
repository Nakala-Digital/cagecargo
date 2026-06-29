@extends('layouts.app')
@section('title', 'Cash Flow')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Cash Flow</h2>
            <p class="text-gray-500">Arus kas periode {{ $from }} s/d {{ $to }}</p>
        </div>
        <form method="GET" class="flex gap-2 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Dari</label>
                <input type="date" name="from" value="{{ $from }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
                <input type="date" name="to" value="{{ $to }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Tampilkan</button>
            <a href="{{ route('laporan.export-pdf', 'cash-flow') }}?from={{ $from }}&to={{ $to }}" target="_blank" class="px-4 py-2 bg-navy text-white rounded-lg text-sm hover:bg-navy-700">PDF</a>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Cash In (Penerimaan)</p>
            <p class="text-3xl font-bold text-green-600 mt-1">Rp {{ number_format($cashIn, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Cash Out (Pengeluaran)</p>
            <p class="text-3xl font-bold text-red-600 mt-1">Rp {{ number_format($cashOut, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ $netCash >= 0 ? 'border-teal' : 'border-red-500' }}">
            <p class="text-sm text-gray-500">Net Cash Flow</p>
            <p class="text-3xl font-bold {{ $netCash >= 0 ? 'text-teal' : 'text-red-600' }} mt-1">Rp {{ number_format($netCash, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-green-700 mb-4">Cash In Detail</h3>
            <div class="space-y-2">
                @forelse($cashInByMetode as $metode => $total)
                <div class="flex justify-between py-1.5 border-b border-gray-50">
                    <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $metode) }}</span>
                    <span class="text-sm font-medium text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400">Belum ada penerimaan</p>
                @endforelse
                <div class="flex justify-between py-2 border-t-2 border-green-700 font-bold">
                    <span class="text-sm text-green-700">Total Penerimaan</span>
                    <span class="text-sm text-green-700">Rp {{ number_format($cashIn, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-red-700 mb-4">Cash Out Detail</h3>
            <div class="space-y-2">
                <div class="flex justify-between py-1.5 border-b border-gray-50">
                    <span class="text-sm text-gray-600">Pembayaran AP</span>
                    <span class="text-sm font-medium text-red-600">Rp {{ number_format($apPaid ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-1.5 border-b border-gray-50">
                    <span class="text-sm text-gray-600">Pengeluaran Operasional</span>
                    <span class="text-sm font-medium text-red-600">Rp {{ number_format($pengeluaranApproved ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2 border-t-2 border-red-700 font-bold">
                    <span class="text-sm text-red-700">Total Pengeluaran</span>
                    <span class="text-sm text-red-700">Rp {{ number_format($cashOut, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection