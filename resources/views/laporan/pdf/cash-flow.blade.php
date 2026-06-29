@extends('layouts.pdf')
@section('title', 'Cash Flow')
@section('subtitle', 'Laporan Arus Kas - Periode ' . $from . ' s/d ' . $to)
@section('content')
<div class="section-title">Cash In (Pemasukan)</div>
<table class="summary-grid">
    <tr><td><strong>Total Penerimaan Pembayaran</strong></td><td class="text-right text-green text-bold">Rp {{ number_format($cashIn, 0, ',', '.') }}</td></tr>
</table>
@if($cashInByMetode->count())
<table style="margin-top:4px">
    <tr><th>Metode</th><th class="text-right">Total</th></tr>
    @foreach($cashInByMetode as $metode => $total)
    <tr><td>{{ ucwords($metode) }}</td><td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td></tr>
    @endforeach
</table>
@endif
<div class="section-title">Cash Out (Pengeluaran)</div>
<table class="summary-grid">
    <tr><td><strong>AP Paid</strong></td><td class="text-right">Rp {{ number_format($apPaid, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Pengeluaran Operasional</strong></td><td class="text-right">Rp {{ number_format($pengeluaranApproved, 0, ',', '.') }}</td></tr>
    <tr style="border-top:1px solid #022864"><td><strong>Total Cash Out</strong></td><td class="text-right text-bold">Rp {{ number_format($cashOut, 0, ',', '.') }}</td></tr>
</table>
<div class="section-title">Net Cash Flow</div>
<table class="summary-grid">
    <tr><td><strong>Total Cash In</strong></td><td class="text-right">Rp {{ number_format($cashIn, 0, ',', '.') }}</td></tr>
    <tr><td><strong>Total Cash Out</strong></td><td class="text-right">Rp {{ number_format($cashOut, 0, ',', '.') }}</td></tr>
    <tr style="border-top:2px solid #022864"><td><strong>Net Cash Flow</strong></td><td class="text-right text-bold {{ $netCash >= 0 ? 'text-green' : 'text-red' }}">Rp {{ number_format($netCash, 0, ',', '.') }}</td></tr>
</table>
@endsection