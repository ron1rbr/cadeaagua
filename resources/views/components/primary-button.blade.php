<button {{ $attributes->merge(['type' => 'submit', 'class' => 'ms-4 bg-gradient-to-r from-sky-600 to-teal-500 text-white px-5 py-2 rounded-lg shadow-md hover:opacity-90 transition']) }}>
    {{ $slot }}
</button>
