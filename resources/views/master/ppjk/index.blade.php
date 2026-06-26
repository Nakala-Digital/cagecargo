@extends('layouts.app')
@section('title', 'Master PPJK')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Master PPJK</h2>
            <p class="text-gray-500">Kelola data Pengusaha Pengurusan Jasa Kepabeanan</p>
        </div>
        <a href="{{ route('master.ppjk.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah PPJK</a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Kode</th>
                    <th class="px-6 py-3">Nama Perusahaan</th>
                    <th class="px-6 py-3">PIC</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Phone</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($ppjk as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $p->code }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->nama_perusahaan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->pic ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $p->phone ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $p->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $p->status }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('master.ppjk.show', $p) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('master.ppjk.edit', $p) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">Belum ada data PPJK</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $ppjk->links() }}</div>
</div>
@endsection
