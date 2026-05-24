<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SDA Church CMS') }} - Auth</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;1,6..12,400&display=swap" rel="stylesheet">
    @vite(['resources/css/church-cms.css', 'resources/js/church-cms.js'])
</head>
<body>
    <div id="auth-container">
        <div class="auth-bg-circles"><span></span><span></span><span></span></div>
        <div class="auth-card">
            <div class="auth-logo">
                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Ccircle cx='100' cy='100' r='96' fill='%23ffffff' stroke='%231a56a0' stroke-width='6'/%3E%3Ccircle cx='100' cy='100' r='80' fill='none' stroke='%231a56a0' stroke-width='3'/%3E%3Ctext x='100' y='118' text-anchor='middle' font-family='serif' font-size='48' font-weight='bold' fill='%231a56a0'%3E✝%3C/text%3E%3Ctext x='100' y='152' text-anchor='middle' font-family='sans-serif' font-size='11' font-weight='700' fill='%231a56a0' letter-spacing='1'%3ESDA CHURCH%3C/text%3E%3C/svg%3E" alt="SDA Logo" width="64">
                <div class="auth-logo-text">
                    <h2>{{ config('app.name', 'SDA Church Management System') }}</h2>
                    <p>Seventh-day Adventist Church</p>
                </div>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>
