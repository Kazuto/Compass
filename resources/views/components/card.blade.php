<div
    {{ $attributes->merge([
        'class' =>
            'h-full rounded-lg p-3 shadow-md shadow-gray-500/10 dark:shadow-gray-900/10 border border-white dark:border-black/30 bg-base-light dark:bg-base-light/[0.025] dark:ring-1 dark:ring-inset dark:ring-black/5 dark:ring-white/5  text-base-dark dark:text-base-light',
    ]) }}>
    {{ $slot }}
</div>
