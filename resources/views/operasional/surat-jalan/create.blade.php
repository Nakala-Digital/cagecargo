@extends('layouts.app')
@section('title', 'Terbitkan Surat Jalan')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Terbitkan Surat Jalan</h2>
            <p class="text-gray-500">Buat surat jalan baru untuk job order</p>
        </div>
        <a href="{{ route('operasional.surat-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('operasional.surat-jalan.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Order</label>
                    <select name="job_order_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Job Order --</option>
                        @foreach($jobOrders as $jo)
                        <option value="{{ $jo->id }}">{{ $jo->nomor_jo }} - {{ $jo->customer?->nama ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Armada</label>
                    <select name="armada_id" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Armada --</option>
                        @foreach($armada as $a)
                        <option value="{{ $a->id }}">{{ $a->nomor_polisi }} - {{ $a->jenis_kendaraan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Driver (Opsional) --</option>
                        @foreach($drivers as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }} ({{ $d->no_hp ?? '-' }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                    <input type="text" name="tujuan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Rute</label>
                    <input type="text" name="rute" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" placeholder="Contoh: Jakarta - Surabaya">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Berangkat</label>
                        <input type="date" name="tanggal_berangkat" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Perkiraan Kembali</label>
                        <input type="date" name="tanggal_perkiraan_kembali" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Muatan</label>
                        <input type="text" name="jenis_muatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" placeholder="Contoh: General Cargo">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Berat Muatan (kg)</label>
                        <input type="number" name="berat_muatan" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Biaya Angkut</label>
                    <input type="number" name="biaya_angkut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('operasional.surat-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Terbitkan</button>
            </div>
        </form>
    </div>
</div>
@endsection