@props(['button'])
<button
    type="button"
    id="button-{{ $id }}"
    data-toggle="modal"
    data-target="modal-{{ $id }}"
    {{ $button->attributes->class([
        'py-2 px-3 rounded-lg bg-base-dark/10 hover:bg-base-dark/20 dark:bg-white/10 dark:hover:bg-white/20 transition-all',
        'py-0 px-0 h-9 aspect-square' => $button->attributes->has('icon'),
        'bg-primary-base' => $button->attributes->has('accent'),
        'text-white bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500' => $button->attributes->has(
            'danger',
        ),
    ]) }}
>
    {{ $button }}
</button>

<dialog
    id="modal-{{ $id }}"
    {{ $attributes->class([
        'w-full max-w-2xl bg-base-light dark:bg-base-dark rounded-lg shadow-lg text-base-dark dark:text-white',
    ]) }}
>
    <div class="flex justify-between p-4 text-2xl font-bold">
        <h4>{{ $title }}</h4>
        <button
            data-action="close"
            class="inline-flex h-10 w-10 items-center justify-center rounded-lg transition-all hover:bg-white/10"
        >
            &times;
        </button>
    </div>

    <div class="p-4">
        {{ $slot }}
    </div>
</dialog>
