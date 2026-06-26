<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vendor;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::with('vendor')->latest()->paginate(10);
        return view('master.driver.index', compact('drivers'));
    }

    public function create()
    {
        $vendors = Vendor::where('status', 'aktif')->get();
        return view('master.driver.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|unique:drivers',
            'nama' => 'required',
            'nomor_sim' => 'nullable',
            'masa_berlaku_sim' => 'nullable|date',
            'nomor_hp' => 'nullable',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'vendor_id' => 'nullable|exists:vendors,id',
        ]);

        Driver::create($validated);

        return redirect()->route('master.driver.index')
            ->with('success', 'Driver berhasil ditambahkan.');
    }

    public function show(Driver $driver)
    {
        $driver->load('vendor');
        return view('master.driver.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        $vendors = Vendor::where('status', 'aktif')->get();
        return view('master.driver.edit', compact('driver', 'vendors'));
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'nik' => 'nullable|unique:drivers,nik,' . $driver->id,
            'nama' => 'required',
            'nomor_sim' => 'nullable',
            'masa_berlaku_sim' => 'nullable|date',
            'nomor_hp' => 'nullable',
            'email' => 'nullable|email',
            'alamat' => 'nullable',
            'vendor_id' => 'nullable|exists:vendors,id',
            'status' => 'required',
        ]);

        $driver->update($validated);

        return redirect()->route('master.driver.index')
            ->with('success', 'Driver berhasil diperbarui.');
    }

    public function destroy(Driver $driver)
    {
        $driver->update(['status' => 'nonaktif']);
        return redirect()->route('master.driver.index')
            ->with('success', 'Driver dinonaktifkan.');
    }
}
