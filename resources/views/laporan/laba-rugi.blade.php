@extends('layouts.app')
@section('title', 'Laba Rugi')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Laporan Laba Rugi</h2>
            <p class="text-gray-500">Periode: {{ $from }} s/d {{ $to }}</p>
        </div>
        <form method="GET" class="flex gap-2 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Dari</label>
                <input type="date" name="from" value="{{ $from }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Sampai</label>
                <input type="date" name="to" value="{{ $to }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            </div>
            <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Tampilkan</button>
            <a href="{{ route('laporan.export-pdf', 'laba-rugi') }}?from={{ $from }}&to={{ $to }}" target="_blank" class="px-4 py-2 bg-navy text-white rounded-lg text-sm hover:bg-navy-700">PDF</a>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Pendapatan (Revenue)</p>
            <p class="text-3xl font-bold text-green-600 mt-1">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">PPN: Rp {{ number_format($ppn, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <p class="text-sm text-gray-500">Total Biaya (Cost)</p>
            <p class="text-3xl font-bold text-red-600 mt-1">Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Job Cost: Rp {{ number_format($costTotal, 0, ',', '.') }} | Pengeluaran: Rp {{ number_format($pengeluaranTotal, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 {{ $profit >= 0 ? 'border-green-500' : 'border-red-500' }}">
            <p class="text-sm text-gray-500">Laba / Rugi</p>
            <p class="text-3xl font-bold {{ $profit >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1">Rp {{ number_format($profit, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-400 mt-1">Margin: {{ $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0 }}%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-navy mb-4">Revenue vs Cost</h3>
            <canvas id="plBarChart" height="160"></canvas>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-sm font-semibold text-navy mb-4">Komposisi Biaya</h3>
            <canvas id="plPieChart" height="160"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Rincian Biaya (per Tipe)</h3>
            <div class="space-y-2">
                @forelse($costByType as $tipe => $total)
                <div class="flex justify-between py-1.5 border-b border-gray-50">
                    <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $tipe) }}</span>
                    <span class="text-sm font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                @empty
                <p class="text-sm text-gray-400">Belum ada biaya</p>
                @endforelse
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-semibold text-navy mb-4">Pengeluaran Operasional</h3>
            <div class="space-y-2">
                @forelse($pengeluaranByType as $jenis => $total)
                <div class="flex justify-between py-1.5 border-b border-gray-50">
                    <span class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $jenis) }}</span>
                    <span class="text-sm font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
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
const red = '#dc2626';
const green = '#059669';

new Chart(document.getElementById('plBarChart'), {
    type: 'bar',
    data: {
        labels: ['Revenue', 'Cost', 'Profit'],
        datasets: [{
            data: [{{ $revenue }}, {{ $totalCost }}, {{ $profit }}],
            backgroundColor: [green, red, '{{ $profit >= 0 ? '#059669' : '#dc2626' }}'],
            borderRadius: 6
        }]
    },
    options: {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp' + (v/1000000).toFixed(0) + 'jt' } } }
    }
});

const costLabels = [];
const costData = [];
@foreach($costByType as $tipe => $total)
costLabels.push('{{ str_replace("_", " ", ucwords($tipe)) }}');
costData.push({{ $total }});
@endforeach
@foreach($pengeluaranByType as $jenis => $total)
costLabels.push('Peng: {{ str_replace("_", " ", ucwords($jenis)) }}');
costData.push({{ $total }});
@endforeach

if (costData.length) {
    new Chart(document.getElementById('plPieChart'), {
        type: 'pie',
        data: {
            labels: costLabels,
            datasets: [{ data: costData, backgroundColor: [teal, red, green, '#ea580c', '#ca8a04', '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16'] }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 9 } } } } }
    });
}
</script>
@endpush
