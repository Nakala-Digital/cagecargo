<?php

namespace App\Http\Controllers;

use App\Models\ShippingLine;
use Illuminate\Http\Request;

class ShippingLineController extends Controller
{
    public function index()
    {
        $shippingLines = ShippingLine::latest()->paginate(10);
        return view('master.shipping-line.index', compact('shippingLines'));
    }

    public function create()
    {
        return view('master.shipping-line.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:shipping_lines',
            'nama' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
        ]);

        ShippingLine::create($validated);

        return redirect()->route('master.shipping-line.index')
            ->with('success', 'Shipping Line berhasil ditambahkan.');
    }

    public function show(ShippingLine $shippingLine)
    {
        return view('master.shipping-line.show', compact('shippingLine'));
    }

    public function edit(ShippingLine $shippingLine)
    {
        return view('master.shipping-line.edit', compact('shippingLine'));
    }

    public function update(Request $request, ShippingLine $shippingLine)
    {
        $validated = $request->validate([
            'code' => 'required|unique:shipping_lines,code,' . $shippingLine->id,
            'nama' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required',
        ]);

        $shippingLine->update($validated);

        return redirect()->route('master.shipping-line.index')
            ->with('success', 'Shipping Line berhasil diperbarui.');
    }

    public function destroy(ShippingLine $shippingLine)
    {
        $shippingLine->update(['status' => 'nonaktif']);
        return redirect()->route('master.shipping-line.index')
            ->with('success', 'Shipping Line dinonaktifkan.');
    }
}
