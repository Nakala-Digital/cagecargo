@extends('layouts.app')
@section('title', 'Pengeluaran Armada')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Pengeluaran Armada</h2>
            <p class="text-gray-500">Monitoring pengeluaran operasional armada</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Total Tampil</p>
            <p class="text-xl font-bold text-navy">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Filter Jenis</label>
                <select name="jenis" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal">
                    <option value="">Semua</option>
                    <option value="solar" @if(request('jenis') == 'solar') selected @endif>Solar</option>
                    <option value="sparepart" @if(request('jenis') == 'sparepart') selected @endif>Sparepart</option>
                    <option value="tol" @if(request('jenis') == 'tol') selected @endif>Tol</option>
                    <option value="parkir" @if(request('jenis') == 'parkir') selected @endif>Parkir</option>
                    <option value="preman" @if(request('jenis') == 'preman') selected @endif>Preman/Akamsi</option>
                    <option value="makan_driver" @if(request('jenis') == 'makan_driver') selected @endif>Makan Driver</option>
                    <option value="service" @if(request('jenis') == 'service') selected @endif>Service</option>
                    <option value="ganti_oli" @if(request('jenis') == 'ganti_oli') selected @endif>Ganti Oli</option>
                    <option value="lainnya" @if(request('jenis') == 'lainnya') selected @endif>Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Armada</label>
                <select name="armada_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal">
                    <option value="">Semua</option>
                    @foreach($armada as $a)
                    <option value="{{ $a->id }}" @if(request('armada_id') == $a->id) selected @endif>{{ $a->nomor_polisi }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal" value="{{ request('start_date') }}">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal" value="{{ request('end_date') }}">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Filter</button>
            <a href="{{ route('operasional.pengeluaran.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Reset</a>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Armada</th>
                    <th class="px-6 py-3">Jenis</th>
                    <th class="px-6 py-3">Deskripsi</th>
                    <th class="px-6 py-3">Jumlah</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pengeluaran as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $p->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $p->jenis) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($p->status == 'approved') bg-green-100 text-green-700
                            @elseif($p->status == 'rejected') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $p->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada pengeluaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pengeluaran->links() }}</div>
</div>
@endsection