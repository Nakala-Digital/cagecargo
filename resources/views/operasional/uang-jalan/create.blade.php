@extends('layouts.app')
@section('title', 'Uang Jalan Baru')
@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Uang Jalan Baru</h2>
            <p class="text-gray-500">Catat pencairan dana perjalanan driver</p>
        </div>
        <a href="{{ route('operasional.uang-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('operasional.uang-jalan.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Surat Jalan</label>
                    <select name="surat_jalan_id" id="sjSelect" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Surat Jalan --</option>
                        @foreach($suratJalan as $sj)
                        <option value="{{ $sj->id }}" data-armada="{{ $sj->armada_id }}" data-driver="{{ $sj->driver_id }}">{{ $sj->nomor_surat_jalan }} - {{ $sj->jobOrder?->customer?->nama ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Armada</label>
                    <select name="armada_id" id="armadaSelect" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Armada --</option>
                        @foreach($armada as $a)
                        <option value="{{ $a->id }}">{{ $a->nomor_polisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">-- Pilih Driver --</option>
                        @foreach($drivers as $d)
                        <option value="{{ $d->id }}">{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                </div>

                <div class="border-t pt-4">
                    <h4 class="text-sm font-semibold text-navy mb-3">Rincian Biaya</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Solar</label>
                            <input type="number" name="solar" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tol</label>
                            <input type="number" name="tol" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Parkir</label>
                            <input type="number" name="parkir" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Makan Driver</label>
                            <input type="number" name="makan_driver" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Preman / Akamsi</label>
                            <input type="number" name="preman" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Komisi Driver</label>
                            <input type="number" name="komisi_driver" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Lainnya</label>
                            <input type="number" name="lainnya" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" value="0" oninput="hitungTotal()">
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg flex items-center justify-between">
                            <span class="text-sm font-semibold text-navy">TOTAL</span>
                            <span class="text-lg font-bold text-teal" id="totalDisplay">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti (foto/scan)</label>
                    <input type="file" name="bukti" accept="image/*,application/pdf" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    <p class="text-xs text-gray-400 mt-1">Maks 5 MB. Format: JPG, PNG, PDF</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('operasional.uang-jalan.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg text-sm hover:bg-teal-600">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('sjSelect')?.addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    if (opt && opt.dataset.armada) {
        document.getElementById('armadaSelect').value = opt.dataset.armada;
    }
    if (opt && opt.dataset.driver) {
        const driverSelect = document.querySelector('select[name="driver_id"]');
        Array.from(driverSelect.options).forEach(o => {
            if (o.value === opt.dataset.driver) o.selected = true;
        });
    }
});
function hitungTotal() {
    const fields = ['solar', 'tol', 'parkir', 'makan_driver', 'preman', 'komisi_driver', 'lainnya'];
    let total = 0;
    fields.forEach(f => {
        const el = document.querySelector(`input[name="${f}"]`);
        if (el) total += parseFloat(el.value) || 0;
    });
    document.getElementById('totalDisplay').textContent = 'Rp ' + total.toLocaleString('id-ID');
}
</script>
@endsection