<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4 text-teal-700 font-medium"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="E-mail" />
            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
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
                    class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
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

        <!-- Remember Me -->
        <div class="flex items-center mt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-sky-300 text-sky-600 focus:ring-sky-500"
                >
                <span class="ml-2 text-sm text-sky-700">
                    Lembrar de mim
                </span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-4">
            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-sky-700 hover:text-sky-900 underline font-medium transition"
                >
                    Esqueceu sua senha?
                </a>
            @endif

            <x-primary-button>
                Entrar
            </x-primary-button>
        </div>

        <!-- Divider -->
        <div class="flex items-center my-6 w-full">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="px-4 text-gray-500 text-sm">ou</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <!-- Social Login Buttons -->
        <div class="space-y-3">
            <a
                href="{{ route('social.redirect', ['provider' => 'google']) }}"
                class="w-full flex items-center justify-center gap-3 border border-gray-300 px-4 py-2 rounded-lg bg-white hover:bg-gray-100 transition text-gray-700 font-medium"
            >
                <img src="https://www.google.com/favicon.ico" class="w-5 h-5" alt="">
                Entrar com Google
            </a>

            <a
                href="{{ route('social.redirect', ['provider' => 'facebook']) }}"
                class="w-full flex items-center justify-center gap-3 border border-gray-300 px-4 py-2 rounded-lg bg-white hover:bg-gray-100 transition text-gray-700 font-medium"
            >
                <img src="https://www.facebook.com/favicon.ico" class="w-5 h-5" alt="">
                Entrar com Facebook
            </a>
        </div>
    </form>
</x-guest-layout>
