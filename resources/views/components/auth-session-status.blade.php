@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-2xl border-2 border-dashed border-emerald-300 bg-mint px-4 py-3 text-sm font-bold text-emerald-700', 'role' => 'status']) }}>
        {{ $status }}
    </div>
@endif