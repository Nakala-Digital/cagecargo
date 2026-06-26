<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->paginate(10);
        return view('master.customer.index', compact('customers'));
    }

    public function create()
    {
        return view('master.customer.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:customers',
            'nama' => 'required',
            'tipe' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'npwp' => 'nullable',
            'pic_name' => 'nullable',
            'pic_phone' => 'nullable',
        ]);

        Customer::create($validated);

        return redirect()->route('master.customer.index')
            ->with('success', 'Customer berhasil ditambahkan.');
    }

    public function show(Customer $customer)
    {
        return view('master.customer.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('master.customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'code' => 'required|unique:customers,code,' . $customer->id,
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

        $customer->update($validated);

        return redirect()->route('master.customer.index')
            ->with('success', 'Customer berhasil diperbarui.');
    }

    public function destroy(Customer $customer)
    {
        $customer->update(['status' => 'nonaktif']);
        return redirect()->route('master.customer.index')
            ->with('success', 'Customer dinonaktifkan.');
    }
}
