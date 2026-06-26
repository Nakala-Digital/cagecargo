@extends('layouts.app')
@section('title', 'Export Data')
@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-navy">Export Data</h2>
        <p class="text-gray-500">Export data keuangan dan operasional</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Filter Data</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="from" value="{{ request('from') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="to" value="{{ request('to') }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                <select name="customer_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    <option value="">Semua Customer</option>
                    @foreach($customers as $c)
                    <option value="{{ $c->id }}" {{ request('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Data</label>
                <select name="type" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    <option value="invoice" {{ request('type') == 'invoice' ? 'selected' : '' }}>Invoice</option>
                    <option value="cost" {{ request('type') == 'cost' ? 'selected' : '' }}>Cost</option>
                    <option value="job" {{ request('type') == 'job' ? 'selected' : '' }}>Job Order</option>
                </select>
            </div>
            <div class="flex items-end space-x-2">
                <button type="submit" class="px-4 py-2.5 bg-navy text-white rounded-lg hover:bg-navy-700">Filter</button>
                <button type="button" onclick="window.print()" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Print</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        @if(request('type') == 'invoice' || !request('type'))
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">No Invoice</th>
                    <th class="px-6 py-3">Job Order</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Total</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $d)
                <tr class="hover:bg-gray-50 text-sm">
                    <td class="px-6 py-4">{{ $d->nomor_invoice }}</td>
                    <td class="px-6 py-4">{{ $d->jobOrder?->nomor_jo ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $d->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $d->tanggal_invoice?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-right">Rp {{ number_format($d->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ ucfirst($d->status) }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
        @elseif(request('type') == 'cost')
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Job Order</th>
                    <th class="px-6 py-3">Vendor</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3 text-right">Jumlah</th>
                    <th class="px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $d)
                <tr class="hover:bg-gray-50 text-sm">
                    <td class="px-6 py-4">{{ $d->jobOrder?->nomor_jo ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $d->vendor?->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $d->tipe)) }}</td>
                    <td class="px-6 py-4">{{ $d->deskripsi }}</td>
                    <td class="px-6 py-4 text-right">Rp {{ number_format($d->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $d->tanggal?->format('d M Y') ?? '-' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
        @else
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor JO</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Armada</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $d)
                <tr class="hover:bg-gray-50 text-sm">
                    <td class="px-6 py-4">{{ $d->nomor_jo }}</td>
                    <td class="px-6 py-4">{{ $d->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $d->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $d->status)) }}</td>
                    <td class="px-6 py-4">{{ $d->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
        @endif
    </div>
    <div class="mt-4">{{ $data->links() ?? '' }}</div>
</div>
@endsection
