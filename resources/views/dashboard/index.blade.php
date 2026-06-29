@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-navy">Dashboard Operasional</h2>
        <p class="text-gray-500">Overview sistem logistik CargoGate</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Revenue Bulan Ini</p>
            <p class="text-2xl font-bold text-teal mt-1">Rp {{ number_format($stats['total_revenue_bulan'], 0, ',', '.') }}</p>
            <p class="text-xs {{ $stats['profit_bulan'] >= 0 ? 'text-green-600' : 'text-red-600' }}">Profit: Rp {{ number_format($stats['profit_bulan'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-navy">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Total Shipment</p>
            <p class="text-2xl font-bold text-navy mt-1">{{ $stats['total_shipment'] }}</p>
            <p class="text-xs text-gray-400">{{ $stats['job_in_progress'] }} in progress</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">Armada Aktif</p>
            <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['armada_aktif'] }}</p>
            <p class="text-xs text-gray-400">{{ $stats['armada_subkon'] }} subkon</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <p class="text-xs text-gray-500 uppercase tracking-wide">AR / AP</p>
            <p class="text-2xl font-bold text-orange-600 mt-1">Rp {{ number_format($stats['ar_unpaid'], 0, ',', '.') }}</p>
            <p class="text-xs text-red-600">AP: Rp {{ number_format($stats['ap_unpaid'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Revenue vs Cost (6 Bulan)</h3>
            <canvas id="revenueChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Pengeluaran Bulan Ini</h3>
            <canvas id="pengeluaranChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Job Order Status</h3>
            <canvas id="jobStatusChart" height="180"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Kepemilikan Armada</h3>
            <canvas id="armadaOwnershipChart" height="160"></canvas>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Surat Jalan Aktif</p>
                <p class="text-3xl font-bold text-teal mt-1">{{ $stats['surat_jalan_aktif'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Pengeluaran Bulan</p>
                <p class="text-3xl font-bold text-red-600 mt-1">Rp {{ number_format($stats['total_pengeluaran_bulan'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Driver Aktif</p>
                <p class="text-3xl font-bold text-navy mt-1">{{ $stats['driver_aktif'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Customer Aktif</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['customer_aktif'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Dokumen Expiring</p>
                <p class="text-3xl font-bold text-orange-600 mt-1">{{ $stats['dokumen_expiring'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm p-5 text-center">
                <p class="text-xs text-gray-500">Izin Expiring</p>
                <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $stats['izin_expiring'] }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($dokumenAkanExpired->count())
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                Dokumen Akan Expired
            </h3>
            <div class="space-y-2">
                @foreach($dokumenAkanExpired as $d)
                <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                    <span>{{ $d->armada?->nomor_polisi }} - {{ $d->jenis_dokumen }}</span>
                    <span class="text-red-500 text-xs">{{ $d->tanggal_expired?->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @if($izinAkanExpired->count())
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></path></svg>
                Izin Akan Expired
            </h3>
            <div class="space-y-2">
                @foreach($izinAkanExpired as $i)
                <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                    <span>{{ $i->perijinanable?->nomor_polisi ?? '-' }} - {{ str_replace('_', ' ', $i->jenis_perijinan) }}</span>
                    <span class="text-red-500 text-xs">{{ $i->masa_berlaku?->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    @if($serviceAlerts->count())
    <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
        <h3 class="text-sm font-semibold text-navy mb-3">Peringatan Service Armada</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($serviceAlerts as $a)
            <div class="p-3 bg-yellow-50 rounded-lg">
                <p class="text-sm font-medium">{{ $a->nomor_polisi }}</p>
                <p class="text-xs text-gray-500">Oli: {{ $a->tanggal_ganti_oli_terakhir?->diffForHumans() ?? 'N/A' }}</p>
                <p class="text-xs text-gray-500">Service: {{ $a->tanggal_service_terakhir?->diffForHumans() ?? 'N/A' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Job Order Terbaru</h3>
            <div class="space-y-2">
                @foreach($recentJobs as $j)
                <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                    <span class="truncate">{{ $j->nomor_jo ?? '#' . $j->id }}</span>
                    <span class="text-xs px-1.5 py-0.5 rounded-full
                        @if($j->status == 'delivered') bg-green-100 text-green-700
                        @elseif(in_array($j->status, ['assigned','pickup','on_delivery'])) bg-blue-100 text-blue-700
                        @else bg-yellow-100 text-yellow-700 @endif">{{ str_replace('_', ' ', $j->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Surat Jalan Aktif</h3>
            <div class="space-y-2">
                @foreach($recentSuratJalan as $sj)
                <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                    <span>{{ $sj->nomor_surat_jalan }}</span>
                    <span class="text-xs text-gray-500">{{ $sj->armada?->nomor_polisi ?? '-' }}</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-navy mb-3">Pengeluaran Bulan Ini</h3>
            <div class="space-y-2">
                @forelse($pengeluaranBulanIni as $p)
                <div class="flex justify-between text-sm py-1.5 border-b border-gray-50">
                    <span class="capitalize">{{ str_replace('_', ' ', $p->jenis) }}</span>
                    <span class="font-medium">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400">Belum ada pengeluaran</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const teal = '#07979E';
const navy = '#022864';
const green = '#059669';
const red = '#dc2626';
const orange = '#ea580c';
const yellow = '#ca8a04';

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($monthlyChart, 'bulan')) !!},
        datasets: [
            { label: 'Revenue', data: {!! json_encode(array_column($monthlyChart, 'revenue')) !!}, backgroundColor: teal, borderRadius: 4 },
            { label: 'Cost', data: {!! json_encode(array_column($monthlyChart, 'cost')) !!}, backgroundColor: red, borderRadius: 4 }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp' + (v/1000000).toFixed(0) + 'jt' } } }
    }
});

new Chart(document.getElementById('pengeluaranChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($pengeluaranBulanIni->pluck('jenis')->map(fn($v) => str_replace('_', ' ', ucwords($v)))) !!},
        datasets: [{
            data: {!! json_encode($pengeluaranBulanIni->pluck('total')) !!},
            backgroundColor: [teal, navy, orange, green, red, yellow, '#8b5cf6', '#ec4899']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } } } }
});

new Chart(document.getElementById('jobStatusChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($statusCounts)) !!},
        datasets: [{
            data: {!! json_encode(array_values($statusCounts)) !!},
            backgroundColor: ['#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444', '#f97316', '#10b981', '#6b7280']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } } } }
});

new Chart(document.getElementById('armadaOwnershipChart'), {
    type: 'bar',
    data: {
        labels: ['Milik Sendiri', 'Subkon Armada', 'Subkon Driver', 'Subkon Keduanya'],
        datasets: [{
            label: 'Jumlah',
            data: [{{ $milikSendiri }}, {{ $subkonArmada }}, {{ $subkonDriver }}, {{ $subkonKeduanya }}],
            backgroundColor: [teal, navy, orange, green],
            borderRadius: 4
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});
</script>
@endpush