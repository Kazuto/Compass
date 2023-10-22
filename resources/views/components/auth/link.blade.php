<a
    href="{{ $redirectRoute }}"
    @if ($disabled) tabindex="-1" @endif
    @class([
        'flex justify-between font-semibold py-3 px-4 border border-white dark:border-black/30 bg-base-light transition-all hover:bg-white/50 dark:hover:bg-black/10 dark:bg-base-dark dark:ring-1 dark:ring-inset  dark:ring-white/5 rounded-lg shadow-md shadow-gray-500/10 dark:shadow-gray-900/10 flex transition-all duration-250 focus:outline focus:outline-2 focus:outline-accent-medium ',
        'pointer-events-none opacity-50' => $disabled,
    ])
>
    <span class="flex items-center justify-center">
        @svg($icon, ['class' => 'h-6 mr-3'])
        {{ $title }}
    </span>
</a>
