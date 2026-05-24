<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SDA Church CMS') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;1,6..12,400&display=swap" rel="stylesheet">
    @vite(['resources/css/church-cms.css', 'resources/js/church-cms.js'])
    @stack('styles')
</head>
<body>

    <!-- TOAST CONTAINER -->
    <div class="toast-container" id="toastContainer"></div>

    @include('partials.splash')

    <div id="app" class="visible">
        @include('partials.header')

        <div class="app-body">
            @include('partials.sidebar')

            <main class="main-content" id="mainContent">
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
