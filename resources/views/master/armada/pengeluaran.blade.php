@extends('layouts.app')
@section('title', 'Pengeluaran Armada')
@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Pengeluaran Armada</h2>
            <p class="text-gray-500">{{ $armada->nomor_polisi }} - {{ $armada->merk ?? '' }}</p>
        </div>
        <a href="{{ route('master.armada.show', $armada) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Tambah Pengeluaran</h3>
            <form method="POST" action="{{ route('master.armada.pengeluaran.store', $armada) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis *</label>
                    <select name="jenis" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('jenis') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="solar" {{ old('jenis') == 'solar' ? 'selected' : '' }}>Solar</option>
                        <option value="tol" {{ old('jenis') == 'tol' ? 'selected' : '' }}>Tol</option>
                        <option value="parkir" {{ old('jenis') == 'parkir' ? 'selected' : '' }}>Parkir</option>
                        <option value="service" {{ old('jenis') == 'service' ? 'selected' : '' }}>Service</option>
                        <option value="ganti_oli" {{ old('jenis') == 'ganti_oli' ? 'selected' : '' }}>Ganti Oli</option>
                        <option value="sparepart" {{ old('jenis') == 'sparepart' ? 'selected' : '' }}>Sparepart</option>
                        <option value="cuci" {{ old('jenis') == 'cuci' ? 'selected' : '' }}>Cuci</option>
                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah *</label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('jumlah') border-red-500 @enderror">
                    @error('jumlah') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal *</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Volume Solar (liter)</label>
                    <input type="number" step="0.01" name="volume_solar" value="{{ old('volume_solar') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vendor Penyedia</label>
                    <input type="text" name="vendor_penyedia" value="{{ old('vendor_penyedia') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Nota</label>
                    <input type="text" name="nomor_nota" value="{{ old('nomor_nota') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('keterangan') }}</textarea>
                </div>
                <button type="submit" class="w-full px-4 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600 font-medium">Simpan Pengeluaran</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Riwayat Pengeluaran</h3>
            @if($armada->pengeluaran->count())
            <div class="space-y-3">
                @foreach($armada->pengeluaran->sortByDesc('tanggal') as $p)
                <div class="p-3 border border-gray-100 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $p->jenis) }}</p>
                            <p class="text-xs text-gray-500">{{ $p->tanggal?->format('d M Y') }}</p>
                            @if($p->lokasi)<p class="text-xs text-gray-400">{{ $p->lokasi }}</p>@endif
                            @if($p->keterangan)<p class="text-xs text-gray-400 mt-1">{{ $p->keterangan }}</p>@endif
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-navy">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</p>
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $p->status == 'approved' ? 'bg-green-100 text-green-700' : ($p->status == 'rejected' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">{{ $p->status }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @php $total = $armada->pengeluaran->sum('jumlah'); @endphp
            <div class="mt-4 p-3 bg-navy-50 rounded-lg flex justify-between items-center">
                <span class="text-sm font-semibold text-navy">Total Pengeluaran</span>
                <span class="text-sm font-bold text-navy">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            @else
            <p class="text-sm text-gray-400">Belum ada pengeluaran tercatat.</p>
            @endif
        </div>
    </div>
</div>
@endsection
