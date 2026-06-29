@extends('layouts.pdf')
@section('title', 'Neraca')
@section('subtitle', 'Neraca per ' . $tanggal)
@section('content')
<div class="section-title">Aktiva</div>
<table class="summary-grid">
    <tr><td><strong>Kas</strong></td><td class="text-right">Rp {{ number_format($kas, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Piutang (AR)</strong></td><td class="text-right">Rp {{ number_format($totalAr, 0, ',', '.') }}</td></tr>
    <tr style="border-top:2px solid #022864"><td><strong>Total Aktiva</strong></td><td class="text-right text-bold">Rp {{ number_format($kas + $totalAr, 0, ',', '.') }}</td></tr>
</table>
<div class="section-title">Pasiva</div>
<table class="summary-grid">
    <tr><td><strong>Utang (AP)</strong></td><td class="text-right">Rp {{ number_format($totalAp, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Ekuitas</strong></td><td class="text-right">Rp {{ number_format($equity, 0, ',', '.') }}</td></tr>
    <tr style="border-top:2px solid #022864"><td><strong>Total Pasiva</strong></td><td class="text-right text-bold">Rp {{ number_format($totalAp + $equity, 0, ',', '.') }}</td></tr>
</table>
<div class="section-title">Detail</div>
<table class="summary-grid">
    <tr><td>Total Revenue</td><td class="text-right">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td></tr>
    <tr><td>Total Cost</td><td class="text-right">Rp {{ number_format($totalCost, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Ekuitas</strong></td><td class="text-right text-bold">Rp {{ number_format($equity, 0, ',', '.') }}</td></tr>
</table>
@endsection