<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Cadê a Água?') }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- CSS -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-sky-50 min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white/80 backdrop-blur border-b border-sky-100">
                <div class="max-w-7xl mx-auto py-4 px-4 lg:px-8">
                    <h2 class="text-xl font-semibold text-sky-700">{{ $header }}</h2>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
         <main class="min-h-screen px-4 py-10">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
         </main>

         @stack('scripts')
    </body>
</html>
