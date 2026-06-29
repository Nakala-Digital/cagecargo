<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CargoGate') - {{ config('app.name', 'CargoGate') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    @auth
        @include('layouts.navigation')
    @endauth

    <main class="@auth ml-64 min-h-screen @endauth">
        @auth
        <div class="p-6">
        @endauth

        @if (session('success'))
            <div class="mb-4 px-4 py-3 bg-teal-50 border border-teal-200 text-teal-700 rounded-lg" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        @yield('content')

        @auth
        </div>
        @endauth
    </main>

    @stack('scripts')
</body>
</html>
