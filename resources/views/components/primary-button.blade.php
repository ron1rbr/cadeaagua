@php
    $classes = 'bg-gradient-to-r from-sky-600 to-teal-500 text-white px-5 py-2 rounded-lg shadow-md hover:opacity-90 transition
                disabled:from-gray-400 disabled:to-gray-400 disabled:cursor-not-allowed disabled:opacity-60';
@endphp

<button {{ $attributes->merge(['type' => 'submit', 'class' => $classes]) }}>
    {{ $slot }}
</button>
