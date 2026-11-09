<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Helpdesk Kampus') }} — STMIK Mardira Indonesia</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/logo.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-800 bg-[#eef3f9] min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="grow">
            @yield('content')
            {{ $slot ?? '' }}
        </main>

        <footer class="mt-auto py-6 border-t border-slate-200 bg-white text-center text-xs text-slate-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-5 h-5 rounded object-contain">
                    <span class="font-semibold text-slate-700">Helpdesk Kampus — STMIK Mardira Indonesia</span>
                </div>
                <div>
                    &copy; {{ date('Y') }} Sistem Informasi Layanan Aspirasi & Pengaduan Kampus.
                </div>
            </div>
        </footer>
    </body>
</html>
