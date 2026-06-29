@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-navy tracking-tight">Dashboard</h1>
            <p class="text-sm text-gray-400 mt-0.5">Selamat datang, {{ auth()->user()->name }} &mdash; {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Online</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card gradient-teal text-white">
            <div class="stat-icon"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg></div>
            <p class="text-sm font-medium text-white/80">Revenue Bulan Ini</p>
            <p class="text-2xl font-bold mt-1 tracking-tight">Rp {{ number_format($stats['total_revenue_bulan'], 0, ',', '.') }}</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs text-white/70">
                <span>Profit:</span>
                <span class="font-semibold {{ $stats['profit_bulan'] >= 0 ? 'text-green-200' : 'text-red-200' }}">
                    Rp {{ number_format($stats['profit_bulan'], 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="stat-card gradient-navy text-white">
            <div class="stat-icon"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M20 8h-2.81c-.45-.78-1.07-1.45-1.82-1.96L17 4.41 15.59 3l-2.17 2.17C12.96 5.06 12.49 5 12 5c-.49 0-.96.06-1.41.17L8.41 3 7 4.41l1.62 1.63C7.88 6.55 7.26 7.22 6.81 8H4v2h2.09c-.05.33-.09.66-.09 1v1H4v2h2v1c0 .34.04.67.09 1H4v2h2.81c1.04 1.79 2.97 3 5.19 3s4.15-1.21 5.19-3H20v-2h-2.09c.05-.33.09-.66.09-1v-1h2v-2h-2v-1c0-.34-.04-.67-.09-1H20V8zm-6 8h-4v-2h4v2zm0-4h-4v-2h4v2z"/></svg></div>
            <p class="text-sm font-medium text-white/80">Total Shipment</p>
            <p class="text-2xl font-bold mt-1 tracking-tight">{{ $stats['total_shipment'] }}</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs text-white/70">
                <span>{{ $stats['job_delivered'] }} delivered</span>
                <span class="mx-1">&bull;</span>
                <span>{{ $stats['job_in_progress'] }} in progress</span>
            </div>
        </div>
        <div class="stat-card gradient-green text-white">
            <div class="stat-icon"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.5 16c-.83 0-1.5-.67-1.5-1.5S5.67 13 6.5 13s1.5.67 1.5 1.5S7.33 16 6.5 16zm11 0c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zM5 11l1.5-4.5h11L19 11H5z"/></svg></div>
            <p class="text-sm font-medium text-white/80">Armada Aktif</p>
            <p class="text-2xl font-bold mt-1 tracking-tight">{{ $stats['armada_aktif'] }}</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs text-white/70">
                <span>{{ $stats['armada_subkon'] }} subkon</span>
                <span class="mx-1">&bull;</span>
                <span>{{ $stats['driver_aktif'] }} driver</span>
            </div>
        </div>
        <div class="stat-card gradient-orange text-white">
            <div class="stat-icon"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg></div>
            <p class="text-sm font-medium text-white/80">AR / AP</p>
            <p class="text-2xl font-bold mt-1 tracking-tight">Rp {{ number_format($stats['ar_unpaid'], 0, ',', '.') }}</p>
            <div class="flex items-center gap-1.5 mt-2 text-xs text-white/70">
                <span>Piutang (AR)</span>
                <span class="mx-1">&bull;</span>
                <span>AP: Rp {{ number_format($stats['ap_unpaid'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="chart-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy">Revenue vs Cost</h3>
                <span class="chart-kicker">6 bulan terakhir</span>
            </div>
            <canvas id="revenueChart" class="dashboard-chart"></canvas>
        </div>
        <div class="chart-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy">Pengeluaran</h3>
                <span class="chart-kicker">Bulan ini</span>
            </div>
            <canvas id="pengeluaranChart" class="dashboard-chart"></canvas>
        </div>
        <div class="chart-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy">Job Status</h3>
                <span class="chart-kicker">Semua waktu</span>
            </div>
            <canvas id="jobStatusChart" class="dashboard-chart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2">
            <div class="chart-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-navy">Job Order Terbaru</h3>
                    <span class="text-xs text-gray-400">10 terakhir</span>
                </div>
                <div class="space-y-1">
                    @forelse($recentJobs as $j)
                    <div class="reminder-item">
                        <div class="w-2 h-2 rounded-full flex-shrink-0
                            @if($j->status == 'delivered') bg-green-500
                            @elseif(in_array($j->status, ['assigned','pickup','on_delivery'])) bg-blue-500
                            @elseif($j->status == 'customs') bg-purple-500
                            @else bg-yellow-500 @endif"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $j->nomor_jo ?? 'JO #' . $j->id }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $j->customer?->nama ?? '-' }} &middot; {{ $j->armada?->nomor_polisi ?? '-' }}</p>
                        </div>
                        <span class="badge
                            @if($j->status == 'delivered') bg-green-100 text-green-700
                            @elseif(in_array($j->status, ['assigned','pickup','on_delivery'])) bg-blue-100 text-blue-700
                            @elseif($j->status == 'customs') bg-purple-100 text-purple-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ str_replace('_', ' ', $j->status) }}
                        </span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-6">Belum ada job order</p>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="space-y-5">
            <div class="chart-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-navy">Kepemilikan Armada</h3>
                </div>
                <canvas id="armadaOwnershipChart" class="dashboard-chart-sm"></canvas>
                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div class="text-center p-2 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-400">Milik Sendiri</p>
                        <p class="text-lg font-bold text-navy">{{ $milikSendiri }}</p>
                    </div>
                    <div class="text-center p-2 bg-gray-50 rounded-xl">
                        <p class="text-xs text-gray-400">Subkon</p>
                        <p class="text-lg font-bold text-teal">{{ $subkonArmada + $subkonDriver + $subkonKeduanya }}</p>
                    </div>
                </div>
            </div>
            <div class="chart-card">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-navy">Quick Stats</h3>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-400">Surat Jalan</p>
                        <p class="text-xl font-bold text-teal">{{ $stats['surat_jalan_aktif'] }}</p>
                        <p class="text-[10px] text-gray-400">aktif</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-400">Pengeluaran</p>
                        <p class="text-lg font-bold text-red-600">Rp {{ number_format($stats['total_pengeluaran_bulan'] / 1000000, 1, ',', '.') }}jt</p>
                        <p class="text-[10px] text-gray-400">bulan ini</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-400">Customer</p>
                        <p class="text-xl font-bold text-green-600">{{ $stats['customer_aktif'] }}</p>
                        <p class="text-[10px] text-gray-400">aktif</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 text-center">
                        <p class="text-xs text-gray-400">Container</p>
                        <p class="text-xl font-bold text-navy">{{ $stats['container_aktif'] }}</p>
                        <p class="text-[10px] text-gray-400">aktif</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($dokumenAkanExpired->count() || $izinAkanExpired->count())
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        @if($dokumenAkanExpired->count())
        <div class="chart-card border-l-4 border-yellow-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy flex items-center gap-2">
                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    Dokumen Akan Expired
                </h3>
                <span class="text-xs text-gray-400">{{ $dokumenAkanExpired->count() }} item</span>
            </div>
            <div class="space-y-1">
                @foreach($dokumenAkanExpired as $d)
                <div class="reminder-item">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $d->armada?->nomor_polisi ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ $d->jenis_dokumen }} &middot; {{ $d->nomor_dokumen ?? '-' }}</p>
                    </div>
                    <span class="text-xs font-medium {{ $d->tanggal_expired?->isPast() ? 'text-red-600' : 'text-orange-600' }}">
                        {{ $d->tanggal_expired?->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @if($izinAkanExpired->count())
        <div class="chart-card border-l-4 border-red-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy flex items-center gap-2">
                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                    Izin Akan Expired
                </h3>
                <span class="text-xs text-gray-400">{{ $izinAkanExpired->count() }} item</span>
            </div>
            <div class="space-y-1">
                @foreach($izinAkanExpired as $i)
                <div class="reminder-item">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $i->perijinanable?->nomor_polisi ?? '-' }}</p>
                        <p class="text-xs text-gray-400">{{ str_replace('_', ' ', $i->jenis_perijinan) }}</p>
                    </div>
                    <span class="text-xs font-medium {{ $i->masa_berlaku?->isPast() ? 'text-red-600' : 'text-orange-600' }}">
                        {{ $i->masa_berlaku?->diffForHumans() }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($serviceAlerts->count())
    <div class="chart-card border-l-4 border-yellow-500 bg-gradient-to-r from-yellow-50/50 to-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-navy flex items-center gap-2">
                <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                Peringatan Service Armada
            </h3>
            <span class="text-xs text-gray-400">{{ $serviceAlerts->count() }} armada</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($serviceAlerts as $a)
            <div class="bg-white rounded-xl p-3 border border-gray-100 flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ $a->nomor_polisi }}</p>
                    <p class="text-xs text-gray-400">Oli: {{ $a->tanggal_ganti_oli_terakhir?->diffForHumans() ?? 'N/A' }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="chart-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy">Surat Jalan Aktif</h3>
                <span class="text-xs text-gray-400">{{ $recentSuratJalan->count() }} terbaru</span>
            </div>
            <div class="space-y-1">
                @forelse($recentSuratJalan as $sj)
                <div class="reminder-item">
                    <div class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800">{{ $sj->nomor_surat_jalan }}</p>
                        <p class="text-xs text-gray-400">{{ $sj->jobOrder?->customer?->nama ?? '-' }} &middot; {{ $sj->armada?->nomor_polisi ?? '-' }}</p>
                    </div>
                    <span class="badge
                        @if($sj->status == 'selesai') bg-green-100 text-green-700
                        @elseif($sj->status == 'dalam_perjalanan') bg-blue-100 text-blue-700
                        @else bg-yellow-100 text-yellow-700 @endif">
                        {{ str_replace('_', ' ', $sj->status) }}
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada surat jalan</p>
                @endforelse
            </div>
        </div>
        <div class="chart-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-navy">Pengeluaran Bulan Ini</h3>
                <span class="text-xs text-gray-400">Total: Rp {{ number_format($stats['total_pengeluaran_bulan'], 0, ',', '.') }}</span>
            </div>
            <div class="space-y-1">
                @forelse($pengeluaranBulanIni as $p)
                <div class="reminder-item">
                    <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 capitalize">{{ str_replace('_', ' ', $p->jenis) }}</p>
                    </div>
                    <span class="text-sm font-semibold text-red-600">Rp {{ number_format($p->total, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-6">Belum ada pengeluaran</p>
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
const purple = '#7c3aed';
const slate = '#64748b';
const grid = '#e2e8f0';
const moneyTick = value => 'Rp' + (value / 1000000).toFixed(value >= 10000000 ? 0 : 1).replace('.0', '') + 'jt';
const rupiah = value => 'Rp ' + Number(value || 0).toLocaleString('id-ID');
const axisStyle = {
    x: {
        border: { display: false },
        grid: { display: false },
        ticks: { color: slate, font: { size: 11, weight: 500 } }
    },
    y: {
        beginAtZero: true,
        border: { display: false },
        grid: { color: grid, drawTicks: false },
        ticks: { color: slate, padding: 10, font: { size: 10 }, callback: moneyTick }
    }
};
const bottomLegend = {
    position: 'bottom',
    labels: { boxWidth: 8, boxHeight: 8, usePointStyle: true, padding: 16, color: slate, font: { size: 11, weight: 500 } }
};

new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($monthlyChart, 'bulan')) !!},
        datasets: [
            { label: 'Revenue', data: {!! json_encode(array_column($monthlyChart, 'revenue')) !!}, backgroundColor: teal, borderColor: '#10b8bf', borderWidth: 1, borderRadius: 10, borderSkipped: false, barPercentage: 0.7, categoryPercentage: 0.62 },
            { label: 'Cost', data: {!! json_encode(array_column($monthlyChart, 'cost')) !!}, backgroundColor: red, borderColor: '#ef4444', borderWidth: 1, borderRadius: 10, borderSkipped: false, barPercentage: 0.7, categoryPercentage: 0.62 }
        ]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: {
            legend: bottomLegend,
            tooltip: { callbacks: { label: context => `${context.dataset.label}: ${rupiah(context.parsed.y)}` } }
        },
        scales: axisStyle
    }
});

const pengeluaranLabels = {!! json_encode($pengeluaranBulanIni->pluck('jenis')->map(fn($v) => str_replace('_', ' ', ucwords($v)))) !!};
const pengeluaranData = {!! json_encode($pengeluaranBulanIni->pluck('total')) !!};
if (pengeluaranData.length) {
    new Chart(document.getElementById('pengeluaranChart'), {
        type: 'doughnut',
        data: {
            labels: pengeluaranLabels,
            datasets: [{ data: pengeluaranData, backgroundColor: [teal, navy, orange, green, red, yellow, purple, '#ec4899', '#06b6d4', '#84cc16'], borderColor: '#ffffff', borderWidth: 4, hoverOffset: 8 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: bottomLegend,
                tooltip: { callbacks: { label: context => `${context.label}: ${rupiah(context.parsed)}` } }
            }
        }
    });
}

const statusData = {!! json_encode(array_values($statusCounts)) !!};
if (statusData.some(v => v > 0)) {
    new Chart(document.getElementById('jobStatusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($statusCounts)) !!},
            datasets: [{ data: statusData, backgroundColor: ['#2563eb', '#f59e0b', '#8b5cf6', '#ef4444', '#f97316', '#10b981', '#6b7280'], borderColor: '#ffffff', borderWidth: 4, hoverOffset: 8 }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: bottomLegend
            }
        }
    });
}

new Chart(document.getElementById('armadaOwnershipChart'), {
    type: 'bar',
    data: {
        labels: ['Sendiri', 'Subkon Armada', 'Subkon Driver', 'Subkon Keduanya'],
        datasets: [{
            data: [{{ $milikSendiri }}, {{ $subkonArmada }}, {{ $subkonDriver }}, {{ $subkonKeduanya }}],
            backgroundColor: [navy, teal, orange, green],
            borderRadius: 10,
            borderSkipped: false,
            barPercentage: 0.58,
            categoryPercentage: 0.72
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: axisStyle.x,
            y: { ...axisStyle.y, ticks: { color: slate, stepSize: 1, padding: 10, font: { size: 10 } } }
        }
    }
});
</script>
@endpush
