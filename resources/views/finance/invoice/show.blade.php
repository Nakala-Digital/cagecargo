@extends('layouts.app')
@section('title', 'Detail Invoice')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Invoice</h2>
            <p class="text-gray-500">{{ $invoice->nomor_invoice }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('finance.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Invoice</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Nomor Invoice</dt><dd class="text-sm font-medium">{{ $invoice->nomor_invoice }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($invoice->status == 'paid') bg-green-100 text-green-700
                            @elseif($invoice->status == 'unpaid') bg-red-100 text-red-700
                            @elseif(in_array($invoice->status, ['partial', 'partially_paid'])) bg-yellow-100 text-yellow-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}
                        </span>
                    </dd></div>
                    <div><dt class="text-sm text-gray-500">Job Order</dt><dd class="text-sm font-medium">{{ $invoice->jobOrder?->nomor_jo ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Customer</dt><dd class="text-sm font-medium">{{ $invoice->customer?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Tanggal Invoice</dt><dd class="text-sm font-medium">{{ $invoice->tanggal_invoice?->format('d M Y') ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Jatuh Tempo</dt><dd class="text-sm font-medium">{{ $invoice->tanggal_jatuh_tempo?->format('d M Y') ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Line Items</h3>
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm font-medium text-gray-500 border-b">
                            <th class="px-4 py-2">Deskripsi</th>
                            <th class="px-4 py-2">Tipe</th>
                            <th class="px-4 py-2 text-right">Jumlah</th>
                            <th class="px-4 py-2 text-right">Harga Satuan</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($invoice->items as $item)
                        <tr>
                            <td class="px-4 py-2">{{ $item->deskripsi }}</td>
                            <td class="px-4 py-2 capitalize">{{ $item->tipe ?? '-' }}</td>
                            <td class="px-4 py-2 text-right">{{ $item->jumlah }}</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 text-right font-medium">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-4 py-4 text-center text-gray-500">Tidak ada item</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="border-t font-semibold">
                            <td colspan="4" class="px-4 py-3 text-right">Subtotal</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($invoice->subtotal ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="font-semibold">
                            <td colspan="4" class="px-4 py-2 text-right">PPN (11%)</td>
                            <td class="px-4 py-2 text-right">Rp {{ number_format($invoice->ppn ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="border-t font-bold text-navy">
                            <td colspan="4" class="px-4 py-3 text-right">Total</td>
                            <td class="px-4 py-3 text-right">Rp {{ number_format($invoice->total, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Riwayat Pembayaran</h3>
                @if($invoice->payments->count())
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm font-medium text-gray-500 border-b">
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Metode</th>
                            <th class="px-4 py-2">Referensi</th>
                            <th class="px-4 py-2 text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($invoice->payments as $payment)
                        <tr>
                            <td class="px-4 py-2">{{ $payment->tanggal_pembayaran?->format('d M Y') }}</td>
                            <td class="px-4 py-2 capitalize">{{ $payment->metode ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $payment->referensi ?? '-' }}</td>
                            <td class="px-4 py-2 text-right font-medium">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-sm text-gray-500">Belum ada pembayaran</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Ringkasan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Invoice</span>
                        <span class="font-semibold">Rp {{ number_format($invoice->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Dibayar</span>
                        <span class="font-semibold text-green-600">Rp {{ number_format($invoice->payments->sum('jumlah'), 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm pt-2 border-t">
                        <span class="text-gray-500 font-medium">Sisa</span>
                        <span class="font-bold {{ ($invoice->total - $invoice->payments->sum('jumlah')) > 0 ? 'text-red-600' : 'text-green-600' }}">
                            Rp {{ number_format(max(0, $invoice->total - $invoice->payments->sum('jumlah')), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Tambah Pembayaran</h3>
                <form method="POST" action="{{ route('finance.payment.store', $invoice) }}">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" name="jumlah" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                            <input type="date" name="tanggal_pembayaran" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                            <select name="metode" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                                <option value="transfer">Transfer</option>
                                <option value="cash">Cash</option>
                                <option value="cek">Cek</option>
                                <option value="giro">Giro</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Referensi</label>
                            <input type="text" name="referensi" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                            <textarea name="catatan" rows="2" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal"></textarea>
                        </div>
                        <button type="submit" class="w-full px-4 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Simpan Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
