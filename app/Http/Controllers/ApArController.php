<?php

namespace App\Http\Controllers;

use App\Models\ApArmada;
use App\Models\ArArmada;
use App\Models\Vendor;
use App\Models\Customer;
use App\Models\JobOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApArController extends Controller
{
    public function apIndex()
    {
        $ap = ApArmada::with(['vendor', 'jobOrder'])->latest()->paginate(15);
        $totalUnpaid = ApArmada::where('status', 'unpaid')->sum('jumlah');
        $totalOverdue = ApArmada::where('status', 'overdue')->sum('jumlah');
        return view('finance.ap.index', compact('ap', 'totalUnpaid', 'totalOverdue'));
    }

    public function apCreate()
    {
        $vendors = Vendor::where('status', 'aktif')->get();
        $jobOrders = JobOrder::with('customer')->latest()->get();
        return view('finance.ap.create', compact('vendors', 'jobOrders'));
    }

    public function apStore(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'job_order_id' => 'nullable|exists:job_orders,id',
            'tipe' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'nullable',
        ]);

        $validated['nomor_ap'] = 'AP-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        ApArmada::create($validated);

        return redirect()->route('finance.ap.index')->with('success', 'AP berhasil dicatat.');
    }

    public function apPay(ApArmada $ap)
    {
        $ap->update([
            'status' => 'paid',
            'tanggal_bayar' => now(),
        ]);
        return redirect()->back()->with('success', 'AP dibayar.');
    }

    public function arIndex()
    {
        $ar = ArArmada::with(['customer', 'jobOrder'])->latest()->paginate(15);
        $totalUnpaid = ArArmada::where('status', 'unpaid')->sum('jumlah');
        $totalOverdue = ArArmada::where('status', 'overdue')->sum('jumlah');
        return view('finance.ar.index', compact('ar', 'totalUnpaid', 'totalOverdue'));
    }

    public function arCreate()
    {
        $customers = Customer::where('status', 'aktif')->get();
        $jobOrders = JobOrder::with('customer')
            ->whereIn('status', ['assigned', 'pickup', 'on_delivery', 'gate_in', 'customs', 'sailing', 'delivered', 'closed'])
            ->latest()
            ->get();
        return view('finance.ar.create', compact('customers', 'jobOrders'));
    }

    public function arStore(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'job_order_id' => 'required|exists:job_orders,id',
            'tipe' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'jatuh_tempo' => 'nullable|date',
            'keterangan' => 'nullable',
        ]);

        $validated['nomor_ar'] = 'AR-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        ArArmada::create($validated);

        return redirect()->route('finance.ar.index')->with('success', 'AR berhasil dicatat.');
    }

    public function arPay(ArArmada $ar)
    {
        $ar->update([
            'status' => 'paid',
            'tanggal_bayar' => now(),
        ]);
        return redirect()->back()->with('success', 'AR diterima.');
    }
}
