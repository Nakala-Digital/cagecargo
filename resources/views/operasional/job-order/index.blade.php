@extends('layouts.app')
@section('title', 'Job Order')
@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-navy">Job Order</h2>
            <p class="text-gray-500">Kelola job order pengiriman</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('operasional.job-order.create') }}" class="px-4 py-2 bg-teal text-white rounded-lg hover:bg-teal-600 transition-colors">+ Buat Job Order</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-4">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                <select name="status" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-teal focus:border-teal">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="pickup" {{ request('status') == 'pickup' ? 'selected' : '' }}>Pickup</option>
                    <option value="on_delivery" {{ request('status') == 'on_delivery' ? 'selected' : '' }}>On Delivery</option>
                    <option value="gate_in" {{ request('status') == 'gate_in' ? 'selected' : '' }}>Gate In</option>
                    <option value="customs" {{ request('status') == 'customs' ? 'selected' : '' }}>Customs</option>
                    <option value="sailing" {{ request('status') == 'sailing' ? 'selected' : '' }}>Sailing</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor JO, Customer..." class="px-3 py-2 border rounded-lg text-sm w-64 focus:ring-2 focus:ring-teal focus:border-teal">
            </div>
            <button type="submit" class="px-4 py-2 bg-navy text-white rounded-lg hover:bg-navy-700 text-sm">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="text-left text-sm font-medium text-gray-500 border-b bg-gray-50">
                    <th class="px-6 py-3">Nomor JO</th>
                    <th class="px-6 py-3">Customer</th>
                    <th class="px-6 py-3">Armada</th>
                    <th class="px-6 py-3">Driver</th>
                    <th class="px-6 py-3">Container</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($jobOrders as $job)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm font-medium text-teal">{{ $job->nomor_jo }}</td>
                    <td class="px-6 py-4 text-sm">{{ $job->customer?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $job->armada?->nomor_polisi ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $job->driver?->nama ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm">{{ $job->containers->count() }} container</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full
                            @if($job->status == 'draft') bg-gray-100 text-gray-700
                            @elseif($job->status == 'assigned') bg-blue-100 text-blue-700
                            @elseif($job->status == 'pickup') bg-yellow-100 text-yellow-700
                            @elseif($job->status == 'on_delivery') bg-orange-100 text-orange-700
                            @elseif($job->status == 'gate_in') bg-indigo-100 text-indigo-700
                            @elseif($job->status == 'customs') bg-purple-100 text-purple-700
                            @elseif($job->status == 'sailing') bg-teal-100 text-teal-700
                            @elseif($job->status == 'delivered') bg-green-100 text-green-700
                            @elseif($job->status == 'closed') bg-gray-800 text-white
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $job->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 text-sm space-x-2">
                        <a href="{{ route('operasional.job-order.show', $job) }}" class="text-teal hover:text-teal-600">Detail</a>
                        <a href="{{ route('operasional.job-order.edit', $job) }}" class="text-navy hover:text-navy-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada job order</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $jobOrders->links() }}</div>
</div>
@endsection
