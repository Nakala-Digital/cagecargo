<?php

namespace App\Http\Controllers;

use App\Models\Customs;
use App\Models\JobOrder;
use App\Models\PPJK;
use Illuminate\Http\Request;

class CustomsController extends Controller
{
    public function index()
    {
        $customsList = Customs::with(['jobOrder.customer', 'ppjk'])->latest()->paginate(15);
        return view('operasional.customs.index', compact('customsList'));
    }

    public function create(JobOrder $jobOrder = null)
    {
        $jobOrders = JobOrder::where('status', 'customs')
            ->orWhere(function ($q) {
                $q->whereDoesntHave('customs');
            })
            ->with('customer')
            ->get();
        $ppjk = PPJK::where('status', 'aktif')->get();
        return view('operasional.customs.create', compact('jobOrders', 'jobOrder', 'ppjk'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_order_id' => 'required|exists:job_orders,id|unique:customs,job_order_id',
            'jenis' => 'required|in:impor,ekspor',
            'nomor_pib_peb' => 'nullable',
            'tanggal_pengajuan' => 'nullable|date',
            'jalur' => 'nullable|in:hijau,kuning,merah',
            'ppjk_id' => 'nullable|exists:ppjk,id',
            'nomor_bill_of_lading' => 'nullable',
            'nomor_manifest' => 'nullable',
            'nomor_invoice' => 'nullable',
            'nomor_packing_list' => 'nullable',
            'nomor_certificate_of_origin' => 'nullable',
            'nomor_shipping_instruction' => 'nullable',
        ]);

        Customs::create($validated);
        JobOrder::where('id', $validated['job_order_id'])->update(['status' => 'customs']);

        return redirect()->route('operasional.customs.index')
            ->with('success', 'Data customs berhasil ditambahkan.');
    }

    public function show(Customs $customs)
    {
        $customs->load(['jobOrder.customer', 'jobOrder.containers', 'ppjk']);
        return view('operasional.customs.show', compact('customs'));
    }

    public function edit(Customs $customs)
    {
        $jobOrders = JobOrder::with('customer')->get();
        $ppjk = PPJK::where('status', 'aktif')->get();
        return view('operasional.customs.edit', compact('customs', 'jobOrders', 'ppjk'));
    }

    public function update(Request $request, Customs $customs)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:impor,ekspor',
            'nomor_pib_peb' => 'nullable',
            'tanggal_pengajuan' => 'nullable|date',
            'jalur' => 'nullable|in:hijau,kuning,merah',
            'status' => 'required|in:waiting_clearance,under_inspection,released',
            'tanggal_release' => 'nullable|date',
            'bea_masuk' => 'nullable|numeric',
            'pajak' => 'nullable|numeric',
            'denda' => 'nullable|numeric',
            'nomor_bill_of_lading' => 'nullable',
            'nomor_manifest' => 'nullable',
            'nomor_invoice' => 'nullable',
            'nomor_packing_list' => 'nullable',
            'nomor_certificate_of_origin' => 'nullable',
            'nomor_shipping_instruction' => 'nullable',
            'nomor_npe' => 'nullable',
            'ppjk_id' => 'nullable|exists:ppjk,id',
            'catatan' => 'nullable',
        ]);

        $customs->update($validated);

        if ($validated['status'] === 'released') {
            JobOrder::where('id', $customs->job_order_id)->update(['status' => 'sailing']);
        }

        return redirect()->route('operasional.customs.show', $customs)
            ->with('success', 'Data customs berhasil diperbarui.');
    }
}
