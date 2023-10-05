<x-modal
    id="create-bookmark-group"
    title="Create Bookmark Group"
    button-text="Create Group"
>
    <form action="{{ route('settings.bookmarks.groups.store') }}" method="POST">
        @csrf
        <x-text-input name="name" id="name" label="Name"></x-text-input>

        <button type="submit" class="rounded-lg bg-[var(--color-accent)] text-[var(--color-text)] py-2 px-4">Save</button>
    </form>
</x-modal>
