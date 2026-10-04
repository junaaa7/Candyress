@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-2xl ps-3 pe-4 py-2 text-start text-base font-bold text-brand-600 bg-brand-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-300 transition duration-150 ease-in-out'
            : 'block w-full rounded-2xl ps-3 pe-4 py-2 text-start text-base font-semibold text-brand-900 hover:text-brand-600 hover:bg-brand-50 focus:outline-none focus:bg-brand-50 focus:text-brand-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
