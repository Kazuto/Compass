<div class="mb-4 flex gap-4">
    <input
        type="color"
        id="{{ $id }}"
        name="{{ $name }}"
        aria-labelledby="label-{{ $name }}"
        data-preview="#preview-{{ $colorClass }}"
        class="focus:outline focus:outline-2 focus:outline-accent-medium"
        value="{{ $value }}"
    />

    <label
        id="label-{{ $id }}"
        for="{{ $id }}"
        class="mb-2 flex grow items-center justify-between whitespace-nowrap hover:cursor-pointer"
        aria-label="{{ $label }}"
    >
        {{ $label }}
        <span
            id="preview-{{ $colorClass }}"
            class="text-right text-sm text-neutral-500 dark:text-neutral-200"
        >
            {{ $value }}
        </span>
    </label>
</div>
