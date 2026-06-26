<?php

namespace App\Http\Controllers;

use App\Models\JobOrder;
use App\Models\Customer;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Container;
use App\Models\ShippingLine;
use App\Models\PPJK;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobOrderController extends Controller
{
    public function index()
    {
        $jobOrders = JobOrder::with(['customer', 'armada', 'driver', 'shippingLine'])
            ->latest()->paginate(15);
        return view('operasional.job-order.index', compact('jobOrders'));
    }

    public function create()
    {
        $customers = Customer::where('status', 'aktif')->get();
        $armadas = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status', 'aktif')->get();
        $containers = Container::where('status', 'aktif')->get();
        $shippingLines = ShippingLine::where('status', 'aktif')->get();
        $ppjk = PPJK::where('status', 'aktif')->get();
        return view('operasional.job-order.create', compact(
            'customers', 'armadas', 'drivers', 'containers', 'shippingLines', 'ppjk'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_jo' => 'nullable|unique:job_orders,nomor_jo',
            'customer_id' => 'required|exists:customers,id',
            'consignee_id' => 'nullable|exists:customers,id',
            'shipper_id' => 'nullable|exists:customers,id',
            'notify_party_id' => 'nullable|exists:customers,id',
            'jenis_barang' => 'nullable',
            'berat' => 'nullable|numeric',
            'volume' => 'nullable|numeric',
            'jumlah_container' => 'nullable|integer|min:0',
            'asal' => 'nullable',
            'tujuan' => 'nullable',
            'pelabuhan_asal' => 'nullable',
            'pelabuhan_tujuan' => 'nullable',
            'negara_asal' => 'nullable',
            'negara_tujuan' => 'nullable',
            'eta' => 'nullable|date',
            'etd' => 'nullable|date',
            'incoterms' => 'nullable',
            'hs_code' => 'nullable',
            'armada_id' => 'nullable|exists:armada,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'shipping_line_id' => 'nullable|exists:shipping_lines,id',
            'ppjk_id' => 'nullable|exists:ppjk,id',
            'vessel' => 'nullable',
            'voyage' => 'nullable',
            'catatan' => 'nullable',
            'container_ids' => 'nullable|array',
            'container_ids.*' => 'exists:containers,id',
        ]);

        $validated['nomor_jo'] = $validated['nomor_jo'] ?: 'JO-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        $validated['status'] = 'draft';
        $validated['created_by'] = auth()->id();

        $jobOrder = JobOrder::create($validated);

        if ($request->has('container_ids')) {
            foreach ($request->container_ids as $containerId) {
                $jobOrder->jobOrderContainers()->create(['container_id' => $containerId]);
                Container::where('id', $containerId)->update(['status' => 'dipakai']);
            }
            $jobOrder->update(['jumlah_container' => count($request->container_ids)]);
        }

        return redirect()->route('operasional.job-order.show', $jobOrder)
            ->with('success', 'Job Order berhasil dibuat.');
    }

    public function show(JobOrder $jobOrder)
    {
        $jobOrder->load([
            'customer', 'consignee', 'shipper', 'notifyParty',
            'armada', 'driver', 'shippingLine', 'ppjk',
            'jobOrderContainers.container', 'customs', 'invoices', 'costs',
            'gpsTracking' => fn($q) => $q->latest('waktu')->take(5),
            'rfidEvents' => fn($q) => $q->latest('waktu')->take(5),
        ]);
        return view('operasional.job-order.show', compact('jobOrder'));
    }

    public function edit(JobOrder $jobOrder)
    {
        $customers = Customer::where('status', 'aktif')->get();
        $armada = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status', 'aktif')->get();
        $containers = Container::whereIn('status', ['aktif', 'dipakai'])->get();
        $shippingLines = ShippingLine::where('status', 'aktif')->get();
        $ppjk = PPJK::where('status', 'aktif')->get();
        return view('operasional.job-order.edit', compact(
            'jobOrder', 'customers', 'armada', 'drivers', 'containers', 'shippingLines', 'ppjk'
        ));
    }

    public function update(Request $request, JobOrder $jobOrder)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'consignee_id' => 'nullable|exists:customers,id',
            'shipper_id' => 'nullable|exists:customers,id',
            'notify_party_id' => 'nullable|exists:customers,id',
            'jenis_barang' => 'nullable',
            'berat' => 'nullable|numeric',
            'volume' => 'nullable|numeric',
            'asal' => 'nullable',
            'tujuan' => 'nullable',
            'pelabuhan_asal' => 'nullable',
            'pelabuhan_tujuan' => 'nullable',
            'negara_asal' => 'nullable',
            'negara_tujuan' => 'nullable',
            'eta' => 'nullable|date',
            'etd' => 'nullable|date',
            'incoterms' => 'nullable',
            'hs_code' => 'nullable',
            'armada_id' => 'nullable|exists:armada,id',
            'driver_id' => 'nullable|exists:drivers,id',
            'shipping_line_id' => 'nullable|exists:shipping_lines,id',
            'ppjk_id' => 'nullable|exists:ppjk,id',
            'vessel' => 'nullable',
            'voyage' => 'nullable',
            'status' => 'required',
            'catatan' => 'nullable',
            'container_ids' => 'nullable|array',
            'container_ids.*' => 'exists:containers,id',
        ]);

        $jobOrder->update($validated);

        $containerIds = $request->input('container_ids', []);
        $oldContainerIds = $jobOrder->containers()->pluck('containers.id')->all();
        Container::whereIn('id', array_diff($oldContainerIds, $containerIds))->update(['status' => 'aktif']);
        Container::whereIn('id', array_diff($containerIds, $oldContainerIds))->update(['status' => 'dipakai']);
        $jobOrder->containers()->sync($containerIds);
        $jobOrder->update(['jumlah_container' => count($containerIds)]);

        return redirect()->route('operasional.job-order.show', $jobOrder)
            ->with('success', 'Job Order berhasil diperbarui.');
    }

    public function updateStatus(Request $request, JobOrder $jobOrder)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,assigned,pickup,on_delivery,gate_in,customs,sailing,delivered,closed',
        ]);

        $jobOrder->update($validated);

        return redirect()->back()->with('success', 'Status berhasil diperbarui ke ' . $validated['status']);
    }
}
