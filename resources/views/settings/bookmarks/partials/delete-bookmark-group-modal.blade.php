<x-modal
    id="delete-bookmark-group"
    title="Delete Bookmark Group"
    button-text="Delete Group"
    button-type="danger"
>
    <p class="text-lg text-[var(--color-text)] mb-8">
        Are you sure to delete this bookmark group?
    </p>
    <form
        action="{{ route('settings.bookmarks.groups.delete', ['bookmarkGroup' => $bookmarkGroup]) }}"
        method="POST"
        class="inline"
    >
        @csrf
        @method('DELETE')
        <button type="submit" class="py-2 px-3 rounded-lg bg-red-600 text-[var(--color-text)]">Confirm</button>
    </form>
</x-modal>
