<x-modal title="Delete Bookmark Group">
    <x-slot name="button" danger>
        Delete Group
    </x-slot>

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
        <x-button danger>Confirm</x-button>
    </form>
</x-modal>
