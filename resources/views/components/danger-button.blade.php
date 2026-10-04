<button {{ $attributes->merge(['type' => 'submit', 'class' => 'cute-btn bg-rose-500 px-6 py-2.5 text-sm text-white shadow-[0_5px_0_theme(colors.rose.700)] hover:shadow-[0_3px_0_theme(colors.rose.700)] focus-visible:outline-rose-700 disabled:opacity-40']) }}>
    {{ $slot }}
</button>
