@extends('layouts.app')
@section('title', 'Edit Customs')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Edit Customs</h2>
        <p class="text-gray-500">{{ $customs->nomor_pib_peb }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('operasional.customs.update', $customs) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Order *</label>
                    <select name="job_order_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Job Order</option>
                        @foreach($jobOrders as $jo)
                        <option value="{{ $jo->id }}" {{ old('job_order_id', $customs->job_order_id) == $jo->id ? 'selected' : '' }}>{{ $jo->nomor_jo }} - {{ $jo->customer?->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis *</label>
                    <select name="jenis" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="impor" {{ $customs->jenis == 'impor' ? 'selected' : '' }}>Impor</option>
                        <option value="ekspor" {{ $customs->jenis == 'ekspor' ? 'selected' : '' }}>Ekspor</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No PIB/PEB *</label>
                    <input type="text" name="nomor_pib_peb" value="{{ old('nomor_pib_peb', $customs->nomor_pib_peb) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan', $customs->tanggal_pengajuan?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jalur</label>
                    <select name="jalur" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Jalur</option>
                        <option value="hijau" {{ $customs->jalur == 'hijau' ? 'selected' : '' }}>Hijau</option>
                        <option value="kuning" {{ $customs->jalur == 'kuning' ? 'selected' : '' }}>Kuning</option>
                        <option value="merah" {{ $customs->jalur == 'merah' ? 'selected' : '' }}>Merah</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="waiting_clearance" {{ $customs->status == 'waiting_clearance' ? 'selected' : '' }}>Waiting Clearance</option>
                        <option value="under_inspection" {{ $customs->status == 'under_inspection' ? 'selected' : '' }}>Under Inspection</option>
                        <option value="released" {{ $customs->status == 'released' ? 'selected' : '' }}>Released</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Release</label>
                    <input type="date" name="tanggal_release" value="{{ old('tanggal_release', $customs->tanggal_release?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">PPJK</label>
                    <select name="ppjk_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih PPJK</option>
                        @foreach($ppjk as $p)
                        <option value="{{ $p->id }}" {{ old('ppjk_id', $customs->ppjk_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bea Masuk</label>
                    <input type="number" name="bea_masuk" value="{{ old('bea_masuk', $customs->bea_masuk) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pajak</label>
                    <input type="number" name="pajak" value="{{ old('pajak', $customs->pajak) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Denda</label>
                    <input type="number" name="denda" value="{{ old('denda', $customs->denda) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor NPE</label>
                    <input type="text" name="nomor_npe" value="{{ old('nomor_npe', $customs->nomor_npe) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('catatan', $customs->catatan) }}</textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('operasional.customs.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
