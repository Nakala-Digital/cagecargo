<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CargoGate') - {{ config('app.name', 'CargoGate') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            if (!window.Chart) {
                return;
            }

            Chart.defaults.font.family = "'Poppins', ui-sans-serif, system-ui, sans-serif";
            Chart.defaults.color = '#64748b';
            Chart.defaults.borderColor = '#e2e8f0';
            Chart.defaults.animation.duration = 650;
            Chart.defaults.plugins.tooltip.backgroundColor = '#0f172a';
            Chart.defaults.plugins.tooltip.borderColor = 'rgba(255, 255, 255, 0.12)';
            Chart.defaults.plugins.tooltip.borderWidth = 1;
            Chart.defaults.plugins.tooltip.cornerRadius = 10;
            Chart.defaults.plugins.tooltip.padding = 12;
            Chart.defaults.plugins.tooltip.titleColor = '#f8fafc';
            Chart.defaults.plugins.tooltip.bodyColor = '#e2e8f0';
            Chart.defaults.plugins.legend.labels.boxWidth = 8;
            Chart.defaults.plugins.legend.labels.boxHeight = 8;
            Chart.defaults.plugins.legend.labels.usePointStyle = true;
            Chart.defaults.plugins.legend.labels.padding = 16;
        });
    </script>
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
