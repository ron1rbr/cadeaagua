<x-app-layout>
    <x-slot name="header">
        Meus Registros
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-alert />

            {{-- Filtros --}}
            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-sky-700">
                            Filtros
                        </h2>

                        <p class="mt-1 text-sm text-sky-600">
                            Filtre seus registros por tipo de evento ou período.
                        </p>
                    </header>

                    <form method="GET" class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="tipo-evento" value="Tipo de Evento" />

                            <select
                                name="tipo_evento"
                                id="tipo-evento"
                                class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg">
                                <option value="">Todos os eventos</option>
                                <option value="chegou" @selected(request('tipo_evento') == 'chegou')>Água Chegou</option>
                                <option value="acabou" @selected(request('tipo_evento') == 'acabou')>Água Acabou</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="data-inicio" value="Data inicial" />

                            <x-text-input
                                type="date"
                                name="data_inicio"
                                id="data-inicio"
                                class="mt-1 block w-full"
                                value="{{ request('data_inicio') }}" />
                        </div>

                        <div>
                            <x-input-label for="data-fim" value="Data final" />

                            <x-text-input
                                type="date"
                                name="data_fim"
                                id="data-fim"
                                class="mt-1 block w-full"
                                value="{{ request('data_fim') }}" />
                        </div>

                        <div class="sm:col-span-3 flex gap-2">
                            <x-primary-button>Filtrar</x-primary-button>

                            <a
                                href="{{ route('registros.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-sky-200 rounded-lg text-sm text-sky-700 hover:bg-sky-50">
                                Limpar
                            </a>
                        </div>
                    </form>
                </section>
            </div>

            {{-- Timeline --}}
            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <section>
                    <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-medium text-sky-700">
                                Histórico de Abastecimento
                            </h2>

                            <p class="mt-1 text-sm text-sky-600">
                                Registros feitos por você.
                            </p>
                        </div>

                        <a
                            href="{{ route('registros.create') }}"
                            class="w-full sm:w-auto inline-flex justify-center items-center bg-gradient-to-r from-sky-600 to-teal-500 text-white px-5 py-2 rounded-lg
                                   shadow-md hover:opacity-90 transition disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed disabled:opacity-60">
                            Novo Registro
                        </a>
                    </header>

                    <div class="mt-6 relative border-l border-sky-200">
                        @forelse($registros as $registro)
                            <div class="ml-6 pb-8 relative">
                                {{-- Ponto --}}
                                <span
                                    class="absolute -left-3 top-1.5 w-5 h-5 rounded-full flex items-center justify-center
                                    {{ $registro->tipo_evento == 'chegou' ? 'bg-green-500' : 'bg-red-500' }}">
                                    @if($registro->tipo_evento == 'chegou')
                                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    @else
                                        <svg class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    @endif
                                </span>

                                {{-- Card --}}
                                <div class="bg-white border border-sky-100 rounded-lg p-4 shadow-sm">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                        <div>
                                            <p class="text-sm text-sky-500">
                                                {{ $registro->data_evento->format('d/m/Y H:i') }}
                                            </p>

                                            <h3 class="text-base font-medium text-sky-900">
                                                {{ $registro->rua->nome }}
                                            </h3>
                                        </div>

                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                            {{ $registro->tipo_evento == 'chegou'
                                                ? 'bg-green-100 text-green-700'
                                                : 'bg-red-100 text-red-700' }}">
                                            {{ $registro->tipo_evento == 'chegou'
                                                ? 'Água Chegou'
                                                : 'Água Acabou' }}
                                        </span>
                                    </div>

                                    @if($registro->nota)
                                        <div
                                            x-data="{ open: false }"
                                            class="mt-2 text-sm text-sky-700">
                                            <strong>Nota:</strong>

                                            <span
                                                x-show="!open"
                                                x-text="@js(Str::limit($registro->nota, 25))">
                                            </span>

                                            <span x-show="open">
                                                {{ $registro->nota }}
                                            </span>

                                            @if(strlen($registro->nota) > 25)
                                                <button
                                                    type="button"
                                                    @click="open = !open"
                                                    class="ml-1 text-sky-600 hover:underline text-xs font-medium">
                                                    <span x-text="open ? 'menos' : 'mais'"></span>
                                                </button>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="ml-6 py-6 text-sm text-sky-600">
                                Nenhum registro encontrado.
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $registros->withQueryString()->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
