@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div>
        <div>
            <h2 class="text-2xl font-bold text-navy">Dashboard Operasional</h2>
            <p class="text-gray-500">Overview sistem logistik CargoGate</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-teal">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Shipment</p>
                    <p class="text-3xl font-bold text-navy mt-1">{{ $stats['total_shipment'] }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <div class="mt-4 flex gap-3 text-sm">
                <span class="text-green-600 font-medium">{{ $stats['job_delivered'] }} Delivered</span>
                <span class="text-yellow-600 font-medium">{{ $stats['job_in_progress'] }} In Progress</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-navy">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Armada</p>
                    <p class="text-3xl font-bold text-navy mt-1">{{ $stats['armada_aktif'] }}</p>
                </div>
                <div class="w-12 h-12 bg-navy-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex gap-3 text-sm">
                <span class="text-gray-600">{{ $stats['armada_subkon'] }} Subkon</span>
                <span class="text-gray-600">{{ $stats['driver_aktif'] }} Driver</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-teal">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">Surat Jalan Aktif</p>
                    <p class="text-3xl font-bold text-navy mt-1">{{ $stats['surat_jalan_aktif'] }}</p>
                </div>
                <div class="w-12 h-12 bg-teal-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="mt-4 text-sm">
                <span class="text-gray-600">{{ $stats['container_aktif'] }} Container | {{ $stats['customer_aktif'] }} Customer</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium">A/R - A/P Bulan Ini</p>
                    <p class="text-3xl font-bold text-navy mt-1">Rp {{ number_format($stats['ar_unpaid'], 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-50 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="mt-4 flex gap-3 text-sm">
                <span class="text-red-600 font-medium">AP: Rp {{ number_format($stats['ap_unpaid'], 0) }}</span>
                <span class="text-gray-400">|</span>
                <span class="text-green-600 font-medium">AR: Rp {{ number_format($stats['ar_unpaid'], 0) }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-navy">Reminder Dokumen Armada</h3>
                <span class="text-sm font-medium text-red-600">{{ $stats['dokumen_expiring'] }} mendekati expired</span>
            </div>
            <div class="space-y-3">
                @forelse($dokumenAkanExpired as $dokumen)
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <div>
                        <p class="text-sm font-medium">{{ $dokumen->armada?->nomor_polisi ?? '-' }} - {{ strtoupper($dokumen->jenis_dokumen) }}</p>
                        <p class="text-xs text-gray-500">{{ $dokumen->nomor_dokumen ?? '-' }}</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">{{ $dokumen->tanggal_expired?->format('d M Y') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-500">Tidak ada dokumen yang expired dalam 30 hari.</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-navy">Reminder Izin Kawasan/Pelabuhan</h3>
                <span class="text-sm font-medium text-orange-600">{{ $stats['izin_expiring'] }} mendekati expired</span>
            </div>
            <div class="space-y-3">
                @forelse($izinAkanExpired as $izin)
                <div class="flex justify-between border-b border-gray-100 pb-2">
                    <div>
                        <p class="text-sm font-medium">{{ strtoupper(str_replace('_', ' ', $izin->jenis_perijinan)) }}</p>
                        <p class="text-xs text-gray-500">{{ $izin->nomor_izin ?? '-' }} {{ $izin->sticker_number ? '| Sticker ' . $izin->sticker_number : '' }}</p>
                    </div>
                    <span class="text-sm font-semibold text-orange-600">{{ $izin->masa_berlaku?->format('d M Y') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-500">Tidak ada izin yang expired dalam 30 hari.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-navy">Alert Maintenance Armada</h3>
            <span class="text-sm font-medium text-yellow-700">{{ $serviceAlerts->count() }} unit perlu dicek</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @forelse($serviceAlerts as $armada)
            <div class="border border-yellow-100 bg-yellow-50 rounded-lg p-4">
                <p class="text-sm font-semibold text-navy">{{ $armada->nomor_polisi }}</p>
                <p class="text-xs text-gray-600 mt-1">Ganti oli terakhir: {{ $armada->tanggal_ganti_oli_terakhir?->format('d M Y') ?? '-' }}</p>
                <p class="text-xs text-gray-600">Service terakhir: {{ $armada->tanggal_service_terakhir?->format('d M Y') ?? '-' }}</p>
            </div>
            @empty
            <p class="text-sm text-gray-500">Tidak ada alert maintenance.</p>
            @endforelse
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-navy">Recent Job Orders</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm font-medium text-gray-500 border-b border-gray-100">
                            <th class="px-6 py-3">Nomor JO</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Armada</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recentJobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <a href="{{ route('operasional.job-order.show', $job) }}" class="text-teal hover:text-teal-600 font-medium">{{ $job->nomor_jo }}</a>
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $job->customer?->nama ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $job->armada?->nomor_polisi ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-xs font-medium rounded-full
                                    @if($job->status == 'draft') bg-gray-100 text-gray-700
                                    @elseif($job->status == 'assigned') bg-blue-100 text-blue-700
                                    @elseif($job->status == 'pickup') bg-yellow-100 text-yellow-700
                                    @elseif($job->status == 'on_delivery') bg-orange-100 text-orange-700
                                    @elseif($job->status == 'gate_in') bg-indigo-100 text-indigo-700
                                    @elseif($job->status == 'customs') bg-purple-100 text-purple-700
                                    @elseif($job->status == 'sailing') bg-teal-100 text-teal-700
                                    @elseif($job->status == 'delivered') bg-green-100 text-green-700
                                    @elseif($job->status == 'closed') bg-gray-800 text-white
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $job->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada job order</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-navy">Surat Jalan Aktif</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentSuratJalan as $sj)
                    <div class="px-6 py-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <a href="{{ route('operasional.surat-jalan.show', $sj) }}" class="text-sm font-medium text-teal hover:text-teal-600">{{ $sj->nomor_surat_jalan }}</a>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $sj->armada?->nomor_polisi }} - {{ $sj->tujuan }}</p>
                            </div>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($sj->status == 'diterbitkan') bg-blue-100 text-blue-700
                                @elseif($sj->status == 'dalam_perjalanan') bg-yellow-100 text-yellow-700
                                @elseif($sj->status == 'selesai') bg-green-100 text-green-700
                                @else bg-red-100 text-red-700
                                @endif">{{ str_replace('_', ' ', $sj->status) }}</span>
                        </div>
                    </div>
                    @empty
                    <div class="px-6 py-8 text-center text-sm text-gray-500">Tidak ada surat jalan aktif</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-navy">Pengeluaran Bulan Ini</h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-2xl font-bold text-navy">Rp {{ number_format($stats['total_pengeluaran_bulan'], 0) }}</p>
                    <div class="mt-3 space-y-2">
                        @foreach($pengeluaranBulanIni as $p)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600 capitalize">{{ str_replace('_', ' ', $p->jenis) }}</span>
                            <span class="font-medium">Rp {{ number_format($p->total, 0) }}</span>
                        </div>
                        @endforeach
                        @if($pengeluaranBulanIni->isEmpty())
                        <p class="text-sm text-gray-400">Belum ada pengeluaran</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
