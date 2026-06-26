@extends('layouts.app')
@section('title', 'Tambah Vendor')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Tambah Vendor</h2>
        <p class="text-gray-500">Data vendor baru</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('master.vendor.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('code') border-red-500 @enderror">
                    @error('code') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe *</label>
                    <select name="tipe" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="transport">Transport</option>
                        <option value="bongkar_muat">Bongkar Muat</option>
                        <option value="gudang">Gudang</option>
                        <option value="trucking">Trucking</option>
                        <option value="container">Container</option>
                        <option value="umum">Umum</option>
                    </select>
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan *</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('nama') border-red-500 @enderror">
                    @error('nama') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                    <input type="text" name="npwp" value="{{ old('npwp') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">PIC</label>
                    <input type="text" name="pic_name" value="{{ old('pic_name') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone PIC</label>
                    <input type="text" name="pic_phone" value="{{ old('pic_phone') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('master.vendor.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
