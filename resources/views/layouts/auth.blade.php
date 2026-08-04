<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SDA Church CMS') }} - Auth</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;1,6..12,400&display=swap" rel="stylesheet">
    <script>
        (function () {
            try {
                var raw = localStorage.getItem('churchms:uiSettings');
                if (!raw) return;
                var settings = JSON.parse(raw);
                if (settings && settings.darkMode) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    document.documentElement.style.backgroundColor = '#111827';
                }
                if (settings && settings.cssVars) {
                    for (var k in settings.cssVars) {
                        if (Object.prototype.hasOwnProperty.call(settings.cssVars, k)) {
                            document.documentElement.style.setProperty(k, settings.cssVars[k]);
                        }
                    }
                }
            } catch (e) {}
        })();
    </script>
    @vite(['resources/css/church-cms.css', 'resources/js/church-cms.js'])
</head>
<body>
    @include('partials.splash')
    <button class="auth-theme-toggle" data-theme-btn onclick="toggleTheme()" title="Toggle dark / light mode">
      <svg class="theme-icon-moon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      <svg class="theme-icon-sun" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:none"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
    </button>
    <div id="auth-container">
        <div class="auth-bg-circles"><span></span><span></span><span></span></div>
        <div class="auth-card">
            <div class="auth-logo">
                <div class="auth-logo-badge">
                    <img src="{{ asset('images/church.png') }}" alt="SDA Logo">
                </div>
                <div class="auth-logo-text">
                    <h2>{{ config('app.name', 'SDA Church Management System') }}</h2>
                    <p>Seventh-day Adventist Church</p>
                </div>
            </div>
            @if(session('success'))
            <div class="alert alert-success" style="margin-bottom:16px">
                <div>{{ session('success') }}</div>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger" style="margin-bottom:16px">
                <div>{{ session('error') }}</div>
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
