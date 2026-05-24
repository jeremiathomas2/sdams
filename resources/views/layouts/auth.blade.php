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
    @include('partials.splash')
    <div id="auth-container">
        <div class="auth-bg-circles"><span></span><span></span><span></span></div>
        <div class="auth-card">
            <div class="auth-logo">
                <img src="{{ asset('images/church.png') }}" alt="SDA Logo" width="64">
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
