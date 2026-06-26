@extends('layouts.app')
@section('title', 'Jenis Armada')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Jenis Armada</h2>
            <p class="text-gray-500">Kelola tipe kendaraan & harga sewa</p>
        </div>
        <button onclick="document.getElementById('modalJenis').classList.remove('hidden')" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Tambah Jenis</button>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Tipe Kendaraan</th>
                    <th class="px-6 py-3">Harga Sewa</th>
                    <th class="px-6 py-3">Satuan</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jenis as $j)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium">{{ $j->nama }}</td>
                    <td class="px-6 py-4 text-sm capitalize">{{ $j->tipe_kendaraan }}</td>
                    <td class="px-6 py-4 text-sm">{{ $j->harga_sewa ? 'Rp ' . number_format($j->harga_sewa, 0, ',', '.') : '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $j->satuan }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $j->status == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $j->status ?? 'aktif' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <button onclick="editJenis({{ $j->id }}, '{{ $j->nama }}', '{{ $j->tipe_kendaraan }}', '{{ $j->harga_sewa }}', '{{ $j->satuan }}', '{{ $j->status }}', '{{ addslashes($j->keterangan) }}')" class="text-teal hover:text-teal-600">Edit</button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data jenis armada</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $jenis->links() }}</div>
</div>

<div id="modalJenis" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-lg p-6 w-full max-w-lg mx-4">
        <h3 class="text-lg font-semibold text-navy mb-4" id="modalTitle">Tambah Jenis Armada</h3>
        <form id="formJenis" method="POST" action="{{ route('master.armada.jenis.store') }}">
            @csrf
            <input type="hidden" name="_method" id="methodJenis" value="POST">
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="nama" id="field_nama" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Kendaraan</label>
                    <select name="tipe_kendaraan" id="field_tipe" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="tronton">Tronton</option>
                        <option value="fuso">Fuso</option>
                        <option value="wingbox">Wingbox</option>
                        <option value="container_trailer">Container Trailer</option>
                        <option value="pickup">Pickup</option>
                        <option value="dump_truck">Dump Truck</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa</label>
                    <input type="number" name="harga_sewa" id="field_harga" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <select name="satuan" id="field_satuan" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="per_trip">Per Trip</option>
                        <option value="per_hari">Per Hari</option>
                        <option value="per_bulan">Per Bulan</option>
                        <option value="per_ton">Per Ton</option>
                        <option value="per_container">Per Container</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" id="field_keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal"></textarea>
                </div>
                <div id="statusField" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="field_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('modalJenis').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function editJenis(id, nama, tipe, harga, satuan, status, keterangan) {
    document.getElementById('modalTitle').textContent = 'Edit Jenis Armada';
    document.getElementById('methodJenis').value = 'PUT';
    document.getElementById('formJenis').action = '{{ url("master/jenis-armada") }}/' + id;
    document.getElementById('field_nama').value = nama;
    document.getElementById('field_tipe').value = tipe;
    document.getElementById('field_harga').value = harga;
    document.getElementById('field_satuan').value = satuan;
    document.getElementById('field_keterangan').value = keterangan;
    document.getElementById('field_status').value = status || 'aktif';
    document.getElementById('statusField').classList.remove('hidden');
    document.getElementById('modalJenis').classList.remove('hidden');
}
document.getElementById('modalJenis').addEventListener('click', function(e) {
    if (e.target === this) this.classList.add('hidden');
});
</script>
@endsection