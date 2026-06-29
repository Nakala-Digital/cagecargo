<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Container;
use App\Models\Customer;
use App\Models\SuratJalan;
use App\Models\PengeluaranArmada;
use App\Models\ApArmada;
use App\Models\ArArmada;
use App\Models\BudgetArmada;
use App\Models\DokumenArmada;
use App\Models\DokumenIzin;
use App\Models\Invoice;
use App\Models\Cost;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shipment' => JobOrder::count(),
            'armada_aktif' => Armada::where('status', 'aktif')->count(),
            'armada_subkon' => Armada::where('jenis_kepemilikan', 'like', 'subkon%')->count(),
            'container_aktif' => Container::where('status', 'aktif')->count(),
            'driver_aktif' => Driver::where('status', 'aktif')->count(),
            'customer_aktif' => Customer::where('status', 'aktif')->count(),
            'job_delivered' => JobOrder::where('status', 'delivered')->count(),
            'job_in_progress' => JobOrder::whereIn('status', ['assigned', 'pickup', 'on_delivery', 'gate_in', 'customs'])->count(),
            'pending_customs' => JobOrder::where('status', 'customs')->count(),
            'surat_jalan_aktif' => SuratJalan::whereIn('status', ['diterbitkan', 'dalam_perjalanan'])->count(),
            'total_pengeluaran_bulan' => PengeluaranArmada::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)->sum('jumlah'),
            'ap_unpaid' => ApArmada::where('status', 'unpaid')->sum('jumlah'),
            'ar_unpaid' => ArArmada::where('status', 'unpaid')->sum('jumlah'),
            'armada_perlu_service' => Armada::where('status', 'aktif')
                ->where(function ($q) {
                    $q->whereNotNull('tanggal_ganti_oli_terakhir')
                        ->orWhereNotNull('tanggal_service_terakhir');
                })->count(),
            'dokumen_expiring' => DokumenArmada::whereBetween('tanggal_expired', [now(), now()->addDays(30)])->count(),
            'izin_expiring' => DokumenIzin::whereBetween('masa_berlaku', [now(), now()->addDays(30)])->count(),
            'total_revenue_bulan' => Invoice::whereMonth('tanggal_invoice', now()->month)
                ->whereYear('tanggal_invoice', now()->year)->sum('total'),
            'total_cost_bulan' => Cost::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year)->sum('jumlah')
                + PengeluaranArmada::whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year)->sum('jumlah'),
        ];

        $stats['profit_bulan'] = $stats['total_revenue_bulan'] - $stats['total_cost_bulan'];

        $recentJobs = JobOrder::with(['customer', 'armada', 'driver'])
            ->latest()
            ->take(10)
            ->get();

        $recentSuratJalan = SuratJalan::with(['jobOrder.customer', 'armada'])
            ->latest()->take(5)->get();

        $pengeluaranBulanIni = PengeluaranArmada::selectRaw('jenis, sum(jumlah) as total')
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->groupBy('jenis')->get();

        $dokumenAkanExpired = DokumenArmada::with('armada')
            ->whereBetween('tanggal_expired', [now()->subDay(), now()->addDays(30)])
            ->orderBy('tanggal_expired')
            ->take(5)
            ->get();

        $izinAkanExpired = DokumenIzin::with('perijinanable')
            ->whereBetween('masa_berlaku', [now()->subDay(), now()->addDays(30)])
            ->orderBy('masa_berlaku')
            ->take(5)
            ->get();

        $serviceAlerts = Armada::where('status', 'aktif')
            ->where(function ($q) {
                $q->whereDate('tanggal_ganti_oli_terakhir', '<=', now()->subDays(90))
                    ->orWhereDate('tanggal_service_terakhir', '<=', now()->subDays(180));
            })
            ->orderBy('tanggal_ganti_oli_terakhir')
            ->take(5)
            ->get();

        // Chart data: monthly revenue/cost for last 6 months
        $monthlyChart = [];
        for ($i = 5; $i >= 0; $i--) {
            $m = now()->subMonths($i);
            $rev = Invoice::whereMonth('tanggal_invoice', $m->month)
                ->whereYear('tanggal_invoice', $m->year)->sum('total');
            $cst = Cost::whereMonth('tanggal', $m->month)
                ->whereYear('tanggal', $m->year)->sum('jumlah')
                + PengeluaranArmada::whereMonth('tanggal', $m->month)
                    ->whereYear('tanggal', $m->year)->sum('jumlah');
            $monthlyChart[] = [
                'bulan' => $m->format('M Y'),
                'revenue' => $rev,
                'cost' => $cst,
                'profit' => $rev - $cst,
            ];
        }

        // Chart data: job order status distribution
        $statusLabels = ['assigned', 'pickup', 'gate_in', 'customs', 'on_delivery', 'delivered', 'closed'];
        $statusCounts = [];
        foreach ($statusLabels as $s) {
            $statusCounts[$s] = JobOrder::where('status', $s)->count();
        }

        // Chart data: armada kepemilikan distribution
        $milikSendiri = Armada::where('jenis_kepemilikan', 'milik_sendiri')->count();
        $subkonArmada = Armada::where('jenis_kepemilikan', 'subkon_armada')->count();
        $subkonDriver = Armada::where('jenis_kepemilikan', 'subkon_driver')->count();
        $subkonKeduanya = Armada::where('jenis_kepemilikan', 'subkon_keduanya')->count();

        return view('dashboard.index', compact(
            'stats', 'recentJobs', 'recentSuratJalan', 'pengeluaranBulanIni',
            'dokumenAkanExpired', 'izinAkanExpired', 'serviceAlerts',
            'monthlyChart', 'statusCounts',
            'milikSendiri', 'subkonArmada', 'subkonDriver', 'subkonKeduanya'
        ));
    }
}
