<x-app-layout>
    <x-slot name="header">
        Novo Registro
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-sky-700">
                                Registro Rápido
                            </h2>

                            <p class="mt-1 text-sm text-sky-600">
                                Informe rapidamente se a água chegou ou acabou no seu endereço. Sua localização é registrada automaticamente.
                            </p>
                        </header>

                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Botão Água Chegou -->
                            <form method="POST" action="{{ route('registros.rapido', 'chegou') }}" class="w-full">
                                @csrf
                                <input type="hidden" id="rua-chegou" name="rua_id">

                                <x-primary-button id="registro-rapido-chegou-btn" class="w-full py-4 flex items-center justify-center gap-2 text-lg">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>

                                    Água Chegou
                                </x-primary-button>
                            </form>

                            <!-- Botão Água Acabou -->
                            <form method="POST" action="{{ route('registros.rapido', 'acabou') }}" class="w-full">
                                @csrf
                                <input type="hidden" id="rua-acabou" name="rua_id">

                                <x-danger-button id="registro-rapido-acabou-btn" class="w-full py-4 flex items-center justify-center gap-2 text-lg">

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24"
                                        stroke-width="2"
                                        stroke="currentColor"
                                        class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>

                                    Água Acabou
                                </x-danger-button>
                            </form>
                        </div>

                        <div class="mt-4 p-3 bg-sky-50 rounded-lg border border-sky-100">
                            <p class="text-sm text-sky-700">
                                Local detectado: <span id="rua-detectada" class="font-medium">Carregando...</span>
                            </p>

                            <p class="text-xs text-sky-500 mt-1">
                                Se não encontrou, <button id="ir-manual" type="button" class="underline">faça o registro manualmente</button>.
                            </p>
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg mt-6">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-sky-700">
                                Registro Manual
                            </h2>

                            <p class="mt-1 text-sm text-sky-600">
                                Preencha manualmente os detalhes do evento de abastecimento.
                            </p>
                        </header>

                        <form method="POST" action="{{ route('registros.store') }}" id="registro-manual-form" class="mt-6 space-y-6">
                            @csrf

                            <!-- Campo Local -->
                            <div>
                                <x-input-label for="rua" :value="'Local'" />

                                <select
                                    name="rua_id"
                                    id="rua"
                                    class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg"
                                    required>
                                    <option value="">Selecione...</option>
                                </select>

                                <x-input-error :messages="$errors->get('rua_id')" class="mt-2" />
                            </div>

                            <div>
                                <!-- Tipo de Evento -->
                                <x-input-label for="tipo-evento" :value="'Tipo do Evento'" />

                                <select
                                    name="tipo_evento"
                                    id="tipo-evento"
                                    class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg"
                                    required>
                                    <option value="">Selecione...</option>
                                    <option value="chegou">Água Chegou</option>
                                    <option value="acabou">Água Acabou</option>
                                </select>

                                <x-input-error :messages="$errors->get('tipo_evento')" class="mt-2" />
                            </div>

                            <!-- Nota -->
                            <div>
                                <x-input-label for="nota" :value="'Nota (optional)'" />

                                <textarea
                                    name="nota"
                                    id="nota"
                                    class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg"
                                    rows="3"></textarea>

                                <x-input-error :messages="$errors->get('nota')" class="mt-2" />
                            </div>

                            <!-- Botão -->
                            <div class="flex items-center gap-4">
                                <x-primary-button>
                                    Registrar
                                </x-primary-button>

                                @if (session('status') === 'registro-criado')
                                <p
                                    x-data="{ show: true }"
                                    x-show="show"
                                    x-transition
                                    x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-sky-600">
                                    Registro Salvo!
                                </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-wrapper .ts-control {
            border-color: rgb(125 211 252 / 1);
            border-radius: 0.5rem;
            padding: 0.5rem 0.75rem;
            line-height: 1.5rem;
        }

        .ts-control input::placeholder {
            color: rgb(0 0 0 / 1);
            font-size: 1rem;
        }

        .ts-control input {
            color: rgb(0 0 0 / 1);
            font-size: 1rem;
        }

        .ts-control .item {
            color: rgb(0 0 0 / 1);
            font-size: 1rem;
        }

        .ts-wrapper .ts-control:focus-within {
            border-color: rgb(14 165 233 / 1);
            box-shadow: 0 0 0 1px rgb(14 165 233 / 1);
        }

        .ts-dropdown {
            margin-top: 0.5rem;
            background-color: rgb(255 255 255 / 1);
            border: 1px solid rgb(224 242 254 / 1);
	        border-radius: .375rem;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1),
                        0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        .ts-dropdown .option {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            cursor: pointer;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
	        background-color: rgb(240 249 255 / 1);
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        async function ruaMaisProxima(lat, lng) {
            try {
                const url = `{{ url('/api/ruas') }}?lat=${lat}&lng=${lng}`;

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    disableRegistroRapidoButtons();
                    document.getElementById('rua-detectada').textContent = 'Nenhum local próximo';
                    return;
                }

                const rua = await response.json();

                document.getElementById('rua-chegou').value = rua.data.id;
                document.getElementById('rua-acabou').value = rua.data.id;

                document.getElementById('rua-detectada').textContent = rua.data.nome;
            } catch (err) {
                console.error('Erro ao buscar rua mais próxima', err);
                disableRegistroRapidoButtons();
                document.getElementById('rua-detectada').textContent = 'Nenhum local próximo';
            }
        }

        function disableRegistroRapidoButtons() {
            document.getElementById('registro-rapido-chegou-btn').disabled = true;
            document.getElementById('registro-rapido-acabou-btn').disabled = true;
        }

        /* navigator.geolocation.getCurrentPosition(function(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;

            ruaMaisProxima(lat, lng);
        }, function(err) {
            console.error('Geolocalização falhou', err);
            disableRegistroRapidoButtons();
            document.getElementById('rua-detectada').textContent = 'Nenhum local pŕoximo';
        }); */

        document.getElementById('ir-manual').addEventListener('click', function() {
            const registroManualForm = document.getElementById('registro-manual-form');

            registroManualForm.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });

        ruaMaisProxima(-9.835745, -39.489039);

        new TomSelect('#rua', {
            placeholder: 'Digite o nome da rua ou local',
            valueField: 'id',
            labelField: 'nome',
            searchField: 'nome',
            loadThrottle: 300,
            load(query, callback) {
                if (!query.length) return callback();

                fetch(`{{ url('/api/ruas') }}?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => callback(data))
                    .catch(() => callback());
            }
        });
    </script>
    @endpush
</x-app-layout>
