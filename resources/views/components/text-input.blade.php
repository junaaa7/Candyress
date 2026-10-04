@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'cute-input disabled:cursor-not-allowed disabled:opacity-60']) }}>
