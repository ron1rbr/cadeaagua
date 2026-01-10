<x-guest-layout>
    <div class="mb-4 text-sm text-sky-700 leading-relaxed">
        Esqueceu sua senha? Sem problemas. Basta informar seu endereço de e-mail e nós enviaremos um link para redefinição de senha, permitindo que você escolha uma nova.
    </div>

    <!-- Session Status -->
    <x-auth-session-status
        class="mb-4 text-teal-700 font-medium"
        :status="session('status')"
    />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
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
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end pt-4">
            <x-primary-button>
                Enviar link de redefinição de senha
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
