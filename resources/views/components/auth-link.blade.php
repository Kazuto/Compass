<a href="{{ $redirectRoute }}"
   class="flex justify-between font-semibold text-[var(--color-primary)] py-3 px-4 bg-[var(--color-background)] dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-[var(--color-accent)]">
    <span class="flex">
        {{ svg('fab-' .  $provider, 'w-5 mr-4 text-[var(--color-primary)]') }}
        {{ Str::title($provider) }}
    </span>
</a>
