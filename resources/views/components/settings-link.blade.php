<a
    href="{{ route($route) }}"
    @class([
        'transition-all hover:bg-accent-medium hover:text-white rounded-lg py-2 px-3 border border-transparent',
        '!border-accent-medium text-accent-medium ' => $isActive(),
    ])
>
    {{ $slot }}
</a>
