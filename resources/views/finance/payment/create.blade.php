@extends('layouts.app')
@section('title', 'Pembayaran Invoice')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Pembayaran Invoice</h2>
            <p class="text-gray-500">{{ $invoice->nomor_invoice }}</p>
        </div>
        <a href="{{ route('finance.show', $invoice) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali ke Invoice</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <dl class="grid grid-cols-2 gap-4">
            <div><dt class="text-sm text-gray-500">Total Invoice</dt><dd class="text-sm font-bold text-navy">Rp {{ number_format($invoice->total, 0, ',', '.') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Total Dibayar</dt><dd class="text-sm font-bold text-green-600">Rp {{ number_format($invoice->payments->sum('jumlah'), 0, ',', '.') }}</dd></div>
            <div><dt class="text-sm text-gray-500">Sisa</dt><dd class="text-sm font-bold {{ ($invoice->total - $invoice->payments->sum('jumlah')) > 0 ? 'text-red-600' : 'text-green-600' }}">Rp {{ number_format($invoice->total - $invoice->payments->sum('jumlah'), 0, ',', '.') }}</dd></div>
        </dl>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Catat Pembayaran</h3>
        <form method="POST" action="{{ route('finance.payment.store', $invoice) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="jumlah" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" max="{{ $invoice->total - $invoice->payments->sum('jumlah') }}">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pembayaran</label>
                    <input type="date" name="tanggal_pembayaran" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                    <select name="metode" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Cash</option>
                        <option value="cheque">Cheque/Giro</option>
                        <option value="kartu_kredit">Kartu Kredit</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referensi</label>
                    <input type="text" name="referensi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal" placeholder="No. referensi pembayaran">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('finance.show', $invoice) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Simpan Pembayaran</button>
            </div>
        </form>
    </div>

    @if($invoice->payments->count())
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Riwayat Pembayaran</h3>
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Metode</th>
                    <th class="px-4 py-2">Referensi</th>
                    <th class="px-4 py-2">Jumlah</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($invoice->payments as $p)
                <tr class="text-sm">
                    <td class="px-4 py-2">{{ $p->tanggal_pembayaran?->format('d M Y') ?? '-' }}</td>
                    <td class="px-4 py-2 capitalize">{{ $p->metode }}</td>
                    <td class="px-4 py-2">{{ $p->referensi ?? '-' }}</td>
                    <td class="px-4 py-2 font-medium">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection