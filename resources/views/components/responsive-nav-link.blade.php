@props(['active' => false])

@php
$classes = ($active)
    ? 'py-2 font-medium transition hover:text-sky-900'
    : 'py-2 font-medium transition hover:text-sky-900';
@endphp

<a {{ $attributes->merge(['class' => $classes . 'block']) }}>
    {{ $slot }}
</a>