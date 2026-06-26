@extends('layouts.app')
@section('title', 'Edit Armada')
@section('content')
<div class="max-w-2xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Edit Armada</h2>
        <p class="text-gray-500">{{ $armada->nomor_polisi }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('master.armada.update', $armada) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Polisi *</label>
                    <input type="text" name="nomor_polisi" value="{{ old('nomor_polisi', $armada->nomor_polisi) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('nomor_polisi') border-red-500 @enderror">
                    @error('nomor_polisi') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kendaraan *</label>
                    <select name="jenis_kendaraan" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        @foreach(['truck_wingbox','truck_fuso','truck_tronton','truck_trailer','pickup','container_chassis','lainnya'] as $jk)
                        <option value="{{ $jk }}" {{ old('jenis_kendaraan', $armada->jenis_kendaraan) == $jk ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $jk)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Merk</label>
                    <input type="text" name="merk" value="{{ old('merk', $armada->merk) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="tahun" value="{{ old('tahun', $armada->tahun) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Mesin</label>
                    <input type="text" name="nomor_mesin" value="{{ old('nomor_mesin', $armada->nomor_mesin) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Rangka</label>
                    <input type="text" name="nomor_rangka" value="{{ old('nomor_rangka', $armada->nomor_rangka) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (kg)</label>
                    <input type="number" name="kapasitas" value="{{ old('kapasitas', $armada->kapasitas) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vendor</label>
                    <select name="vendor_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Vendor</option>
                        @foreach($vendors as $v)
                        <option value="{{ $v->id }}" {{ old('vendor_id', $armada->vendor_id) == $v->id ? 'selected' : '' }}>{{ $v->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">GPS Device ID</label>
                    <input type="text" name="gps_device_id" value="{{ old('gps_device_id', $armada->gps_device_id) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">RFID Tag</label>
                    <input type="text" name="rfid_tag" value="{{ old('rfid_tag', $armada->rfid_tag) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Armada</label>
                    <select name="jenis_armada_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Jenis Armada</option>
                        @foreach(\App\Models\JenisArmada::where('status','aktif')->get() as $ja)
                        <option value="{{ $ja->id }}" {{ old('jenis_armada_id', $armada->jenis_armada_id) == $ja->id ? 'selected' : '' }}>{{ $ja->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kepemilikan</label>
                    <select name="jenis_kepemilikan" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Kepemilikan</option>
                        <option value="milik_sendiri" {{ old('jenis_kepemilikan', $armada->jenis_kepemilikan) == 'milik_sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                        <option value="subkon_armada" {{ old('jenis_kepemilikan', $armada->jenis_kepemilikan) == 'subkon_armada' ? 'selected' : '' }}>Subkon Armada</option>
                        <option value="subkon_driver" {{ old('jenis_kepemilikan', $armada->jenis_kepemilikan) == 'subkon_driver' ? 'selected' : '' }}>Subkon Driver</option>
                        <option value="subkon_keduanya" {{ old('jenis_kepemilikan', $armada->jenis_kepemilikan) == 'subkon_keduanya' ? 'selected' : '' }}>Subkon Keduanya</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kontrak Subkon</label>
                    <select name="kontrak_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Kontrak</option>
                        @foreach(\App\Models\KontrakSubkon::where('status','aktif')->get() as $k)
                        <option value="{{ $k->id }}" {{ old('kontrak_id', $armada->kontrak_id) == $k->id ? 'selected' : '' }}>{{ $k->nomor_kontrak }} - {{ $k->vendor?->nama ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Sewa</label>
                    <input type="number" name="harga_sewa" value="{{ old('harga_sewa', $armada->harga_sewa) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Ganti Oli Terakhir</label>
                    <input type="date" name="tanggal_ganti_oli_terakhir" value="{{ old('tanggal_ganti_oli_terakhir', $armada->tanggal_ganti_oli_terakhir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Tempuh Ganti Oli (km)</label>
                    <input type="number" name="jarak_tempuh_ganti_oli" value="{{ old('jarak_tempuh_ganti_oli', $armada->jarak_tempuh_ganti_oli) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Service Terakhir</label>
                    <input type="date" name="tanggal_service_terakhir" value="{{ old('tanggal_service_terakhir', $armada->tanggal_service_terakhir?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jarak Tempuh Service (km)</label>
                    <input type="number" name="jarak_tempuh_service" value="{{ old('jarak_tempuh_service', $armada->jarak_tempuh_service) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="aktif" {{ old('status', $armada->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $armada->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('master.armada.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
