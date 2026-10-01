@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-brand-300 text-sm font-bold leading-5 text-brand-600 focus:outline-none focus:border-brand-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-mauve hover:text-brand-600 hover:border-brand-200 focus:outline-none focus:text-brand-600 focus:border-brand-200 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>