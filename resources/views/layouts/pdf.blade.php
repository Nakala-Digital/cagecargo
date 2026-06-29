<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #1a1a2e; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th { background: #022864; color: white; padding: 6px 8px; text-align: left; font-size: 10px; }
        td { padding: 5px 8px; border-bottom: 1px solid #e5e7eb; }
        .text-right { text-align: right; }
        .text-green { color: #059669; }
        .text-red { color: #dc2626; }
        .text-bold { font-weight: bold; }
        .header { text-align: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #022864; }
        .header h1 { font-size: 16px; color: #022864; margin: 0; }
        .header p { font-size: 10px; color: #6b7280; margin: 4px 0 0; }
        .summary-grid { width: 100%; margin-top: 12px; }
        .summary-grid td { border: 1px solid #e5e7eb; padding: 8px 12px; }
        .section-title { font-size: 13px; color: #022864; font-weight: bold; margin-top: 16px; border-bottom: 1px solid #022864; padding-bottom: 4px; }
        .footer { text-align: center; font-size: 9px; color: #9ca3af; margin-top: 24px; border-top: 1px solid #e5e7eb; padding-top: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>PT CargoGate Logistics</h1>
        <p>@yield('subtitle', '')</p>
    </div>
    @yield('content')
    <div class="footer">Dicetak pada {{ now()->format('d M Y H:i') }} | Sistem Informasi CargoGate</div>
</body>
</html>
