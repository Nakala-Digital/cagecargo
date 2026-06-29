@extends('layouts.app')
@section('title', 'Buat Invoice')
@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Buat Invoice</h2>
        <p class="text-gray-500">Invoice baru untuk job order</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('finance.invoice.store') }}" id="invoiceForm">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Job Order *</label>
                    <select name="job_order_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Job Order</option>
                        @foreach($jobOrders as $jo)
                        <option value="{{ $jo->id }}" {{ old('job_order_id', ($jobOrder ?? null)?->id) == $jo->id ? 'selected' : '' }}>{{ $jo->nomor_jo }} - {{ $jo->customer?->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer *</label>
                    <select name="customer_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Customer</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Invoice</label>
                    <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', date('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Jatuh Tempo</label>
                    <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>

            <div class="mt-6 mb-4">
                <div class="flex items-center justify-between border-b pb-2 mb-4">
                    <h3 class="text-lg font-semibold text-navy">Line Items</h3>
                    <div class="flex gap-2">
                        <button type="button" onclick="addItem('regular')" class="text-sm px-3 py-1 bg-teal text-white rounded hover:bg-teal-600">+ Regular</button>
                        <button type="button" onclick="addItem('add_on')" class="text-sm px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">+ Add-On</button>
                        <button type="button" onclick="addItem('biaya_tambahan')" class="text-sm px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600">+ Biaya Tambahan</button>
                    </div>
                </div>

                <div id="line-items">
                    @php $idx = 0; @endphp
                    @foreach([['Freight Charge', 'regular'], ['Handling Fee', 'regular'], ['Admin Fee', 'regular']] as $i => $item)
                    <div class="grid grid-cols-6 gap-3 mb-3 item-row">
                        <div class="col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
                            <input type="text" name="items[{{ $idx }}][deskripsi]" value="{{ $item[0] }}" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                            <select name="items[{{ $idx }}][tipe]" class="w-full px-3 py-2 border rounded-lg text-sm">
                                <option value="trucking">Trucking</option>
                                <option value="container">Container</option>
                                <option value="ppjk_fee">PPJK Fee</option>
                                <option value="add_on">Add-On</option>
                                <option value="biaya_tambahan">Biaya Tambahan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
                            <select name="items[{{ $idx }}][jenis_item]" class="w-full px-3 py-2 border rounded-lg text-sm jenis-select">
                                <option value="regular" {{ $item[1] == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="add_on" {{ $item[1] == 'add_on' ? 'selected' : '' }}>Add-On</option>
                                <option value="biaya_tambahan" {{ $item[1] == 'biaya_tambahan' ? 'selected' : '' }}>Biaya Tambahan</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah</label>
                            <input type="number" name="items[{{ $idx }}][jumlah]" value="1" min="1" class="w-full px-3 py-2 border rounded-lg text-sm item-jumlah">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Harga</label>
                            <input type="number" name="items[{{ $idx }}][harga_satuan]" value="0" class="w-full px-3 py-2 border rounded-lg text-sm item-harga">
                        </div>
                        <div class="flex items-end pb-2">
                            <input type="hidden" name="items[{{ $idx }}][total]" class="item-total" value="0">
                            <button type="button" onclick="this.closest('.item-row').remove()" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
                        </div>
                    </div>
                    @php $idx++; @endphp
                    @endforeach
                </div>
            </div>

            <div class="border-t pt-4 space-y-2">
                <div class="flex justify-end items-center gap-4">
                    <span class="text-sm text-gray-600">Subtotal:</span>
                    <span class="text-lg font-semibold" id="subtotalDisplay">Rp 0</span>
                </div>
                <div class="flex justify-end items-center gap-4">
                    <span class="text-sm text-gray-600">PPN (11%):</span>
                    <input type="number" name="subtotal" id="subtotalInput" hidden value="0">
                    <input type="number" name="ppn" id="ppnInput" class="w-32 px-3 py-2 border rounded-lg text-sm text-right" value="0">
                    <button type="button" onclick="hitungPPN()" class="text-xs text-teal hover:text-teal-600">Hitung</button>
                </div>
                <div class="flex justify-end items-center gap-4 border-t pt-2">
                    <span class="text-sm font-bold text-navy">Total:</span>
                    <span class="text-xl font-bold text-teal" id="totalDisplay">Rp 0</span>
                    <input type="number" name="total" id="totalInput" hidden value="0">
                </div>
            </div>

            <div class="mt-4">
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

<script>
let itemIndex = {{ $idx }};
function addItem(jenisItem) {
    const html = `<div class="grid grid-cols-6 gap-3 mb-3 item-row">
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-500 mb-1">Deskripsi</label>
            <input type="text" name="items[${itemIndex}][deskripsi]" class="w-full px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
            <select name="items[${itemIndex}][tipe]" class="w-full px-3 py-2 border rounded-lg text-sm">
                <option value="trucking">Trucking</option>
                <option value="container">Container</option>
                <option value="ppjk_fee">PPJK Fee</option>
                <option value="add_on">Add-On</option>
                <option value="biaya_tambahan">Biaya Tambahan</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Jenis</label>
            <select name="items[${itemIndex}][jenis_item]" class="w-full px-3 py-2 border rounded-lg text-sm jenis-select">
                <option value="regular" ${jenisItem === 'regular' ? 'selected' : ''}>Regular</option>
                <option value="add_on" ${jenisItem === 'add_on' ? 'selected' : ''}>Add-On</option>
                <option value="biaya_tambahan" ${jenisItem === 'biaya_tambahan' ? 'selected' : ''}>Biaya Tambahan</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah</label>
            <input type="number" name="items[${itemIndex}][jumlah]" value="1" min="1" class="w-full px-3 py-2 border rounded-lg text-sm item-jumlah">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-500 mb-1">Harga</label>
            <input type="number" name="items[${itemIndex}][harga_satuan]" value="0" class="w-full px-3 py-2 border rounded-lg text-sm item-harga">
        </div>
        <div class="flex items-end pb-2">
            <input type="hidden" name="items[${itemIndex}][total]" class="item-total" value="0">
            <button type="button" onclick="this.closest('.item-row').remove(); hitungSubtotal();" class="text-red-500 hover:text-red-700 text-sm">Hapus</button>
        </div>
    </div>`;
    document.getElementById('line-items').insertAdjacentHTML('beforeend', html);
    itemIndex++;
}

function hitungSubtotal() {
    let subtotal = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.item-jumlah').value) || 0;
        const price = parseFloat(row.querySelector('.item-harga').value) || 0;
        const total = qty * price;
        row.querySelector('.item-total').value = total;
        subtotal += total;
    });
    document.getElementById('subtotalDisplay').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    document.getElementById('subtotalInput').value = subtotal;
    hitungTotal(subtotal);
}

function hitungPPN() {
    const subtotal = parseFloat(document.getElementById('subtotalInput').value) || 0;
    const ppn = Math.round(subtotal * 0.11);
    document.getElementById('ppnInput').value = ppn;
    hitungTotal(subtotal);
}

function hitungTotal(subtotal) {
    const ppn = parseFloat(document.getElementById('ppnInput').value) || 0;
    const total = subtotal + ppn;
    document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalInput').value = total;
}

document.querySelector('#invoiceForm').addEventListener('input', function(e) {
    if (e.target.classList.contains('item-jumlah') || e.target.classList.contains('item-harga')) {
        hitungSubtotal();
    }
});

hitungSubtotal();
</script>
@endsection