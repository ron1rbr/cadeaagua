<x-app-layout>
    <x-slot name="header">
        Linha do Tempo do Abastecimento
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filtro --}}
            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-sky-700">
                            Seleção de Rua
                        </h2>

                        <p class="mt-1 text-sm text-sky-600">
                            Visualize os ciclos completos de abastecimento por local.
                        </p>
                    </header>

                    <form method="GET" class="mt-6 flex flex-col sm:flex-row gap-4 items-end">
                        <div class="w-full sm:flex-1">
                            <x-input-label for="rua" value="Rua" />

                            <select
                                name="rua_id"
                                id="rua"
                                required
                                class="mt-1 block w-full border-sky-300 focus:border-sky-500 focus:ring-sky-500 rounded-lg">
                                <option value="">Selecione uma rua</option>
                                {{-- opções --}}
                            </select>
                        </div>

                        <x-primary-button>
                            Ver timeline
                        </x-primary-button>
                    </form>
                </section>
            </div>

            {{-- Timeline --}}
            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-sky-700">
                            Ciclos de Abastecimento
                        </h2>

                        <p class="mt-1 text-sm text-sky-600">
                            Períodos completos entre chegada e interrupção da água.
                        </p>
                    </header>

                    <div class="mt-6 relative border-l border-sky-200">
                        @forelse($timeline as $item)
                            <div class="ml-6 pb-8 relative">
                                {{-- Ponto --}}
                                <span class="absolute -left-3 top-1.5 w-5 h-5 rounded-full bg-sky-500"></span>

                                {{-- Card --}}
                                <div class="bg-white border border-sky-100 rounded-lg p-4 shadow-sm">
                                    <p class="text-sm text-sky-500">
                                        {{ $item['inicio']->format('d/m/Y H:i') }}
                                        →
                                        {{ $item['fim']->format('d/m/Y H:i') }}
                                    </p>

                                    <h3 class="text-base font-medium text-sky-900 mt-1">
                                        {{ $item['rua'] }}
                                    </h3>

                                    <p class="mt-2 text-sm text-sky-700">
                                        <strong>Duração:</strong>
                                        {{ gmdate('H:i', $item['duracao_minutos'] * 60) }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="ml-6 py-6 text-sm text-sky-600">
                                Nenhum ciclo completo encontrado para a rua selecionada.
                            </div>
                        @endforelse
                    </div>
                </section>
            </div>

        </div>
    </div>
</x-app-layout>
