@if (session()->has('success') || $errors->has('business'))
    @php
        $isSuccess = session()->has('success');
        $message = $isSuccess ? session('success') : $errors->first('business');
        $timeout = $isSuccess ? 6000 : 9000;
        $styles = $isSuccess
            ? 'bg-green-50 border-green-200 text-green-700'
            : 'bg-red-50 border-red-200 text-red-700';
        $iconColor = $isSuccess ? 'text-green-600' : 'text-red-600';
        $buttonColor = $isSuccess ? 'text-green-600 hover:text-green-800' : 'text-red-600 hover:text-red-800';
    @endphp

    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, {{ $timeout }})"
        x-show="show"
        x-transition.opacity.duration.300ms
        x-cloak
        role="alert"
        aria-live="polite"
        class="p-4 sm:p-6 rounded-lg border flex items-center justify-between gap-3 {{ $styles }}"
    >
        <div class="flex items-center gap-3">
            @if ($isSuccess)
                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @else
                <svg class="w-5 h-5 {{ $iconColor }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.29 3.86l-8.5 14.72A1 1 0 002.65 20h18.7a1 1 0 00.86-1.42l-8.5-14.72a1 1 0 00-1.72 0z"/>
                </svg>
            @endif

            <span class="text-sm font-medium">
                {{ $message }}
            </span>
        </div>

        <button
            type="button"
            @click="show = false"
            aria-label="Fechar alerta"
            class="{{ $buttonColor }}"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
@endif
