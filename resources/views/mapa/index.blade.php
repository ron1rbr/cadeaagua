<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadê a Água?</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind / Alpine --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Leaflet --}}
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

    <style>
        #map {
            height: calc(100vh - 4rem);
            width: 100%
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
        }

        .leaflet-popup-content {
            font-family: inherit;
            font-size: 0.875rem;
            color: rgb(15 23 42);
        }

        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    {{-- NAVBAR --}}
    <nav class="relative z-50 bg-white/80 backdrop-blur border-b border-sky-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <img
                        src="{{ asset('images/brand.png') }}"
                        alt="Cadê a Água"
                        class="h-8 w-7">

                    <span class="text-xl font-semibold text-sky-700">
                        Cadê a Água?
                    </span>
                </a>

                <div class="flex items-center gap-4">
                    @auth
                        <a 
                            href="{{ route('registros.index') }}"
                            class="bg-gradient-to-r from-sky-600 to-teal-500 text-white
                                   px-4 py-2 rounded-lg shadow hover:opacity-90
                                   transition font-medium"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="text-sky-700 hover:text-sky-900 transition"
                        >
                            Entrar
                        </a>

                        <a
                            href="{{ route('register') }}"
                            class="bg-gradient-to-r from-sky-600 to-teal-500 text-white
                                   px-4 py-2 rounded-lg shadow hover:opacity-90
                                   transition font-medium"
                        >
                            Registrar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- MAPA --}}
    <main class="relative">
        <div id="map"></div>
    </main>

    {{-- POPUP EXPLICATIVO --}}
    <div
        x-data="{ open: !localStorage.getItem('mapa-seca-entendido') }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed top-24 left-1/2 -translate-x-1/2 z-[9999] w-[90%] max-w-md"
        x-cloak
    >
        <div class="bg-white/95 backdrop-blur border border-sky-100 rounded-xl shadow p-4">
            <h2 class="text-sm font-semibold text-sky-700">
                Mapa da Seca
            </h2>

            <p class="mt-1 text-sm text-sky-600">
                Mostra a situação mais recente da água por rua.
            </p>

            <div class="mt-3 flex gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-sky-500"></span>
                    <span>Água chegou</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500"></span>
                    <span>Água acabou</span>
                </div>
            </div>

            <x-primary-button
                class="mt-4 w-full"
                @click="localStorage.setItem('mapa-seca-entendido', '1'); open = false;"
            >
                Entendi
            </x-primary-button>
        </div>
    </div>

    {{-- Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-9.8349, -39.4821], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        async function carregarRuas() {
            try {
                const response = await fetch('{{ route('mapa.ruas') }}');
                const data = await response.json();

                L.geoJSON(data, {
                    filter: feature => {
                        return feature.properties.tipo_evento != null;
                    },
                    style: feature => {
                        switch (feature.properties.tipo_evento) {
                            case 'chegou':
                                return { color: '#0ea5e9', weight: 5 };
                            case 'acabou':
                                return { color: '#ef4444', weight: 5 };
                        }
                    },
                    onEachFeature: (feature, layer) => {
                        const p = feature.properties;

                        layer.bindPopup(`
                            <strong>${p.nome}</strong><br>
                            Status: ${p.tipo_evento == 'chegou' ? 'Água chegou' : 'Água acabou'}<br>
                            Data: ${p.data_consolidacao_formatada}
                        `);
                    }
                }).addTo(map);
            } catch (err) {
                console.error(err);
            }
        }

        carregarRuas();
    </script>
</body>
</html>