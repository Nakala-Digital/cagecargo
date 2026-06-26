@extends('layouts.app')
@section('title', 'Detail Kontrak Subkon')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Kontrak Subkon</h2>
            <p class="text-gray-500">{{ $kontrakSubkon->nomor_kontrak }}</p>
        </div>
        <a href="{{ route('master.armada.kontrak.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <dl class="grid grid-cols-2 gap-4">
            <div>
                <dt class="text-sm text-gray-500">Nomor Kontrak</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->nomor_kontrak }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Vendor</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->vendor?->nama ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Jenis</dt>
                <dd class="text-sm font-medium capitalize">{{ $kontrakSubkon->jenis }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Status</dt>
                <dd><span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $kontrakSubkon->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $kontrakSubkon->status ?? 'aktif' }}</span></dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Tanggal Mulai</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->tanggal_mulai?->format('d M Y') ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Tanggal Berakhir</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->tanggal_berakhir?->format('d M Y') ?? '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Nilai Kontrak</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->nilai_kontrak ? 'Rp ' . number_format($kontrakSubkon->nilai_kontrak, 0, ',', '.') : '-' }}</dd>
            </div>
            <div>
                <dt class="text-sm text-gray-500">Keterangan</dt>
                <dd class="text-sm font-medium">{{ $kontrakSubkon->keterangan ?? '-' }}</dd>
            </div>
        </dl>
    </div>

    @if($kontrakSubkon->armada->count())
    <div class="bg-white rounded-xl shadow-sm p-6 mt-6">
        <h3 class="text-lg font-semibold text-navy mb-4">Armada Terkait</h3>
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b">
                    <th class="px-4 py-2">No Polisi</th>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($kontrakSubkon->armada as $a)
                <tr class="text-sm">
                    <td class="px-4 py-2">
                        <a href="{{ route('master.armada.show', $a) }}" class="text-teal hover:text-teal-600">{{ $a->nomor_polisi }}</a>
                    </td>
                    <td class="px-4 py-2">{{ $a->jenis_kendaraan }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $a->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $a->status }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection