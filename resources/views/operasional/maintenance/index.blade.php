@extends('layouts.app')
@section('title', 'Maintenance Armada')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Maintenance Armada</h2>
            <p class="text-gray-500">Service & pembelian part per unit</p>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs text-gray-500">Total Biaya</p>
                <p class="text-lg font-bold text-navy">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</p>
            </div>
            <a href="{{ route('operasional.maintenance.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Catat Maintenance</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Armada</label>
                <select name="armada_id" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    @foreach($armada as $a)
                    <option value="{{ $a->id }}" @if(request('armada_id') == $a->id) selected @endif>{{ $a->nomor_polisi }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Jenis</label>
                <select name="jenis" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="service" @if(request('jenis') == 'service') selected @endif>Service</option>
                    <option value="ganti_oli" @if(request('jenis') == 'ganti_oli') selected @endif>Ganti Oli</option>
                    <option value="ganti_ban" @if(request('jenis') == 'ganti_ban') selected @endif>Ganti Ban</option>
                    <option value="sparepart" @if(request('jenis') == 'sparepart') selected @endif>Sparepart</option>
                    <option value="body_repair" @if(request('jenis') == 'body_repair') selected @endif>Body Repair</option>
                    <option value="lainnya" @if(request('jenis') == 'lainnya') selected @endif>Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Dari</label>
                <input type="date" name="from" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" value="{{ request('from') }}">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
                <input type="date" name="to" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" value="{{ request('to') }}">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Filter</button>
            <a href="{{ route('operasional.maintenance.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Reset</a>
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
                    <th class="px-6 py-3">Part</th>
                    <th class="px-6 py-3">Jasa</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">KM</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm">{{ $m->tanggal?->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $m->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ str_replace('_', ' ', $m->jenis) }}</td>
                    <td class="px-6 py-4 text-sm">{{ $m->deskripsi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($m->biaya_part, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">Rp {{ number_format($m->biaya_jasa, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($m->total_biaya, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-sm">{{ $m->km_tempuh ? number_format($m->km_tempuh, 0, ',', '.') . ' km' : '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($m->status == 'selesai') bg-green-100 text-green-700
                            @elseif($m->status == 'dijadwalkan') bg-blue-100 text-blue-700
                            @else bg-yellow-100 text-yellow-700 @endif">{{ $m->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('operasional.maintenance.show', $m) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="px-6 py-8 text-center text-gray-500">Belum ada data maintenance</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $data->links() }}</div>
</div>
@endsection