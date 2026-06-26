@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Edit Customer</h2>
        <p class="text-gray-500">{{ $customer->nama }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('master.customer.update', $customer) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode *</label>
                    <input type="text" name="code" value="{{ old('code', $customer->code) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe *</label>
                    <select name="tipe" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        @foreach(['customer','consignee','shipper','notify_party'] as $t)
                        <option value="{{ $t }}" {{ $customer->tipe == $t ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $t)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan *</label>
                    <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('alamat', $customer->alamat) }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">NPWP</label>
                    <input type="text" name="npwp" value="{{ old('npwp', $customer->npwp) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="aktif" {{ $customer->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $customer->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('master.customer.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
