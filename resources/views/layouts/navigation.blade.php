<nav x-data="{ open: false }" class="relative z-50 bg-white/80 backdrop-blur border-b border-sky-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <img
                            src="{{ asset('images/brand.png') }}"
                            alt="Cadê a Água"
                            class="h-8 w-7">

                        <span class="text-xl font-semibold text-sky-700">
                            Cadê a Água?
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        :href="route('registros.index')"
                        :active="request()->routeIs('registros.index')">
                        Meus Registros
                    </x-nav-link>

                    <x-nav-link
                        :href="route('registros.historico')"
                        :active="request()->routeIs('registros.historico')">
                        Histórico de Abastecimento
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent
                            text-sm leading-4 font-medium rounded-md text-sky-700 bg-white
                            hover:text-sky-900 shadow-sm focus:outline-none transition duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-sky-700"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link
                            :href="route('profile.edit')"
                            class="text-sky-700">
                            Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-600">
                                Sair
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburguer -->
            <div class="-me-2 flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="relative w-8 h-8 flex flex-col justify-center items-center gap-1 group"
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
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div
        class="md:hidden absolute left-0 right-0 px-4"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-3"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-3"
        style="display: none;"
    >
        <div class="bg-white shadow-lg border border-sky-100 rounded-xl mt-3 py-4 relative z-50">
            <nav class="flex flex-col space-y-2 text-center">
                <x-responsive-nav-link
                    :href="route('registros.index')"
                    :active="request()->routeIs('registros.index')"
                    class="text-sky-700"
                >
                    Meus Registros
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('registros.historico')"
                    :active="request()->routeIs('registros.historico')"
                    class="py-2 text-sky-700"
                >
                    Histórico de Abastecimento
                </x-responsive-nav-link>

                <x-responsive-nav-link
                    :href="route('profile.edit')"
                    :active="request()->routeIs('profile.edit')"
                    class="py-2 text-sky-700"
                >
                    Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="text-red-600"
                    >
                        Sair
                    </x-responsive-nav-link>
                </form>
            </nav>
        </div>
    </div>
</nav>
