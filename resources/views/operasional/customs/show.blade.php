@extends('layouts.app')
@section('title', 'Detail Customs')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Customs Clearance</h2>
            <p class="text-gray-500">{{ $customs->nomor_pib_peb }}</p>
        </div>
        <div class="space-x-2">
            <form method="POST" action="{{ route('operasional.customs.dummy-ceisa-insw', $customs) }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600">Dummy CEISA/INSW</button>
            </form>
            <a href="{{ route('operasional.customs.edit', $customs) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('operasional.customs.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Customs</h3>
            <dl class="grid grid-cols-2 gap-4">
                <div class="col-span-2"><dt class="text-sm text-gray-500">Job Order</dt><dd class="text-sm font-medium">{{ $customs->jobOrder?->nomor_jo ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Jenis</dt><dd class="text-sm font-medium capitalize">{{ $customs->jenis }}</dd></div>
                <div><dt class="text-sm text-gray-500">No PIB/PEB</dt><dd class="text-sm font-medium">{{ $customs->nomor_pib_peb }}</dd></div>
                <div><dt class="text-sm text-gray-500">Tanggal Pengajuan</dt><dd class="text-sm font-medium">{{ $customs->tanggal_pengajuan?->format('d M Y') ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Tanggal Release</dt><dd class="text-sm font-medium">{{ $customs->tanggal_release?->format('d M Y') ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Jalur</dt><dd>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full
                        @if($customs->jalur == 'hijau') bg-green-100 text-green-700
                        @elseif($customs->jalur == 'kuning') bg-yellow-100 text-yellow-700
                        @elseif($customs->jalur == 'merah') bg-red-100 text-red-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst($customs->jalur ?? '-') }}
                    </span>
                </dd></div>
                <div><dt class="text-sm text-gray-500">Status</dt><dd>
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full
                        @if($customs->status == 'waiting_clearance') bg-yellow-100 text-yellow-700
                        @elseif($customs->status == 'under_inspection') bg-blue-100 text-blue-700
                        @elseif($customs->status == 'released') bg-green-100 text-green-700
                        @else bg-gray-100 text-gray-700 @endif">
                        {{ ucfirst(str_replace('_', ' ', $customs->status ?? '-')) }}
                    </span>
                </dd></div>
                <div><dt class="text-sm text-gray-500">PPJK</dt><dd class="text-sm font-medium">{{ $customs->ppjk?->nama_perusahaan ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Nomor NPE</dt><dd class="text-sm font-medium">{{ $customs->nomor_npe ?? '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Dokumen Terkait</h3>
            <dl class="grid grid-cols-2 gap-4">
                <div><dt class="text-sm text-gray-500">Bill of Lading</dt><dd class="text-sm font-medium">{{ $customs->nomor_bill_of_lading ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Manifest</dt><dd class="text-sm font-medium">{{ $customs->nomor_manifest ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Invoice</dt><dd class="text-sm font-medium">{{ $customs->nomor_invoice ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Packing List</dt><dd class="text-sm font-medium">{{ $customs->nomor_packing_list ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Certificate of Origin</dt><dd class="text-sm font-medium">{{ $customs->nomor_certificate_of_origin ?? '-' }}</dd></div>
                <div><dt class="text-sm text-gray-500">Shipping Instruction</dt><dd class="text-sm font-medium">{{ $customs->nomor_shipping_instruction ?? '-' }}</dd></div>
            </dl>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Perhitungan Biaya</h3>
            <dl class="grid grid-cols-2 gap-4">
                <div><dt class="text-sm text-gray-500">Bea Masuk</dt><dd class="text-sm font-medium">Rp {{ number_format($customs->bea_masuk ?? 0, 0, ',', '.') }}</dd></div>
                <div><dt class="text-sm text-gray-500">Pajak</dt><dd class="text-sm font-medium">Rp {{ number_format($customs->pajak ?? 0, 0, ',', '.') }}</dd></div>
                <div><dt class="text-sm text-gray-500">Denda</dt><dd class="text-sm font-medium">Rp {{ number_format($customs->denda ?? 0, 0, ',', '.') }}</dd></div>
                <div><dt class="text-sm text-gray-500">Total</dt><dd class="text-sm font-semibold text-navy">Rp {{ number_format(($customs->bea_masuk ?? 0) + ($customs->pajak ?? 0) + ($customs->denda ?? 0), 0, ',', '.') }}</dd></div>
            </dl>
        </div>

        @if($customs->catatan)
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Catatan / Dummy Sync Log</h3>
            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $customs->catatan }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
