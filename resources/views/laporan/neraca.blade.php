@extends('layouts.app')
@section('title', 'Neraca')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Neraca</h2>
            <p class="text-gray-500">Per {{ $tanggal }}</p>
        </div>
        <form method="GET" class="flex gap-2 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $tanggal }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Tampilkan</button>
            <a href="{{ route('laporan.export-pdf', 'neraca') }}?tanggal={{ $tanggal }}" target="_blank" class="px-4 py-2 bg-navy text-white rounded-lg text-sm hover:bg-navy-700">PDF</a>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-green-700 mb-4">ASET</h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-sm text-gray-600">Kas (Penerimaan - Pengeluaran)</span>
                        <span class="text-sm font-medium">Rp {{ number_format($kas, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-sm text-gray-600">Piutang (AR)</span>
                        <span class="text-sm font-medium">Rp {{ number_format($totalAr, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-t-2 border-green-700 font-bold text-green-700">
                        <span class="text-sm">TOTAL ASET</span>
                        <span class="text-sm">Rp {{ number_format($kas + $totalAr, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-red-700 mb-4">PASIVA</h3>
                <div class="space-y-3">
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-sm text-gray-600">Utang (AP)</span>
                        <span class="text-sm font-medium">Rp {{ number_format($totalAp, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-sm text-gray-600">Modal / Laba Ditahan</span>
                        <span class="text-sm font-medium">Rp {{ number_format($equity, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-t-2 border-red-700 font-bold text-red-700">
                        <span class="text-sm">TOTAL PASIVA</span>
                        <span class="text-sm">Rp {{ number_format($totalAp + $equity, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
        <p class="text-sm text-gray-500">Total Revenue: Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        <p class="text-sm text-gray-500">Total Cost: Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
        <p class="text-sm font-semibold {{ $totalRevenue - $totalCost >= 0 ? 'text-green-600' : 'text-red-600' }}">Laba Ditahan: Rp {{ number_format($totalRevenue - $totalCost, 0, ',', '.') }}</p>
    </div>
</div>
@endsection