<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
        return view('master.vendor.index', compact('vendors'));
    }

    public function create()
    {
        return view('master.vendor.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:vendors',
            'nama' => 'required',
            'tipe' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'npwp' => 'nullable',
            'pic_name' => 'nullable',
            'pic_phone' => 'nullable',
        ]);

        Vendor::create($validated);

        return redirect()->route('master.vendor.index')
            ->with('success', 'Vendor berhasil ditambahkan.');
    }

    public function show(Vendor $vendor)
    {
        return view('master.vendor.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('master.vendor.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validated = $request->validate([
            'code' => 'required|unique:vendors,code,' . $vendor->id,
            'nama' => 'required',
            'tipe' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'npwp' => 'nullable',
            'pic_name' => 'nullable',
            'pic_phone' => 'nullable',
            'status' => 'required',
        ]);

        $vendor->update($validated);

        return redirect()->route('master.vendor.index')
            ->with('success', 'Vendor berhasil diperbarui.');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->update(['status' => 'nonaktif']);
        return redirect()->route('master.vendor.index')
            ->with('success', 'Vendor dinonaktifkan.');
    }
}
