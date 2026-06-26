@extends('layouts.app')
@section('title', 'Edit Job Order')
@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-navy">Edit Job Order</h2>
        <p class="text-gray-500">{{ $jobOrder->nomor_jo }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="POST" action="{{ route('operasional.job-order.update', $jobOrder) }}">
            @csrf @method('PUT')
            <div class="grid grid-cols-3 gap-4">
                <div class="col-span-3 mb-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Job Order</h3>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor JO *</label>
                    <input type="text" name="nomor_jo" value="{{ old('nomor_jo', $jobOrder->nomor_jo) }}" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal @error('nomor_jo') border-red-500 @enderror">
                    @error('nomor_jo') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Customer *</label>
                    <select name="customer_id" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Customer</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('customer_id', $jobOrder->customer_id) == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Consignee</label>
                    <select name="consignee_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Consignee</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('consignee_id', $jobOrder->consignee_id) == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipper</label>
                    <select name="shipper_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Shipper</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('shipper_id', $jobOrder->shipper_id) == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notify Party</label>
                    <select name="notify_party_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Notify Party</option>
                        @foreach($customers as $c)
                        <option value="{{ $c->id }}" {{ old('notify_party_id', $jobOrder->notify_party_id) == $c->id ? 'selected' : '' }}>{{ $c->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-3 mb-4 mt-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Detail Barang & Rute</h3>
                </div>
                <div class="col-span-3 mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Barang</label>
                    <input type="text" name="jenis_barang" value="{{ old('jenis_barang', $jobOrder->jenis_barang) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Berat (kg)</label>
                    <input type="number" name="berat" value="{{ old('berat', $jobOrder->berat) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Volume (m3)</label>
                    <input type="number" step="0.01" name="volume" value="{{ old('volume', $jobOrder->volume) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Container</label>
                    <input type="number" name="jumlah_container" value="{{ old('jumlah_container', $jobOrder->jumlah_container) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                </div>
                <div class="col-span-3 grid grid-cols-3 gap-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Asal</label>
                        <input type="text" name="asal" value="{{ old('asal', $jobOrder->asal) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tujuan</label>
                        <input type="text" name="tujuan" value="{{ old('tujuan', $jobOrder->tujuan) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">HS Code</label>
                        <input type="text" name="hs_code" value="{{ old('hs_code', $jobOrder->hs_code) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pelabuhan Asal</label>
                        <input type="text" name="pelabuhan_asal" value="{{ old('pelabuhan_asal', $jobOrder->pelabuhan_asal) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pelabuhan Tujuan</label>
                        <input type="text" name="pelabuhan_tujuan" value="{{ old('pelabuhan_tujuan', $jobOrder->pelabuhan_tujuan) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Incoterms</label>
                        <input type="text" name="incoterms" value="{{ old('incoterms', $jobOrder->incoterms) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Negara Asal</label>
                        <input type="text" name="negara_asal" value="{{ old('negara_asal', $jobOrder->negara_asal) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Negara Tujuan</label>
                        <input type="text" name="negara_tujuan" value="{{ old('negara_tujuan', $jobOrder->negara_tujuan) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Vessel / Voyage</label>
                        <div class="flex space-x-2">
                            <input type="text" name="vessel" value="{{ old('vessel', $jobOrder->vessel) }}" placeholder="Vessel" class="w-1/2 px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                            <input type="text" name="voyage" value="{{ old('voyage', $jobOrder->voyage) }}" placeholder="Voyage" class="w-1/2 px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ETD</label>
                        <input type="date" name="etd" value="{{ old('etd', $jobOrder->etd?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ETA</label>
                        <input type="date" name="eta" value="{{ old('eta', $jobOrder->eta?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                    </div>
                </div>

                <div class="col-span-3 mb-4 mt-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Alokasi Armada & Driver</h3>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Shipping Line</label>
                    <select name="shipping_line_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Shipping Line</option>
                        @foreach($shippingLines as $sl)
                        <option value="{{ $sl->id }}" {{ old('shipping_line_id', $jobOrder->shipping_line_id) == $sl->id ? 'selected' : '' }}>{{ $sl->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">PPJK</label>
                    <select name="ppjk_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih PPJK</option>
                        @foreach($ppjk as $p)
                        <option value="{{ $p->id }}" {{ old('ppjk_id', $jobOrder->ppjk_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Armada</label>
                    <select name="armada_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Armada</option>
                        @foreach($armadas as $a)
                        <option value="{{ $a->id }}" {{ old('armada_id', $jobOrder->armada_id) == $a->id ? 'selected' : '' }}>{{ $a->nomor_polisi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                    <select name="driver_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="">Pilih Driver</option>
                        @foreach($drivers as $d)
                        <option value="{{ $d->id }}" {{ old('driver_id', $jobOrder->driver_id) == $d->id ? 'selected' : '' }}>{{ $d->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-3 mb-4 mt-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Container</h3>
                </div>
                <div class="col-span-3 mb-4">
                    <div class="border rounded-lg p-4 max-h-48 overflow-y-auto">
                        @forelse($containers as $container)
                        <label class="flex items-center space-x-3 py-1.5 hover:bg-gray-50 px-2 rounded">
                            <input type="checkbox" name="container_ids[]" value="{{ $container->id }}"
                                {{ in_array($container->id, old('container_ids', $jobOrder->containers->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="text-teal focus:ring-teal rounded">
                            <span class="text-sm">{{ $container->nomor_container }} - {{ $container->size }} ({{ $container->shippingLine?->nama ?? '-' }})</span>
                        </label>
                        @empty
                        <p class="text-sm text-gray-500">Tidak ada container tersedia</p>
                        @endforelse
                    </div>
                </div>

                <div class="col-span-3 mb-4 mt-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Status</h3>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">
                        <option value="draft" {{ $jobOrder->status == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="assigned" {{ $jobOrder->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                        <option value="pickup" {{ $jobOrder->status == 'pickup' ? 'selected' : '' }}>Pickup</option>
                        <option value="on_delivery" {{ $jobOrder->status == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                        <option value="gate_in" {{ $jobOrder->status == 'gate_in' ? 'selected' : '' }}>Gate In</option>
                        <option value="customs" {{ $jobOrder->status == 'customs' ? 'selected' : '' }}>Customs</option>
                        <option value="sailing" {{ $jobOrder->status == 'sailing' ? 'selected' : '' }}>Sailing</option>
                        <option value="delivered" {{ $jobOrder->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="closed" {{ $jobOrder->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="col-span-3 mb-4 mt-4">
                    <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Catatan</h3>
                </div>
                <div class="col-span-3 mb-4">
                    <textarea name="catatan" rows="3" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-teal focus:border-teal">{{ old('catatan', $jobOrder->catatan) }}</textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <a href="{{ route('operasional.job-order.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-teal text-white rounded-lg hover:bg-teal-600">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection
