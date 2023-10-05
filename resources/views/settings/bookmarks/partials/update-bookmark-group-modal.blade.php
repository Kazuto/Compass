<x-modal
    id="edit-bookmark-group"
    title="Edit Bookmark Group"
    button-text="Edit Group"
>
    <form action="{{ route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]) }}" method="POST">
        @csrf
        @method('PATCH')
        <x-text-input name="name" id="name" label="Name" value="{{ $bookmarkGroup->name }}" />

        <button type="submit" class="rounded-lg bg-[var(--color-accent)] text-[var(--color-text)] py-2 px-4">Save</button>
    </form>
</x-modal>
