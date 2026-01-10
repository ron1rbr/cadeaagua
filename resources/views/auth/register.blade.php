<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="nome" value="Nome" />
            <x-text-input
                id="nome"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="E-mail" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }" class="relative">
            <x-input-label for="senha" value="Senha" />

            <div class="relative">
                <x-text-input
                    id="senha"
                    x-ref="senha"
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                />

                <button
                    type="button"
                    @click="
                        show = !show;
                        $refs.senha.type = show ? 'text' : 'password';
                    "
                    class="absolute inset-y-0 right-0 mt-1 mr-3 flex items-center text-sky-600 hover:text-sky-800"
                >
                    <svg
                        x-show="!show"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                            0 8.268 2.943 9.542 7-1.274 4.057-5.064
                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                    </svg>

                    <svg
                        x-show="show"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478
                            0-8.268-2.943-9.542-7a9.97 9.97
                            0 012.235-3.953m3.464-2.37A9.953
                            9.953 0 0112 5c4.478 0 8.268 2.943
                            9.542 7a9.97 9.97 0 01-4.043 5.188M15
                            12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3l18 18"
                        />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div x-data="{ show: false }" class="relative">
            <x-input-label for="password_confirmation" value="Confirmar Senha" />

            <div class="relative">
                <x-text-input
                    id="password_confirmation"
                    x-ref="password_confirmation"
                    class="block mt-1 w-full"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <button
                    type="button"
                    @click="
                        show = !show;
                        $refs.password_confirmation.type = show ? 'text' : 'password';
                    "
                    class="absolute inset-y-0 right-0 mt-1 mr-3 flex items-center text-sky-600 hover:text-sky-800"
                >
                    <svg
                        x-show="!show"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478
                            0 8.268 2.943 9.542 7-1.274 4.057-5.064
                            7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                    </svg>

                    <svg
                        x-show="show"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478
                            0-8.268-2.943-9.542-7a9.97 9.97
                            0 012.235-3.953m3.464-2.37A9.953
                            9.953 0 0112 5c4.478 0 8.268 2.943
                            9.542 7a9.97 9.97 0 01-4.043 5.188M15
                            12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 3l18 18"
                        />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4">
            <a
                href="{{ route('login') }}"
                class="text-sm  text-sky-700  hover:text-sky-900 underline font-medium transition"
            >
                Já possui cadastro?
            </a>

            <x-primary-button>
                Registrar
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
