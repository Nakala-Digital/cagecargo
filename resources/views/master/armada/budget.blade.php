@extends('layouts.app')
@section('title', 'Budget Armada')
@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Budget Armada</h2>
            <p class="text-gray-500">{{ $armada->nomor_polisi }} - {{ $armada->merk ?? '' }}</p>
        </div>
        <a href="{{ route('master.armada.show', $armada) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Tambah / Edit Budget</h3>
            <form method="POST" action="{{ route('master.armada.budget.store', $armada) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan *</label>
                    <input type="month" name="bulan" value="{{ old('bulan', $budget->bulan ?? date('Y-m')) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('bulan') border-red-500 @enderror">
                    @error('bulan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi Solar</label>
                    <input type="number" name="alokasi_solar" value="{{ old('alokasi_solar', $budget->alokasi_solar ?? '') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi Sparepart</label>
                    <input type="number" name="alokasi_sparepart" value="{{ old('alokasi_sparepart', $budget->alokasi_sparepart ?? '') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi Tol & Parkir</label>
                    <input type="number" name="alokasi_tol_parkir" value="{{ old('alokasi_tol_parkir', $budget->alokasi_tol_parkir ?? '') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alokasi Lainnya</label>
                    <input type="number" name="alokasi_lainnya" value="{{ old('alokasi_lainnya', $budget->alokasi_lainnya ?? '') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('catatan', $budget->catatan ?? '') }}</textarea>
                </div>
                <button type="submit" class="w-full px-4 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600 font-medium">Simpan Budget</button>
            </form>
        </div>

        <div class="space-y-6">
            @if(isset($budget) && $budget->exists)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Ringkasan Budget {{ \Carbon\Carbon::parse($budget->bulan . '-01')->format('F Y') }}</h3>
                <div class="space-y-3">
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Solar</p>
                        <div class="flex justify-between text-sm">
                            <span>Alokasi: Rp {{ number_format($budget->alokasi_solar, 0, ',', '.') }}</span>
                            <span>Realisasi: Rp {{ number_format($budget->realisasi_solar, 0, ',', '.') }}</span>
                            <span class="{{ $budget->sisa_solar < 0 ? 'text-red-600' : 'text-green-600' }}">Sisa: Rp {{ number_format($budget->sisa_solar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Sparepart</p>
                        <div class="flex justify-between text-sm">
                            <span>Alokasi: Rp {{ number_format($budget->alokasi_sparepart, 0, ',', '.') }}</span>
                            <span>Realisasi: Rp {{ number_format($budget->realisasi_sparepart, 0, ',', '.') }}</span>
                            <span class="{{ $budget->sisa_sparepart < 0 ? 'text-red-600' : 'text-green-600' }}">Sisa: Rp {{ number_format($budget->sisa_sparepart, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Tol & Parkir</p>
                        <div class="flex justify-between text-sm">
                            <span>Alokasi: Rp {{ number_format($budget->alokasi_tol_parkir, 0, ',', '.') }}</span>
                            <span>Realisasi: Rp {{ number_format($budget->realisasi_tol_parkir, 0, ',', '.') }}</span>
                            <span>Sisa: Rp {{ number_format($budget->alokasi_tol_parkir - $budget->realisasi_tol_parkir, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">Lainnya</p>
                        <div class="flex justify-between text-sm">
                            <span>Alokasi: Rp {{ number_format($budget->alokasi_lainnya, 0, ',', '.') }}</span>
                            <span>Realisasi: Rp {{ number_format($budget->realisasi_lainnya, 0, ',', '.') }}</span>
                            <span>Sisa: Rp {{ number_format($budget->alokasi_lainnya - $budget->realisasi_lainnya, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 p-3 bg-navy-50 rounded-lg flex justify-between items-center">
                    <span class="text-sm font-semibold text-navy">Total Alokasi</span>
                    <span class="text-sm font-bold text-navy">Rp {{ number_format($budget->total_alokasi, 0, ',', '.') }}</span>
                    <span class="text-sm font-semibold text-navy">Total Realisasi</span>
                    <span class="text-sm font-bold text-navy">Rp {{ number_format($budget->total_realisasi, 0, ',', '.') }}</span>
                </div>
                @if($budget->catatan)
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500">Catatan</p>
                    <p class="text-sm text-gray-700">{{ $budget->catatan }}</p>
                </div>
                @endif
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy mb-4">Riwayat Budget</h3>
                @if($armada->budget->count())
                <div class="space-y-2">
                    @foreach($armada->budget->sortByDesc('bulan') as $b)
                    <div class="flex justify-between items-center p-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm">{{ \Carbon\Carbon::parse($b->bulan . '-01')->format('M Y') }}</span>
                        <span class="text-sm font-medium">Rp {{ number_format($b->total_alokasi, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-400">Belum ada data budget.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
