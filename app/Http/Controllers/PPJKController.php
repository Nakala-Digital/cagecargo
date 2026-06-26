<?php

namespace App\Http\Controllers;

use App\Models\PPJK;
use Illuminate\Http\Request;

class PPJKController extends Controller
{
    public function index()
    {
        $ppjk = PPJK::latest()->paginate(10);
        return view('master.ppjk.index', compact('ppjk'));
    }

    public function create()
    {
        return view('master.ppjk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:ppjk',
            'nama_perusahaan' => 'required',
            'nomor_izin' => 'nullable',
            'pic' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'masa_berlaku_izin' => 'nullable|date',
            'jenis_layanan' => 'nullable',
        ]);

        PPJK::create($validated);

        return redirect()->route('master.ppjk.index')
            ->with('success', 'PPJK berhasil ditambahkan.');
    }

    public function show(PPJK $pPJK)
    {
        return view('master.ppjk.show', compact('pPJK'));
    }

    public function edit(PPJK $pPJK)
    {
        return view('master.ppjk.edit', compact('pPJK'));
    }

    public function update(Request $request, PPJK $pPJK)
    {
        $validated = $request->validate([
            'code' => 'required|unique:ppjk,code,' . $pPJK->id,
            'nama_perusahaan' => 'required',
            'nomor_izin' => 'nullable',
            'pic' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'alamat' => 'nullable',
            'masa_berlaku_izin' => 'nullable|date',
            'jenis_layanan' => 'nullable',
            'status' => 'required',
        ]);

        $pPJK->update($validated);

        return redirect()->route('master.ppjk.index')
            ->with('success', 'PPJK berhasil diperbarui.');
    }

    public function destroy(PPJK $pPJK)
    {
        $pPJK->update(['status' => 'nonaktif']);
        return redirect()->route('master.ppjk.index')
            ->with('success', 'PPJK dinonaktifkan.');
    }
}
