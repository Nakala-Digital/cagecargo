@extends('layouts.app')
@section('title', 'Detail Closing')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Closing</h2>
            <p class="text-gray-500">Bulan: {{ $closing->bulan }}</p>
        </div>
        <a href="{{ route('laporan.closing.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan</h3>
            <dl class="space-y-3">
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-gray-500">Bulan</dt>
                    <dd class="text-sm font-medium">{{ $closing->bulan }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-gray-500">Tanggal Closing</dt>
                    <dd class="text-sm font-medium">{{ $closing->tanggal_closing?->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-gray-500">Closed By</dt>
                    <dd class="text-sm font-medium">{{ $closing->closedBy?->name ?? '-' }}</dd>
                </div>
            </dl>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Profit & Loss</h3>
            <dl class="space-y-3">
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-green-600 font-medium">Revenue</dt>
                    <dd class="text-sm font-medium text-green-600">Rp {{ number_format($closing->total_revenue, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-red-600 font-medium">Cost</dt>
                    <dd class="text-sm font-medium text-red-600">Rp {{ number_format($closing->total_cost, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-t-2 border-navy">
                    <dt class="text-sm font-bold {{ $closing->total_profit >= 0 ? 'text-green-700' : 'text-red-700' }}">Profit</dt>
                    <dd class="text-sm font-bold {{ $closing->total_profit >= 0 ? 'text-green-700' : 'text-red-700' }}">Rp {{ number_format($closing->total_profit, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">AR / AP</h3>
            <dl class="space-y-3">
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-green-600 font-medium">Total AR (Piutang)</dt>
                    <dd class="text-sm font-medium text-green-600">Rp {{ number_format($closing->total_ar, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-red-600 font-medium">Total AP (Utang)</dt>
                    <dd class="text-sm font-medium text-red-600">Rp {{ number_format($closing->total_ap, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Cash Flow</h3>
            <dl class="space-y-3">
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-green-600 font-medium">Cash In</dt>
                    <dd class="text-sm font-medium text-green-600">Rp {{ number_format($closing->cash_in, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-b">
                    <dt class="text-sm text-red-600 font-medium">Cash Out</dt>
                    <dd class="text-sm font-medium text-red-600">Rp {{ number_format($closing->cash_out, 0, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between py-1.5 border-t-2 border-navy">
                    <dt class="text-sm font-bold">Net Cash</dt>
                    <dd class="text-sm font-bold {{ ($closing->cash_in - $closing->cash_out) >= 0 ? 'text-green-700' : 'text-red-700' }}">Rp {{ number_format($closing->cash_in - $closing->cash_out, 0, ',', '.') }}</dd>
                </div>
            </dl>
        </div>
    </div>

    @if($closing->catatan)
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-600 mb-2">Catatan</h3>
        <p class="text-sm">{{ $closing->catatan }}</p>
    </div>
    @endif
</div>
@endsection