<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cadê a Água?') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-sky-50">
    <header
        x-data="{ open: false }"
        class="relative bg-white/80 backdrop-blur border-b border-sky-100 z-50"
    >
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <!-- Logo + Marca -->
            <a href="{{ route('mapa') }}" class="flex items-center gap-2">
                {{-- <x-application-logo class="w-10 h-10 text-sky-600" /> --}}
                <img
                    src="{{ asset('images/brand.png') }}"
                    alt="Cadê a Água"
                    class="h-8 w-7">

                <span class="text-xl font-semibold text-sky-700">
                    {{ config('app.name', 'Cadê a Água?') }}
                </span>
            </a>

            <!-- Botão Mobile -->
            <button
                @click="open = !open"
                class="relative w-8 h-8 flex flex-col justify-center items-center gap-1 md:hidden group"
            >
                <span
                    class="block h-0.5 w-6 bg-sky-700 rounded transition-all duration-300"
                    :class="open ? 'rotate-45 translate-y-1.5 w-6' : ''"
                ></span>

                <span
                    class="block h-0.5 w-6 bg-sky-700 rounded transition-all duration-300"
                    :class="open ? 'opacity-0 w-0' : 'opacity-100 w-6'"
                ></span>

                <span
                    class="block h-0.5 w-6 bg-sky-700 rounded transition-all duration-300"
                    :class="open ? '-rotate-45 -translate-y-1.5 w-6' : ''"
                ></span>
            </button>

            <!-- Menu Desktop -->
            <nav class="hidden md:flex items-center gap-6">
                <a href="/" class="text-sky-700 hover:text-sky-900 transition">Mapa da Seca</a>
                <a href="/login" class="text-sky-700 hover:text-sky-900 transition">Entrar</a>
                <a
                    href="/register"
                    class="bg-gradient-to-r from-sky-600 to-teal-500 text-white px-4 py-2 rounded-lg shadow hover:opacity-90 transition font-medium"
                >
                    Registrar
                </a>
            </nav>
        </div>

        <!-- Menu Mobile -->
        <div
            class="md:hidden absolute left-0 right-0 px-4"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-3"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-3"
            style="display: none;"
        >
            <div class="bg-white shadow-lg border border-sky-100 rounded-xl mt-3 py-4 relative z-50">
                <nav class="flex flex-col space-y-2 text-center">
                    <a
                        href="/"
                        class="py-2 text-sky-700 hover:text-sky-900 font-medium transition"
                    >
                        Mapa da Seca
                    </a>

                    <a
                        href="/login"
                        class="py-2 text-sky-700 hover:text-sky-900 font-medium transition"
                    >
                        Entrar
                    </a>

                    <a
                        href="/register"
                        class="mt-2 bg-gradient-to-r from-sky-600 to-teal-500 text-white px-4 py-2 rounded-lg shadow hover:opacity-90 transition font-medium mx-8"
                    >
                        Registrar
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <main class="min-h-screen flex flex-col items-center px-4 py-10">
        <div class="w-full max-w-md bg-white/90 backdrop-blur shadow-lg rounded-2xl p-6 border border-sky-100">
            {{ $slot }}
        </div>
    </main>

    <footer class="bg-white/80 backdrop-blur border-t border-sky-100 mt-10">
        <div class="max-w-7xl mx-auto px-4 py-10 text-center">
            <p class="text-sky-600">
                Sistema colaborativo de mapeamento do rodízio de água.
            </p>

            <p class="text-sky-700 font-medium mt-2">
                © {{ date('Y') }} {{ config('app.name', 'Cadê a Água?') }} — Licenciado sob a MIT License • <a href="https://github.com/ron1rbr/cadeaagua">GitHub</a>
            </p>
        </div>
    </footer>
</body>
</html>
