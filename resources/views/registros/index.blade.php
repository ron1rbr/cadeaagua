<x-app-layout>
    <x-slot name="header">
        Meus Registros
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-4 sm:p-8 bg-white border border-sky-100 shadow sm:rounded-lg">
                <div class="max-w-xl">

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
                                class="inline-flex justify-center items-center px-4 py-2 bg-sky-600 rounded-lg text-xs font-semibold text-white uppercase hover:bg-sky-700 transition"
                            >
                                Novo Registro
                            </a>
                        </header>

                        {{-- Lista --}}
                        <div class="mt-6 space-y-4 md:relative md:pl-6">

                            {{-- Linha da timeline (desktop) --}}
                            <span class="hidden md:block absolute left-2 top-0 bottom-0 w-px bg-sky-200"></span>

                            @forelse($registros as $registro)
                                <div class="relative">

                                    {{-- Marcador (desktop) --}}
                                    <span
                                        class="hidden md:block absolute -left-[6px] top-6 w-3 h-3 rounded-full
                                        {{ $registro->tipo_evento === 'chegou'
                                            ? 'bg-green-500'
                                            : 'bg-red-500' }}"
                                    ></span>

                                    {{-- Card --}}
                                    <div class="p-4 bg-sky-50 border border-sky-100 rounded-lg">

                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <p class="text-xs text-sky-600">
                                                    {{ $registro->data_evento->format('d/m/Y H:i') }}
                                                </p>

                                                <p class="mt-1 font-medium text-sky-800">
                                                    {{ $registro->rua->nome }}
                                                </p>
                                            </div>

                                            {{-- Badge --}}
                                            <span
                                                class="shrink-0 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $registro->tipo_evento === 'chegou'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-red-100 text-red-700' }}"
                                            >
                                                {{ $registro->tipo_evento === 'chegou'
                                                    ? 'Água Chegou'
                                                    : 'Água Acabou' }}
                                            </span>
                                        </div>

                                        {{-- Nota (discreta) --}}
                                        @if($registro->nota)
                                            <p class="mt-2 text-xs text-slate-500 leading-relaxed">
                                                {{ $registro->nota }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-sm text-sky-600 bg-sky-50 rounded-lg border border-sky-100">
                                    Nenhum registro encontrado.
                                </div>
                            @endforelse
                        </div>

                        {{-- Paginação --}}
                        <div class="mt-6">
                            {{ $registros->links() }}
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
