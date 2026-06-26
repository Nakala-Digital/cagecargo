<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\ShippingLine;
use Illuminate\Http\Request;

class ContainerController extends Controller
{
    public function index()
    {
        $containers = Container::with('shippingLine')->latest()->paginate(10);
        return view('master.container.index', compact('containers'));
    }

    public function create()
    {
        $shippingLines = ShippingLine::where('status', 'aktif')->get();
        return view('master.container.create', compact('shippingLines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_container' => 'required|unique:containers',
            'size' => 'required',
            'type' => 'required',
            'shipping_line_id' => 'nullable|exists:shipping_lines,id',
            'seal_number' => 'nullable',
            'lokasi' => 'nullable',
            'max_weight' => 'nullable|numeric',
            'tare_weight' => 'nullable|numeric',
        ]);

        Container::create($validated);

        return redirect()->route('master.container.index')
            ->with('success', 'Container berhasil ditambahkan.');
    }

    public function show(Container $container)
    {
        $container->load('shippingLine');
        return view('master.container.show', compact('container'));
    }

    public function edit(Container $container)
    {
        $shippingLines = ShippingLine::where('status', 'aktif')->get();
        return view('master.container.edit', compact('container', 'shippingLines'));
    }

    public function update(Request $request, Container $container)
    {
        $validated = $request->validate([
            'nomor_container' => 'required|unique:containers,nomor_container,' . $container->id,
            'size' => 'required',
            'type' => 'required',
            'shipping_line_id' => 'nullable|exists:shipping_lines,id',
            'seal_number' => 'nullable',
            'lokasi' => 'nullable',
            'max_weight' => 'nullable|numeric',
            'tare_weight' => 'nullable|numeric',
            'status' => 'required',
        ]);

        $container->update($validated);

        return redirect()->route('master.container.index')
            ->with('success', 'Container berhasil diperbarui.');
    }

    public function destroy(Container $container)
    {
        $container->update(['status' => 'nonaktif']);
        return redirect()->route('master.container.index')
            ->with('success', 'Container dinonaktifkan.');
    }
}
