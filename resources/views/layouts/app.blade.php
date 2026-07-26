<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SDA Church CMS') }}</title>
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
    @stack('styles')
</head>
<body>

    <!-- TOAST CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

    @include('partials.splash')

    <div id="app">
        @include('partials.header')

        <div class="app-body">
            @include('partials.sidebar')

            <main class="main-content" id="mainContent">
                @if(session('success'))
                <div class="alert alert-success" style="margin-bottom:16px">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div>{{ session('success') }}</div>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger" style="margin-bottom:16px">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <div>{{ session('error') }}</div>
                </div>
                @endif

                @yield('content')
            </main>
        </div>

        <footer class="app-footer" id="appFooter">
            {{ config('app.name', 'SDA Church Management System') }} © {{ date('Y') }} · Seventh-day Adventist Church · All rights reserved
        </footer>
    </div>

    @include('partials.settings-panel')
    
    @yield('modals')

    @stack('scripts')
</body>
</html>
