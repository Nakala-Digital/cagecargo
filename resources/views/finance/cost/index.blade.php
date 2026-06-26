@extends('layouts.app')
@section('title', 'Biaya Job Order')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Biaya Job Order</h2>
            <p class="text-gray-500">{{ $jobOrder->nomor_jo }} - {{ $jobOrder->customer?->nama ?? '-' }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('finance.job.costs', $jobOrder) }}" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Refresh</a>
            <a href="{{ route('finance.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Tambah Biaya</h3>
        <form method="POST" action="{{ route('finance.job.costs.store', $jobOrder) }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select name="tipe" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="solar">Solar</option>
                        <option value="tol">Tol</option>
                        <option value="parkir">Parkir</option>
                        <option value="preman">Preman/Akamsi</option>
                        <option value="makan_driver">Makan Driver</option>
                        <option value="sewa_armada">Sewa Armada</option>
                        <option value="jasa_pelabuhan">Jasa Pelabuhan</option>
                        <option value="dokumen">Dokumen</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <input type="number" name="jumlah" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <input type="text" name="deskripsi" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Simpan Biaya</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Tipe</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($costs as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $c->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $c->tipe }}</td>
                    <td class="px-6 py-4 text-sm">{{ $c->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($c->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($c->status == 'approved') bg-green-100 text-green-700
                            @elseif($c->status == 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $c->status ?? 'pending' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada biaya</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-3 border-t bg-gray-50 flex justify-between">
            <span class="text-sm font-semibold text-navy">Total Biaya</span>
            <span class="text-sm font-bold text-navy">Rp {{ number_format($costs->sum('jumlah'), 0, ',', '.') }}</span>
        </div>
    </div>
</div>
@endsection