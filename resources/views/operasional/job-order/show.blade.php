@extends('layouts.app')
@section('title', 'Detail Job Order')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Detail Job Order</h2>
            <p class="text-gray-500">{{ $jobOrder->nomor_jo }}</p>
        </div>
        <div class="space-x-2">
            <form method="POST" action="{{ route('operasional.job-order.dummy-gps-rfid', $jobOrder) }}" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600">Dummy GPS/RFID</button>
            </form>
            <a href="{{ route('operasional.job-order.edit', $jobOrder) }}" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700">Edit</a>
            <a href="{{ route('finance.invoice.create', $jobOrder) }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600">Buat Invoice</a>
            <a href="{{ route('operasional.job-order.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Job Order</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Nomor JO</dt><dd class="text-sm font-medium">{{ $jobOrder->nomor_jo }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd>
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($jobOrder->status == 'draft') bg-gray-100 text-gray-700
                            @elseif($jobOrder->status == 'assigned') bg-blue-100 text-blue-700
                            @elseif($jobOrder->status == 'pickup') bg-yellow-100 text-yellow-700
                            @elseif($jobOrder->status == 'on_delivery') bg-orange-100 text-orange-700
                            @elseif($jobOrder->status == 'gate_in') bg-indigo-100 text-indigo-700
                            @elseif($jobOrder->status == 'customs') bg-purple-100 text-purple-700
                            @elseif($jobOrder->status == 'sailing') bg-teal-100 text-teal-700
                            @elseif($jobOrder->status == 'delivered') bg-green-100 text-green-700
                            @elseif($jobOrder->status == 'closed') bg-gray-800 text-white
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $jobOrder->status)) }}
                        </span>
                    </dd></div>
                    <div><dt class="text-sm text-gray-500">Customer</dt><dd class="text-sm font-medium">{{ $jobOrder->customer?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Consignee</dt><dd class="text-sm font-medium">{{ $jobOrder->consignee?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Shipper</dt><dd class="text-sm font-medium">{{ $jobOrder->shipper?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Notify Party</dt><dd class="text-sm font-medium">{{ $jobOrder->notifyParty?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Jenis Barang</dt><dd class="text-sm font-medium">{{ $jobOrder->jenis_barang ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">HS Code</dt><dd class="text-sm font-medium">{{ $jobOrder->hs_code ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Berat</dt><dd class="text-sm font-medium">{{ $jobOrder->berat ? number_format($jobOrder->berat, 0, ',', '.') . ' kg' : '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Volume</dt><dd class="text-sm font-medium">{{ $jobOrder->volume ? number_format($jobOrder->volume, 2, ',', '.') . ' m3' : '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Jumlah Container</dt><dd class="text-sm font-medium">{{ $jobOrder->jumlah_container ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Incoterms</dt><dd class="text-sm font-medium">{{ $jobOrder->incoterms ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Rute & Pelayaran</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Asal</dt><dd class="text-sm font-medium">{{ $jobOrder->asal ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Tujuan</dt><dd class="text-sm font-medium">{{ $jobOrder->tujuan ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Pelabuhan Asal</dt><dd class="text-sm font-medium">{{ $jobOrder->pelabuhan_asal ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Pelabuhan Tujuan</dt><dd class="text-sm font-medium">{{ $jobOrder->pelabuhan_tujuan ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Negara Asal</dt><dd class="text-sm font-medium">{{ $jobOrder->negara_asal ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Negara Tujuan</dt><dd class="text-sm font-medium">{{ $jobOrder->negara_tujuan ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Vessel</dt><dd class="text-sm font-medium">{{ $jobOrder->vessel ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Voyage</dt><dd class="text-sm font-medium">{{ $jobOrder->voyage ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">ETD</dt><dd class="text-sm font-medium">{{ $jobOrder->etd?->format('d M Y') ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">ETA</dt><dd class="text-sm font-medium">{{ $jobOrder->eta?->format('d M Y') ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Container</h3>
                @if($jobOrder->containers->count())
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm font-medium text-gray-500 border-b">
                            <th class="px-4 py-2">Nomor Container</th>
                            <th class="px-4 py-2">Size</th>
                            <th class="px-4 py-2">Type</th>
                            <th class="px-4 py-2">Seal Number</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($jobOrder->containers as $c)
                        <tr>
                            <td class="px-4 py-2">{{ $c->nomor_container }}</td>
                            <td class="px-4 py-2">{{ $c->size }}</td>
                            <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $c->type) }}</td>
                            <td class="px-4 py-2">{{ $c->pivot->seal_number ?? $c->seal_number ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-sm text-gray-500">Tidak ada container</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Customs</h3>
                @if($jobOrder->customs)
                <dl class="grid grid-cols-2 gap-4">
                    <div><dt class="text-sm text-gray-500">Jenis</dt><dd class="text-sm font-medium">{{ ucfirst($jobOrder->customs->jenis) }}</dd></div>
                    <div><dt class="text-sm text-gray-500">No PIB/PEB</dt><dd class="text-sm font-medium">{{ $jobOrder->customs->nomor_pib_peb }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Jalur</dt><dd class="text-sm font-medium capitalize">{{ $jobOrder->customs->jalur ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Status</dt><dd class="text-sm font-medium capitalize">{{ $jobOrder->customs->status ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Tanggal Pengajuan</dt><dd class="text-sm font-medium">{{ $jobOrder->customs->tanggal_pengajuan?->format('d M Y') ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Tanggal Release</dt><dd class="text-sm font-medium">{{ $jobOrder->customs->tanggal_release?->format('d M Y') ?? '-' }}</dd></div>
                </dl>
                <a href="{{ route('operasional.customs.show', $jobOrder->customs) }}" class="mt-3 inline-block text-sm text-teal hover:text-teal-600">Lihat Detail Customs</a>
                @else
                <p class="text-sm text-gray-500">Belum ada data customs</p>
                <a href="{{ route('operasional.customs.create', ['job_order_id' => $jobOrder->id]) }}" class="mt-2 inline-block text-sm text-teal hover:text-teal-600">+ Tambah Customs</a>
                @endif
            </div>

            @if($jobOrder->catatan)
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Catatan</h3>
                <p class="text-sm text-gray-700">{{ $jobOrder->catatan }}</p>
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Armada & Driver</h3>
                <dl class="space-y-3">
                    <div><dt class="text-sm text-gray-500">Armada</dt><dd class="text-sm font-medium">{{ $jobOrder->armada?->nomor_polisi ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Driver</dt><dd class="text-sm font-medium">{{ $jobOrder->driver?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">Shipping Line</dt><dd class="text-sm font-medium">{{ $jobOrder->shippingLine?->nama ?? '-' }}</dd></div>
                    <div><dt class="text-sm text-gray-500">PPJK</dt><dd class="text-sm font-medium">{{ $jobOrder->ppjk?->nama_perusahaan ?? '-' }}</dd></div>
                </dl>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Informasi Finance</h3>
                @if($jobOrder->invoices->count())
                <div class="space-y-2">
                    @foreach($jobOrder->invoices as $inv)
                    <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                        <div>
                            <p class="text-sm font-medium">{{ $inv->nomor_invoice }}</p>
                            <p class="text-xs text-gray-500">{{ $inv->status }}</p>
                        </div>
                        <span class="text-sm font-semibold">Rp {{ number_format($inv->total, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-500">Belum ada invoice</p>
                @endif
                <div class="mt-3 pt-3 border-t">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Total Cost</span>
                        <span class="font-medium">Rp {{ number_format($jobOrder->costs->sum('jumlah'), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Visual Rute Demo</h3>
                @php
                    $routePoints = $jobOrder->gpsTracking->sortBy('waktu')->values();
                @endphp
                @if($routePoints->count())
                <div class="relative">
                    <div class="absolute left-4 top-4 bottom-4 w-0.5 bg-teal-100"></div>
                    <div class="space-y-4">
                        @foreach($routePoints as $point)
                        <div class="relative flex gap-4">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold z-10
                                @if($point->status == 'running') bg-teal text-white
                                @elseif($point->status == 'stop') bg-yellow-500 text-white
                                @else bg-navy text-white @endif">
                                {{ $loop->iteration }}
                            </div>
                            <div class="flex-1 border border-gray-100 rounded-lg p-3">
                                <div class="flex justify-between">
                                    <p class="text-sm font-semibold text-navy">{{ $point->lokasi ?? 'Checkpoint' }}</p>
                                    <span class="text-xs text-gray-500">{{ $point->waktu?->format('H:i') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ ucfirst($point->status) }} | {{ $point->speed ?? 0 }} km/h | {{ $point->latitude }}, {{ $point->longitude }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <p class="text-sm text-gray-500">Klik Dummy GPS/RFID untuk menampilkan visual rute.</p>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Dummy GPS Tracking</h3>
                <div class="space-y-3">
                    @forelse($jobOrder->gpsTracking as $track)
                    <div class="border-b border-gray-100 pb-2">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">{{ $track->lokasi ?? '-' }}</span>
                            <span class="text-gray-500">{{ $track->waktu?->format('d M H:i') }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $track->latitude }}, {{ $track->longitude }} | {{ $track->speed ?? 0 }} km/h | {{ str_replace('_', ' ', $track->status) }}
                        </p>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada data dummy GPS.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Dummy RFID Events</h3>
                <div class="space-y-3">
                    @forelse($jobOrder->rfidEvents as $event)
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <div>
                            <p class="text-sm font-medium">{{ strtoupper(str_replace('_', ' ', $event->event_type)) }}</p>
                            <p class="text-xs text-gray-500">{{ $event->location ?? '-' }} | {{ $event->rfid_tag ?? '-' }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $event->waktu?->format('d M H:i') }}</span>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500">Belum ada event dummy RFID.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Update Status</h3>
                <form method="POST" action="{{ route('operasional.job-order.status', $jobOrder) }}">
                    @csrf @method('PATCH')
                    <div class="space-y-3">
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
                        <button type="submit" class="w-full px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600">Update Status</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-navy border-b pb-2 mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <div>
                            <p class="text-xs text-gray-500">Dibuat</p>
                            <p class="text-sm">{{ $jobOrder->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @if($jobOrder->updated_at != $jobOrder->created_at)
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                        <div>
                            <p class="text-xs text-gray-500">Terakhir diupdate</p>
                            <p class="text-sm">{{ $jobOrder->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
