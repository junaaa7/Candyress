<button {{ $attributes->merge(['type' => 'button', 'class' => 'cute-btn cute-btn-ghost px-6 py-2.5 text-sm disabled:opacity-40']) }}>
    {{ $slot }}
</button>
