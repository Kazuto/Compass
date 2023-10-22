<div {{ $attributes->merge(['class' => 'mb-4']) }}>
    <label
        id="label-{{ $id }}"
        for="{{ $id }}"
        class="mb-2 block"
        aria-label="{{ $label }}"
    >{{ $label }}</label>
    <input
        type="{{ $type }}"
        id="{{ $id }}"
        name="{{ $name }}"
        aria-labelledby="label-{{ $name }}"
        class="duration-250 w-full rounded-lg border border-gray-300 bg-base-dark/[.025] px-3 py-2 text-base-dark transition-all focus:outline focus:outline-2 focus:outline-accent-medium dark:border-black/[.15] dark:bg-black/[.075] dark:text-base-light dark:ring-1 dark:ring-inset dark:ring-base-light/[.075] dark:ring-black/5"
        value="{{ $value }}"
    />
</div>
