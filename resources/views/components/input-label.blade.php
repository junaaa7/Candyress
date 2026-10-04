@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-bold text-brand-900']) }}>
    {{ $value ?? $slot }}
</label>
