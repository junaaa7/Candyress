<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cute-btn cute-btn-primary px-6 py-2.5 text-sm']) }}>
    {{ $slot }}
</button>
