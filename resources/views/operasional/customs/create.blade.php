@extends('layouts.app')
@section('title', 'Tambah Customs')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Tambah Customs</h2>
        <p class="text-gray-500">Data kepabeanan baru</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('operasional.customs.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Order *</label>
                    <select name="job_order_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Job Order</option>
                        @foreach($jobOrders as $jo)
                        <option value="{{ $jo->id }}" {{ old('job_order_id', request('job_order_id')) == $jo->id ? 'selected' : '' }}>{{ $jo->nomor_jo }} - {{ $jo->customer?->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis *</label>
                    <select name="jenis" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="impor" {{ old('jenis') == 'impor' ? 'selected' : '' }}>Impor</option>
                        <option value="ekspor" {{ old('jenis') == 'ekspor' ? 'selected' : '' }}>Ekspor</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No PIB/PEB *</label>
                    <input type="text" name="nomor_pib_peb" value="{{ old('nomor_pib_peb') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                    <input type="date" name="tanggal_pengajuan" value="{{ old('tanggal_pengajuan') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">PPJK</label>
                    <select name="ppjk_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih PPJK</option>
                        @foreach($ppjk as $p)
                        <option value="{{ $p->id }}" {{ old('ppjk_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Bill of Lading</label>
                    <input type="text" name="nomor_bill_of_lading" value="{{ old('nomor_bill_of_lading') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Manifest</label>
                    <input type="text" name="nomor_manifest" value="{{ old('nomor_manifest') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Invoice</label>
                    <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Packing List</label>
                    <input type="text" name="nomor_packing_list" value="{{ old('nomor_packing_list') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Certificate of Origin</label>
                    <input type="text" name="nomor_certificate_of_origin" value="{{ old('nomor_certificate_of_origin') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Instruction</label>
                    <input type="text" name="nomor_shipping_instruction" value="{{ old('nomor_shipping_instruction') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('operasional.customs.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection
