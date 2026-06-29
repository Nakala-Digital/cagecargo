@extends('layouts.app')
@section('title', 'Uang Jalan')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Uang Jalan</h2>
            <p class="text-gray-500">Pencairan dana perjalanan & komisi driver</p>
        </div>
        <a href="{{ route('operasional.uang-jalan.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Uang Jalan Baru</a>
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
                <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="draft" @if(request('status') == 'draft') selected @endif>Draft</option>
                    <option value="approved" @if(request('status') == 'approved') selected @endif>Disetujui</option>
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
            <a href="{{ route('operasional.uang-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Reset</a>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor</th>
                    <th class="px-6 py-3">Surat Jalan</th>
                    <th class="px-6 py-3">Armada</th>
                    <th class="px-6 py-3">Driver</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($uangJalan as $uj)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $uj->nomor_uang_jalan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $uj->suratJalan?->nomor_surat_jalan ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $uj->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $uj->driver?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $uj->tanggal?->format('d M Y') ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm font-medium">Rp {{ number_format($uj->total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($uj->status == 'approved') bg-green-100 text-green-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ $uj->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <a href="{{ route('operasional.uang-jalan.show', $uj) }}" class="text-teal hover:text-teal-600">Detail</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada data uang jalan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $uangJalan->links() }}</div>
</div>
@endsection