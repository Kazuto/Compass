<a href="{{ $href }}"
    @class([
        'inline-block py-2 px-3 rounded-lg bg-[var(--color-accent)] last:ml-2',
        'bg-yellow-600' => $type === 'warning',
        'bg-red-600' => $type === 'danger'
])
>
    {{ $slot }}
</a>
