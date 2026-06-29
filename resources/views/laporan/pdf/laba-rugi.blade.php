@extends('layouts.pdf')
@section('title', 'Laporan Laba Rugi')
@section('subtitle', 'Laporan Laba Rugi - Periode ' . $from . ' s/d ' . $to)
@section('content')
<table class="summary-grid">
    <tr><td><strong>Pendapatan (Revenue)</strong></td><td class="text-right text-green text-bold">Rp {{ number_format($revenue, 0, ',', '.') }}</td></tr>
    <tr><td>PPN</td><td class="text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td></tr>
</table>
<div class="section-title">Rincian Biaya</div>
<table>
    <tr><th>Jenis</th><th class="text-right">Total</th></tr>
    @foreach($costByType as $tipe => $total)
    <tr><td>{{ str_replace('_', ' ', ucwords($tipe)) }}</td><td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td></tr>
    @endforeach
    @foreach($pengeluaranByType as $jenis => $total)
    <tr><td>Pengeluaran - {{ str_replace('_', ' ', ucwords($jenis)) }}</td><td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td></tr>
    @endforeach
    <tr style="border-top:2px solid #022864"><td><strong>Total Biaya</strong></td><td class="text-right text-bold">Rp {{ number_format($costTotal + $pengeluaranTotal, 0, ',', '.') }}</td></tr>
</table>
<div class="section-title">Ringkasan</div>
<table class="summary-grid">
    <tr><td><strong>Revenue</strong></td><td class="text-right">Rp {{ number_format($revenue, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Total Cost</strong></td><td class="text-right">Rp {{ number_format($totalCost, 0, ',', '.') }}</td></tr>
    <tr style="border-top:2px solid #022864"><td><strong>Labaa / Rugi</strong></td><td class="text-right text-bold {{ $profit >= 0 ? 'text-green' : 'text-red' }}">Rp {{ number_format($profit, 0, ',', '.') }}</td></tr>
</table>
@endsection