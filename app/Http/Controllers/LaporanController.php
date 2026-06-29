<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\JobOrder;
use App\Models\Customer;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Cost;
use App\Models\Payment;
use App\Models\ApArmada;
use App\Models\ArArmada;
use App\Models\ClosingBulanan;
use App\Models\PengeluaranArmada;
use App\Models\UangJalan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function aging(Request $request)
    {
        $type = $request->input('type', 'ar');

        if ($type === 'ap') {
            $items = ApArmada::with(['vendor', 'jobOrder'])
                ->whereIn('status', ['unpaid', 'overdue'])
                ->get();
            $totalUnpaid = $items->sum('jumlah');
        } else {
            $items = ArArmada::with(['customer', 'jobOrder'])
                ->whereIn('status', ['unpaid', 'overdue'])
                ->get();
            $totalUnpaid = $items->sum('jumlah');
        }

        $aging = [
            '0-30' => ['items' => collect(), 'total' => 0],
            '31-60' => ['items' => collect(), 'total' => 0],
            '61-90' => ['items' => collect(), 'total' => 0],
            '90+' => ['items' => collect(), 'total' => 0],
        ];

        foreach ($items as $item) {
            $tanggal = $item->jatuh_tempo ?? $item->tanggal;
            $days = $tanggal ? now()->diffInDays($tanggal, false) : 0;

            if ($days <= 30) $bucket = '0-30';
            elseif ($days <= 60) $bucket = '31-60';
            elseif ($days <= 90) $bucket = '61-90';
            else $bucket = '90+';

            if ($days < 0) {
                $bucket = '0-30';
            }

            $aging[$bucket]['items']->push($item);
            $aging[$bucket]['total'] += $item->jumlah;
        }

        return view('laporan.aging', compact('aging', 'type', 'totalUnpaid'));
    }

    public function outstanding(Request $request)
    {
        $type = $request->input('type', 'ar');

        if ($type === 'ap') {
            $data = ApArmada::with(['vendor', 'jobOrder'])
                ->whereIn('status', ['unpaid', 'overdue'])
                ->latest()->paginate(20)->withQueryString();
            $total = ApArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        } else {
            $data = ArArmada::with(['customer', 'jobOrder'])
                ->whereIn('status', ['unpaid', 'overdue'])
                ->latest()->paginate(20)->withQueryString();
            $total = ArArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        }

        return view('laporan.outstanding', compact('data', 'type', 'total'));
    }

    public function reminder(Request $request)
    {
        $type = $request->input('type', 'ar');

        $query = $type === 'ap'
            ? ApArmada::with(['vendor', 'jobOrder'])->whereIn('status', ['unpaid', 'overdue'])->whereNotNull('jatuh_tempo')
            : ArArmada::with(['customer', 'jobOrder'])->whereIn('status', ['unpaid', 'overdue'])->whereNotNull('jatuh_tempo');

        $items = $query->get()->filter(function ($item) {
            return now()->diffInDays($item->jatuh_tempo, false) <= 14;
        })->values();

        return view('laporan.reminder', compact('items', 'type'));
    }

    public function labaRugi(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->endOfMonth()->format('Y-m-d'));

        $invoiceQuery = Invoice::whereBetween('tanggal_invoice', [$from, $to]);
        $costQuery = Cost::whereBetween('tanggal', [$from, $to]);
        $pengeluaranQuery = PengeluaranArmada::whereBetween('tanggal', [$from, $to]);

        $revenue = $invoiceQuery->sum('total');
        $ppn = $invoiceQuery->sum('ppn');
        $costTotal = $costQuery->sum('jumlah');
        $pengeluaranTotal = $pengeluaranQuery->sum('jumlah');
        $totalCost = $costTotal + $pengeluaranTotal;
        $profit = $revenue - $totalCost;

        $costByType = Cost::whereBetween('tanggal', [$from, $to])
            ->selectRaw('tipe, sum(jumlah) as total')
            ->groupBy('tipe')->pluck('total', 'tipe');

        $pengeluaranByType = PengeluaranArmada::whereBetween('tanggal', [$from, $to])
            ->selectRaw('jenis, sum(jumlah) as total')
            ->groupBy('jenis')->pluck('total', 'jenis');

        return view('laporan.laba-rugi', compact(
            'from', 'to', 'revenue', 'ppn', 'costTotal',
            'pengeluaranTotal', 'totalCost', 'profit',
            'costByType', 'pengeluaranByType'
        ));
    }

    public function neraca(Request $request)
    {
        $tanggal = $request->input('tanggal', now()->format('Y-m-d'));

        $totalAr = ArArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        $totalAp = ApArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        $cashIn = Payment::sum('jumlah');
        $cashOut = PengeluaranArmada::where('status', 'approved')->sum('jumlah');
        $kas = $cashIn - $cashOut;

        $totalRevenue = Invoice::sum('total');
        $totalCost = Cost::sum('jumlah') + PengeluaranArmada::where('status', 'approved')->sum('jumlah');
        $equity = $totalRevenue - $totalCost;

        return view('laporan.neraca', compact(
            'tanggal', 'kas', 'totalAr', 'totalAp', 'equity', 'totalRevenue', 'totalCost'
        ));
    }

    public function cashFlow(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->endOfMonth()->format('Y-m-d'));

        $cashIn = Payment::whereBetween('tanggal_pembayaran', [$from, $to])->sum('jumlah');
        $apPaid = ApArmada::where('status', 'paid')
            ->whereBetween('tanggal_bayar', [$from, $to])->sum('jumlah');
        $pengeluaranApproved = PengeluaranArmada::where('status', 'approved')
            ->whereBetween('tanggal', [$from, $to])->sum('jumlah');
        $cashOut = $apPaid + $pengeluaranApproved;
        $netCash = $cashIn - $cashOut;

        $cashInByMetode = Payment::whereBetween('tanggal_pembayaran', [$from, $to])
            ->selectRaw('metode, sum(jumlah) as total')
            ->groupBy('metode')->pluck('total', 'metode');

        return view('laporan.cash-flow', compact(
            'from', 'to', 'cashIn', 'cashOut', 'netCash', 'cashInByMetode', 'apPaid', 'pengeluaranApproved'
        ));
    }

    public function profitPerCustomer(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $customers = Customer::where('status', 'aktif')->get()->map(function ($c) use ($from, $to) {
            $invoiceQuery = Invoice::where('customer_id', $c->id);
            $jobQuery = JobOrder::where('customer_id', $c->id)->whereIn('status', ['delivered', 'closed']);
            if ($from) { $invoiceQuery->whereDate('tanggal_invoice', '>=', $from); $jobQuery->whereDate('created_at', '>=', $from); }
            if ($to) { $invoiceQuery->whereDate('tanggal_invoice', '<=', $to); $jobQuery->whereDate('created_at', '<=', $to); }

            $revenue = $invoiceQuery->sum('total');
            $jobs = $jobQuery->pluck('id');
            $cost = Cost::whereIn('job_order_id', $jobs)->sum('jumlah');
            $profit = $revenue - $cost;
            $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0;
            return compact('c', 'revenue', 'cost', 'profit', 'margin');
        })->sortByDesc('profit');

        return view('laporan.profit-per-customer', compact('customers', 'from', 'to'));
    }

    public function profitPerArmada(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $armadas = Armada::where('status', 'aktif')->get()->map(function ($a) use ($from, $to) {
            $sjIds = $a->suratJalan->pluck('id');
            $joIds = \App\Models\SuratJalan::whereIn('id', $sjIds)->pluck('job_order_id')->unique();

            $invoiceQuery = Invoice::whereIn('job_order_id', $joIds);
            $costQuery = Cost::whereIn('job_order_id', $joIds);
            $pengeluaranQuery = $a->pengeluaran();

            if ($from) {
                $invoiceQuery->whereDate('tanggal_invoice', '>=', $from);
                $costQuery->whereDate('tanggal', '>=', $from);
                $pengeluaranQuery->whereDate('tanggal', '>=', $from);
            }
            if ($to) {
                $invoiceQuery->whereDate('tanggal_invoice', '<=', $to);
                $costQuery->whereDate('tanggal', '<=', $to);
                $pengeluaranQuery->whereDate('tanggal', '<=', $to);
            }

            $revenue = $invoiceQuery->sum('total');
            $cost = $costQuery->sum('jumlah');
            $pengeluaran = $pengeluaranQuery->sum('jumlah');
            $totalCost = $cost + $pengeluaran;
            $profit = $revenue - $totalCost;
            $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0;
            return (object) compact('a', 'revenue', 'totalCost', 'profit', 'margin');
        })->sortByDesc('profit');

        return view('laporan.profit-per-armada', compact('armadas', 'from', 'to'));
    }

    public function profitPerDriver(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $drivers = Driver::where('status', 'aktif')->get()->map(function ($d) use ($from, $to) {
            $sjIds = \App\Models\SuratJalan::where('driver_id', $d->id)->pluck('id');
            $joIds = \App\Models\SuratJalan::whereIn('id', $sjIds)->pluck('job_order_id')->unique();

            $invoiceQuery = Invoice::whereIn('job_order_id', $joIds);
            $costQuery = Cost::whereIn('job_order_id', $joIds);
            $pengeluaranQuery = PengeluaranArmada::where('driver_id', $d->id);

            if ($from) {
                $invoiceQuery->whereDate('tanggal_invoice', '>=', $from);
                $costQuery->whereDate('tanggal', '>=', $from);
                $pengeluaranQuery->whereDate('tanggal', '>=', $from);
            }
            if ($to) {
                $invoiceQuery->whereDate('tanggal_invoice', '<=', $to);
                $costQuery->whereDate('tanggal', '<=', $to);
                $pengeluaranQuery->whereDate('tanggal', '<=', $to);
            }

            $revenue = $invoiceQuery->sum('total');
            $cost = $costQuery->sum('jumlah');
            $pengeluaran = $pengeluaranQuery->sum('jumlah');
            $totalCost = $cost + $pengeluaran;
            $profit = $revenue - $totalCost;
            $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0;
            return (object) compact('d', 'revenue', 'totalCost', 'profit', 'margin');
        })->sortByDesc('profit');

        return view('laporan.profit-per-driver', compact('drivers', 'from', 'to'));
    }

    public function closingIndex()
    {
        $closings = ClosingBulanan::with('closedBy')->latest()->paginate(12);
        return view('laporan.closing.index', compact('closings'));
    }

    public function closingCreate()
    {
        $months = [];
        $start = now()->subMonths(12);
        for ($i = 0; $i < 13; $i++) {
            $m = $start->copy()->addMonths($i);
            $months[$m->format('Y-m')] = $m->format('F Y');
        }

        $existing = ClosingBulanan::pluck('bulan')->toArray();
        $availableMonths = array_diff_key($months, array_flip($existing));

        return view('laporan.closing.create', compact('availableMonths'));
    }

    public function closingStore(Request $request)
    {
        $bulan = $request->input('bulan', now()->format('Y-m'));
        [$year, $month] = explode('-', $bulan);
        $start = "$year-$month-01";
        $end = date('Y-m-t', strtotime($start));

        $revenue = Invoice::whereBetween('tanggal_invoice', [$start, $end])->sum('total');
        $cost = Cost::whereBetween('tanggal', [$start, $end])->sum('jumlah')
            + PengeluaranArmada::whereBetween('tanggal', [$start, $end])->where('status', 'approved')->sum('jumlah');
        $ar = ArArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        $ap = ApArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
        $cashIn = Payment::whereBetween('tanggal_pembayaran', [$start, $end])->sum('jumlah');
        $cashOut = PengeluaranArmada::whereBetween('tanggal', [$start, $end])->where('status', 'approved')->sum('jumlah');

        ClosingBulanan::create([
            'bulan' => $bulan,
            'tanggal_closing' => now(),
            'total_revenue' => $revenue,
            'total_cost' => $cost,
            'total_profit' => $revenue - $cost,
            'total_ar' => $ar,
            'total_ap' => $ap,
            'cash_in' => $cashIn,
            'cash_out' => $cashOut,
            'closed_by' => auth()->id(),
        ]);

        return redirect()->route('laporan.closing.index')
            ->with('success', "Closing bulan $bulan berhasil.");
    }

    public function closingShow(ClosingBulanan $closing)
    {
        return view('laporan.closing.show', compact('closing'));
    }

    public function exportPdf(Request $request, string $type)
    {
        $data = $request->all();

        switch ($type) {
            case 'laba-rugi':
                $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
                $to = $request->input('to', now()->endOfMonth()->format('Y-m-d'));
                $invoiceQuery = Invoice::whereBetween('tanggal_invoice', [$from, $to]);
                $costQuery = Cost::whereBetween('tanggal', [$from, $to]);
                $pengeluaranQuery = PengeluaranArmada::whereBetween('tanggal', [$from, $to]);
                $revenue = $invoiceQuery->sum('total');
                $ppn = $invoiceQuery->sum('ppn');
                $costTotal = $costQuery->sum('jumlah');
                $pengeluaranTotal = $pengeluaranQuery->sum('jumlah');
                $totalCost = $costTotal + $pengeluaranTotal;
                $profit = $revenue - $totalCost;
                $costByType = Cost::whereBetween('tanggal', [$from, $to])
                    ->selectRaw('tipe, sum(jumlah) as total')->groupBy('tipe')->pluck('total', 'tipe');
                $pengeluaranByType = PengeluaranArmada::whereBetween('tanggal', [$from, $to])
                    ->selectRaw('jenis, sum(jumlah) as total')->groupBy('jenis')->pluck('total', 'jenis');
                $pdf = Pdf::loadView('laporan.pdf.laba-rugi', compact(
                    'from', 'to', 'revenue', 'ppn', 'costTotal', 'pengeluaranTotal', 'totalCost', 'profit', 'costByType', 'pengeluaranByType'
                ));
                return $pdf->download("laba-rugi-$from-$to.pdf");
                break;

            case 'neraca':
                $tanggal = $request->input('tanggal', now()->format('Y-m-d'));
                $totalAr = ArArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
                $totalAp = ApArmada::whereIn('status', ['unpaid', 'overdue'])->sum('jumlah');
                $cashIn = Payment::sum('jumlah');
                $cashOut = PengeluaranArmada::where('status', 'approved')->sum('jumlah');
                $kas = $cashIn - $cashOut;
                $totalRevenue = Invoice::sum('total');
                $totalCost = Cost::sum('jumlah') + PengeluaranArmada::where('status', 'approved')->sum('jumlah');
                $equity = $totalRevenue - $totalCost;
                $pdf = Pdf::loadView('laporan.pdf.neraca', compact('tanggal', 'kas', 'totalAr', 'totalAp', 'equity', 'totalRevenue', 'totalCost'));
                return $pdf->download("neraca-$tanggal.pdf");
                break;

            case 'cash-flow':
                $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
                $to = $request->input('to', now()->endOfMonth()->format('Y-m-d'));
                $cashIn = Payment::whereBetween('tanggal_pembayaran', [$from, $to])->sum('jumlah');
                $apPaid = ApArmada::where('status', 'paid')
                    ->whereBetween('tanggal_bayar', [$from, $to])->sum('jumlah');
                $pengeluaranApproved = PengeluaranArmada::where('status', 'approved')
                    ->whereBetween('tanggal', [$from, $to])->sum('jumlah');
                $cashOut = $apPaid + $pengeluaranApproved;
                $netCash = $cashIn - $cashOut;
                $cashInByMetode = Payment::whereBetween('tanggal_pembayaran', [$from, $to])
                    ->selectRaw('metode, sum(jumlah) as total')->groupBy('metode')->pluck('total', 'metode');
                $pdf = Pdf::loadView('laporan.pdf.cash-flow', compact(
                    'from', 'to', 'cashIn', 'cashOut', 'netCash', 'cashInByMetode', 'apPaid', 'pengeluaranApproved'
                ));
                return $pdf->download("cash-flow-$from-$to.pdf");
                break;

            default:
                abort(404);
        }
    }
}
