<button
    type="button"
    id="button-{{ $id }}"
    data-toggle="modal"
    data-target="modal-{{ $id }}"
    @class([
        'py-2 px-3 rounded-lg bg-[var(--color-accent)]',
        'bg-red-600' => $buttonType === 'danger'
])
>
    {{ $buttonText }}
</button>

<dialog id="modal-{{ $id }}" class="w-full max-w-2xl bg-[var(--color-background)] rounded-lg shadow-lg">
    <div class="flex justify-between p-4 text-[var(--color-text)] text-2xl font-bold">
        <h4>{{ $title }}</h4>
        <button data-action="close" class="inline-block w-6 h-6 rounded-lg">&times;</button>
    </div>

    <div class="p-4">
        {{ $slot }}
    </div>

</dialog>

