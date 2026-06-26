@extends('layouts.app')
@section('title', 'Perijinan Armada')
@section('content')
<div class="max-w-4xl">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Perijinan Armada</h2>
            <p class="text-gray-500">{{ $armada->nomor_polisi }} - {{ $armada->merk ?? '' }}</p>
        </div>
        <a href="{{ route('master.armada.show', $armada) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Tambah Perijinan</h3>
            <form method="POST" action="{{ route('master.armada.izin.store', $armada) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Perijinan *</label>
                    <select name="jenis_perijinan" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('jenis_perijinan') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="stnk" {{ old('jenis_perijinan') == 'stnk' ? 'selected' : '' }}>STNK</option>
                        <option value="kir" {{ old('jenis_perijinan') == 'kir' ? 'selected' : '' }}>KIR</option>
                        <option value="samsat" {{ old('jenis_perijinan') == 'samsat' ? 'selected' : '' }}>Samsat</option>
                        <option value="keur" {{ old('jenis_perijinan') == 'keur' ? 'selected' : '' }}>Keur</option>
                        <option value="asuransi" {{ old('jenis_perijinan') == 'asuransi' ? 'selected' : '' }}>Asuransi</option>
                        <option value="izin_trayek" {{ old('jenis_perijinan') == 'izin_trayek' ? 'selected' : '' }}>Izin Trayek</option>
                        <option value="lainnya" {{ old('jenis_perijinan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis_perijinan') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Izin *</label>
                    <input type="text" name="nomor_izin" value="{{ old('nomor_izin') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('nomor_izin') border-red-500 @enderror">
                    @error('nomor_izin') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                    <input type="text" name="penerbit" value="{{ old('penerbit') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terbit</label>
                        <input type="date" name="tanggal_terbit" value="{{ old('tanggal_terbit') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku</label>
                        <input type="date" name="masa_berlaku" value="{{ old('masa_berlaku') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Perpanjangan</label>
                    <input type="number" name="biaya_perpanjangan" value="{{ old('biaya_perpanjangan') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sticker Number</label>
                    <input type="text" name="sticker_number" value="{{ old('sticker_number') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('keterangan') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        <option value="expired" {{ old('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <button type="submit" class="w-full px-4 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600 font-medium">Simpan Perijinan</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Daftar Perijinan</h3>
            @if($armada->izin->count())
            <div class="space-y-3">
                @foreach($armada->izin->sortByDesc('tanggal_terbit') as $i)
                <div class="p-3 border border-gray-100 rounded-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium capitalize">{{ str_replace('_', ' ', $i->jenis_perijinan) }}</p>
                            <p class="text-xs text-gray-500">No: {{ $i->nomor_izin }}</p>
                            @if($i->penerbit)<p class="text-xs text-gray-400">{{ $i->penerbit }}</p>@endif
                            <div class="flex gap-4 mt-1 text-xs text-gray-400">
                                <span>Terbit: {{ $i->tanggal_terbit?->format('d M Y') ?? '-' }}</span>
                                <span>Exp: {{ $i->masa_berlaku?->format('d M Y') ?? '-' }}</span>
                            </div>
                            @if($i->keterangan)<p class="text-xs text-gray-400 mt-1">{{ $i->keterangan }}</p>@endif
                        </div>
                        <div class="text-right">
                            <span class="text-xs px-1.5 py-0.5 rounded-full {{ $i->status == 'aktif' ? 'bg-green-100 text-green-700' : ($i->status == 'expired' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">{{ $i->status }}</span>
                            @if($i->masa_berlaku && $i->masa_berlaku->isPast() && $i->status == 'aktif')
                            <p class="text-xs text-red-500 mt-1">Expired!</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400">Belum ada data perijinan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
