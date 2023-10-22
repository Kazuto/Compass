<button
    type="{{ $type }}"
    {{ $attributes->class([
        'rounded-lg bg-accent-medium font-semibold text-white uppercase tracking-wider mt-4 py-2 px-4',
        'bg-red-600' => $attributes->has('danger'),
    ]) }}
>

    {{ $slot }}
</button>
