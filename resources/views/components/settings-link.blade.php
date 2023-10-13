<a
    href="{{ route($route) }}"
    @class([
        'transition-all hover:bg-[var(--color-accent)] hover:text-white rounded-lg py-2 px-3 border border-transparent',
        '!border-[var(--color-accent)] text-[var(--color-accent)] ' =>  $isActive()
    ])
>
    {{ $slot }}
</a>
