<nav class="fixed top-0 left-0 h-full w-64 bg-navy text-white shadow-lg z-50 flex flex-col">
    <div class="p-4 border-b border-navy-700">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 rounded-lg bg-white flex items-center justify-center overflow-hidden">
                <img src="{{ asset('logo.png') }}" alt="CargoGate" class="w-full h-full object-contain p-1">
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">CargoGate</h1>
                <p class="text-xs text-teal-300">Logistics Management</p>
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto py-4">
        <div class="px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Dashboard</div>
        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        <div class="mt-6 px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Master Data</div>
        <a href="{{ route('master.customer.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.customer*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Customer
        </a>
        <a href="{{ route('master.vendor.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.vendor*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Vendor
        </a>
        <a href="{{ route('master.ppjk.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.ppjk*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            PPJK
        </a>
        <a href="{{ route('master.shipping-line.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.shipping-line*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Shipping Line
        </a>
        <a href="{{ route('master.armada.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.armada*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Armada
        </a>
        <a href="{{ route('master.driver.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.driver*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Driver
        </a>
        <a href="{{ route('master.container.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.container*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            Container
        </a>

        <div class="mt-6 px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Armada Management</div>
        <a href="{{ route('master.armada.jenis.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.armada.jenis*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            Jenis Armada
        </a>
        <a href="{{ route('master.armada.kontrak.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('master.armada.kontrak*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Kontrak Subkon
        </a>

        <div class="mt-6 px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Operasional</div>
        <a href="{{ route('operasional.job-order.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.job-order*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Job Order
        </a>
        <a href="{{ route('operasional.customs.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.customs*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Customs
        </a>
        <a href="{{ route('operasional.surat-jalan.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.surat-jalan*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            Surat Jalan
        </a>
        <a href="{{ route('operasional.pengeluaran.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.pengeluaran*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Pengeluaran Armada
        </a>
        <a href="{{ route('operasional.uang-jalan.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.uang-jalan*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Uang Jalan
        </a>
        <a href="{{ route('operasional.maintenance.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('operasional.maintenance*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Maintenance
        </a>

        <div class="mt-6 px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Finance</div>
        <a href="{{ route('finance.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('finance.index') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Invoice
        </a>
        <a href="{{ route('finance.profit') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('finance.profit') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            Profit Analysis
        </a>
        <a href="{{ route('finance.export') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('finance.export') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Data
        </a>
        <a href="{{ route('finance.ap.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('finance.ap*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            A/P Armada
        </a>
        <a href="{{ route('finance.ar.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('finance.ar*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            A/R Armada
        </a>

        <div class="mt-6 px-4 mb-2 text-xs font-semibold text-teal-300 uppercase tracking-wider">Laporan & Closing</div>
        <a href="{{ route('laporan.aging') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.aging*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Aging AR/AP
        </a>
        <a href="{{ route('laporan.outstanding') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.outstanding*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Outstanding
        </a>
        <a href="{{ route('laporan.reminder') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.reminder*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            Reminder Jatuh Tempo
        </a>
        <a href="{{ route('laporan.laba-rugi') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.laba-rugi*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Laba Rugi
        </a>
        <a href="{{ route('laporan.neraca') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.neraca*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
            Neraca
        </a>
        <a href="{{ route('laporan.cash-flow') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.cash-flow*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
            Cash Flow
        </a>
        <a href="{{ route('laporan.profit-per-customer') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.profit-per-customer*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Profit per Customer
        </a>
        <a href="{{ route('laporan.profit-per-armada') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.profit-per-armada*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Profit per Armada
        </a>
        <a href="{{ route('laporan.profit-per-driver') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.profit-per-driver*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Profit per Driver
        </a>
        <a href="{{ route('laporan.closing.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-300 hover:bg-navy-700 hover:text-white transition-colors {{ request()->routeIs('laporan.closing*') ? 'bg-navy-700 text-white border-l-4 border-teal' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Closing Bulanan
        </a>
    </div>

    <div class="p-4 border-t border-navy-700">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-300 hover:bg-navy-700 hover:text-white rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</nav>
