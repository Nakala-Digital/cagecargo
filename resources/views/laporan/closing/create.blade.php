@extends('layouts.app')
@section('title', 'Closing Bulanan Baru')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Closing Bulanan</h2>
            <p class="text-gray-500">Tutup periode bulanan & hitung summary</p>
        </div>
        <a href="{{ route('laporan.closing.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        @if($availableMonths->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">Semua bulan sudah di-closing.</p>
            <a href="{{ route('laporan.closing.index') }}" class="mt-4 inline-block px-4 py-2 bg-teal text-white rounded-lg text-sm">Kembali</a>
        </div>
        @else
        <form method="POST" action="{{ route('laporan.closing.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Bulan</label>
                    <select name="bulan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Bulan --</option>
                        @foreach($availableMonths as $val => $label)
                        <option value="{{ $val }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-800">
                    <p class="font-medium">Perhatian:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        <li>Closing akan menghitung revenue, cost, AR, AP, dan cash flow untuk bulan tersebut</li>
                        <li>Setelah di-closing, data periode tersebut terkunci (tidak bisa diedit)</li>
                        <li>Pastikan semua transaksi bulan tersebut sudah lengkap</li>
                    </ul>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('laporan.closing.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Proses Closing</button>
            </div>
        </form>
        @endif
    </div>
</div>
@endsection