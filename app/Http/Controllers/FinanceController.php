<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\JobOrder;
use App\Models\Customer;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['jobOrder.customer', 'customer'])
            ->latest()->paginate(15);
        $totalRevenue = Invoice::where('status', 'paid')->sum('total');
        $totalOutstanding = Invoice::whereIn('status', ['unpaid', 'partial'])->sum('total');
        $totalCost = Cost::where('status', 'approved')->sum('jumlah');
        return view('finance.index', compact('invoices', 'totalRevenue', 'totalOutstanding', 'totalCost'));
    }

    public function createInvoice(JobOrder $jobOrder = null)
    {
        $jobOrders = JobOrder::with('customer')
            ->whereIn('status', ['delivered', 'closed'])
            ->whereDoesntHave('invoices')
            ->get();
        $customers = Customer::where('status', 'aktif')->get();
        return view('finance.invoice.create', compact('jobOrders', 'jobOrder', 'customers'));
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'job_order_id' => 'required|exists:job_orders,id',
            'customer_id' => 'required|exists:customers,id',
            'tanggal_invoice' => 'required|date',
            'tanggal_jatuh_tempo' => 'nullable|date',
            'subtotal' => 'required|numeric',
            'ppn' => 'nullable|numeric',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.deskripsi' => 'required',
            'items.*.tipe' => 'required',
            'items.*.jumlah' => 'required|numeric',
            'items.*.harga_satuan' => 'required|numeric',
            'items.*.total' => 'required|numeric',
        ]);

        $validated['nomor_invoice'] = 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(6));

        $invoice = Invoice::create($validated);

        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('finance.show', $invoice)
            ->with('success', 'Invoice berhasil dibuat.');
    }

    public function showInvoice(Invoice $invoice)
    {
        $invoice->load(['jobOrder.customer', 'customer', 'items', 'payments']);
        return view('finance.invoice.show', compact('invoice'));
    }

    public function jobCosts(JobOrder $jobOrder)
    {
        $costs = $jobOrder->costs()->with('vendor')->get();
        return view('finance.cost.index', compact('jobOrder', 'costs'));
    }

    public function storeCost(Request $request, JobOrder $jobOrder)
    {
        $validated = $request->validate([
            'vendor_id' => 'nullable|exists:vendors,id',
            'tipe' => 'required',
            'deskripsi' => 'nullable',
            'jumlah' => 'required|numeric',
            'tanggal' => 'nullable|date',
        ]);

        $validated['job_order_id'] = $jobOrder->id;
        Cost::create($validated);

        return redirect()->back()->with('success', 'Biaya berhasil dicatat.');
    }

    public function profitAnalysis(Request $request)
    {
        $customers = Customer::where('status', 'aktif')->orderBy('nama')->get();

        $query = JobOrder::with('customer')
            ->whereIn('status', ['delivered', 'closed'])
            ->withSum('invoices as total_revenue', 'total')
            ->withSum('costs as total_cost', 'jumlah');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        $profits = $query->latest()
            ->paginate(15)
            ->withQueryString();

        $profits->getCollection()->transform(function ($job) {
            $revenue = $job->total_revenue ?? 0;
            $cost = $job->total_cost ?? 0;
            $profit = $revenue - $cost;

            return [
                'nomor_jo' => $job->nomor_jo,
                'customer' => $job->customer?->nama ?? '-',
                'revenue' => $revenue,
                'cost' => $cost,
                'profit' => $profit,
                'margin' => $revenue > 0 ? round(($profit / $revenue) * 100, 2) : 0,
            ];
        });

        return view('finance.profit', compact('customers', 'profits'));
    }

    public function payment(Invoice $invoice)
    {
        return view('finance.payment.create', compact('invoice'));
    }

    public function storePayment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|max:' . ($invoice->total - $invoice->payments->sum('jumlah')),
            'tanggal_pembayaran' => 'required|date',
            'metode' => 'required',
            'referensi' => 'nullable',
            'catatan' => 'nullable',
        ]);

        $invoice->payments()->create($validated);

        $totalPaid = $invoice->payments->sum('jumlah') + $validated['jumlah'];
        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'paid', 'tanggal_pembayaran' => $validated['tanggal_pembayaran']]);
        } else {
            $invoice->update(['status' => 'partial']);
        }

        return redirect()->route('finance.show', $invoice)
            ->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function exportData(Request $request)
    {
        $query = JobOrder::with(['customer', 'invoices', 'costs'])
            ->whereIn('status', ['delivered', 'closed']);

        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->customer_id) {
            $query->where('customer_id', $request->customer_id);
        }

        $jobs = $query->get()->map(function ($job) {
            return [
                'Nomor JO' => $job->nomor_jo,
                'Customer' => $job->customer?->nama,
                'Status' => $job->status,
                'Total Revenue' => $job->invoices->sum('total'),
                'Total Cost' => $job->costs->sum('jumlah'),
                'Profit' => $job->invoices->sum('total') - $job->costs->sum('jumlah'),
                'Created At' => $job->created_at->format('Y-m-d'),
            ];
        });

        return view('finance.export', compact('jobs'));
    }
}
