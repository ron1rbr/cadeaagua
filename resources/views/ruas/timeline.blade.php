<x-app-layout>
    <x-slot name="header">
        Ciclo da Água
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Filtro --}}
            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-sky-700">
                            Linha do tempo
                        </h2>

                        <p class="mt-1 text-sm text-sky-600">
                            Visualize os períodos com e sem abastecimento por rua.
                        </p>
                    </header>

                    <form method="GET" action="{{ route('timeline') }}" class="mt-6 max-w-md">
                        <x-input-label for="rua" value="Local" />

                        <select
                            name="rua_id"
                            id="rua"
                            onchange="this.form.submit()"
                            class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg"
                        >
                            <option value="">Digite o nome da rua ou local</option>
                            @if($ruaSelecionada)
                                <option value="{{ $ruaSelecionada->id }}" selected>{{ $ruaSelecionada->nome }}</option>
                            @endif
                        </select>
                    </form>
                </section>
            </div>

            @if($ruaSelecionada)
                <div
                    x-data="{
                        selected: null,
                        eventos: @js($timeline)
                    }"
                    class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg"
                >
                    <section>
                        <!-- <header class="mb-6">
                            <p class="text-sm text-sky-600">
                                {{ $inicio->format('d M Y') }} → {{ $fim->format('d M Y') }}
                            </p>
                        </header> -->

                        @if(empty($timeline))
                            <p class="text-sm text-sky-600">
                                Não há histórico suficiente para esta rua.
                            </p>
                        @else
                            @php
                                $totalSegundos = $inicio->diffInSeconds($fim);
                                $ultimo = last($timeline);
                            @endphp

                            {{-- Estado atual --}}
                            <div class="mb-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $ultimo['tipo'] == 'chegou'
                                        ? 'bg-sky-100 text-sky-700'
                                        : 'bg-gray-100 text-gray-700' }}
                                ">
                                    {{ $ultimo['tipo'] == 'chegou' ? '💧 Com água' : '🚫 Sem água' }}
                                </span>

                                <p class="mt-1 text-xs text-sky-500">
                                    desde {{ $ultimo['inicio']->format('d/M H:i')}}
                                    ({{ $ultimo['label'] }})
                                </p>
                            </div>

                            {{-- Timeline --}}
                            <p class="text-xs text-sky-500 mb-2">
                                Toque ou clique em um período para ver detalhes
                            </p>

                            <div class="w-full h-14 sm:h-10 rounded-lg overflow-hidden flex bg-sky-50 border border-sky-100">
                                @foreach($timeline as $index => $evento)
                                    @php
                                        $width = ($evento['duracao'] / $totalSegundos) * 100;
                                    @endphp

                                    <button
                                        type="button"
                                        class="relative h-full flex items-center justify-center
                                            cursor-pointer hover:opacity-90 focus:outline-none
                                            {{ $evento['tipo'] == 'chegou'
                                                ? 'bg-sky-500'
                                                : 'bg-gray-400' }}"
                                        :class="selected == {{ $index }} && 'ring-2 ring-sky-300 ring-inset'"
                                        style="width: {{ $width }}%"
                                        @click="selected = {{ $index }}"
                                    >
                                    </button>
                                @endforeach
                            </div>

                            {{-- Painal de detalhes --}}
                            <div
                                class="mt-6 p-4 border border-sky-100 rounded-lg bg-sky-50"
                                x-show="selected != null"
                                x-transition
                            >
                                <template x-if="selected != null">
                                    <div>
                                        <p class="text-xs text-sky-500 mb-1">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium"
                                                :class="eventos[selected].tipo == 'chegou'
                                                    ? 'bg-sky-100 text-sky-700'
                                                    : 'bg-gray-200 text-gray-700'"
                                            >
                                                <span
                                                    x-text="eventos[selected].tipo == 'chegou'
                                                        ? '💧 Com água'
                                                        : '🚫 Sem água'"
                                                >
                                                </span>
                                            </span>
                                        </p>

                                        <p class="text-sm font-medium text-sky-900">
                                            Início:
                                            <span x-text="eventos[selected].inicio_formatado"></span>
                                            <span class="mx-1 text-sky-400">→</span>
                                            Fim:
                                            <span x-text="eventos[selected].fim_formatado"></span>
                                        </p>

                                        <p class="mt-1 text-sm text-sky-700">
                                            Duração: <strong x-text="eventos[selected].label"></strong>
                                        </p>
                                    </div>
                                </template>
                            </div>

                            {{-- Legenda --}}
                            <div class="flex flex-wrap gap-4 mt-4 text-sm text-sky-700">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-sky-500 rounded"></span>
                                    <span>Com água</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-gray-400 rounded"></span>
                                    <span>Sem água</span>
                                </div>
                            </div>
                        @endif
                    </section>
                </div>
            @endif
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