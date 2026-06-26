@extends('layouts.app')
@section('title', 'Tambah Container')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Tambah Container</h2>
        <p class="text-gray-500">Data container baru</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('master.container.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Container *</label>
                    <input type="text" name="nomor_container" value="{{ old('nomor_container') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('nomor_container') border-red-500 @enderror">
                    @error('nomor_container') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Size *</label>
                    <select name="size" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="40HC">40HC</option>
                        <option value="45">45</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                    <select name="type" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="dry">Dry</option>
                        <option value="reefer">Reefer</option>
                        <option value="open_top">Open Top</option>
                        <option value="flat_rack">Flat Rack</option>
                        <option value="tank">Tank</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Line</label>
                    <select name="shipping_line_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Shipping Line</option>
                        @foreach($shippingLines as $sl)
                        <option value="{{ $sl->id }}" {{ old('shipping_line_id') == $sl->id ? 'selected' : '' }}>{{ $sl->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Seal Number</label>
                    <input type="text" name="seal_number" value="{{ old('seal_number') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Weight (kg)</label>
                    <input type="number" name="max_weight" value="{{ old('max_weight') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tare Weight (kg)</label>
                    <input type="number" name="tare_weight" value="{{ old('tare_weight') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('master.container.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
