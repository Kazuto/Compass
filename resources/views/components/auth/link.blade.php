<a href="{{ $redirectRoute }}"
   @if($disabled)
       tabindex="-1"
   @endif
   @class([
    'flex justify-between font-semibold text-[var(--color-text)] py-3 px-4 bg-[var(--color-background)] dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex transition-all duration-250 focus:outline focus:outline-2 focus:outline-[var(--color-accent)] ',
    'pointer-events-none opacity-50' => $disabled,
])>
    <span class="flex justify-center items-center">
        <span class="icon mr-4 text-2xl">{{ $icon }}</span>
        {{ Str::title($provider) }} @if($disabled) (Disabled) @endif
    </span>
</a>
