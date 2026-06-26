@extends('layouts.app')
@section('title', 'Buat Invoice')
@section('content')
<div class="max-w-3xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Buat Invoice</h2>
        <p class="text-gray-500">Invoice baru untuk job order</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('finance.invoice.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Invoice *</label>
                    <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice') }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Order *</label>
                    <select name="job_order_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Job Order</option>
                        @foreach($jobOrders as $jo)
                        <option value="{{ $jo->id }}" {{ old('job_order_id', ($jobOrder ?? null)?->id) == $jo->id ? 'selected' : '' }}>{{ $jo->nomor_jo }} - {{ $jo->customer?->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer *</label>
                    <select name="customer_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Customer</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Invoice</label>
                    <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>

            <div class="mt-6 mb-4">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Line Items</h3>
                <div id="line-items">
                    @php $defaultItems = ['Freight Charge', 'Handling Fee', 'Admin Fee']; @endphp
                    @foreach($defaultItems as $idx => $desc)
                    <div class="grid grid-cols-4 gap-4 mb-3 item-row">
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                            <input type="text" name="items[{{ $idx }}][deskripsi]" value="{{ $desc }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah</label>
                            <input type="number" name="items[{{ $idx }}][jumlah]" value="1" min="1" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal item-jumlah">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Harga Satuan</label>
                            <input type="number" name="items[{{ $idx }}][harga_satuan]" value="0" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal item-harga">
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addItem()" class="text-sm text-teal hover:text-teal-600">+ Tambah Item</button>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="catatan" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('catatan') }}</textarea>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('finance.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Simpan Invoice</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
let itemIndex = {{ count($defaultItems) }};
function addItem() {
    const html = `<div class="grid grid-cols-4 gap-4 mb-3 item-row">
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
            <input type="text" name="items[${itemIndex}][deskripsi]" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah</label>
            <input type="number" name="items[${itemIndex}][jumlah]" value="1" min="1" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal item-jumlah">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Harga Satuan</label>
            <input type="number" name="items[${itemIndex}][harga_satuan]" value="0" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal item-harga">
        </div>
    </div>`;
    document.getElementById('line-items').insertAdjacentHTML('beforeend', html);
    itemIndex++;
}
</script>
@endpush
