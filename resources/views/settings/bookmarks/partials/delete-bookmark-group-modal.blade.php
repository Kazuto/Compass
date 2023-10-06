<x-modal title="Delete Bookmark Group">
    <x-slot name="button" danger>
        Delete Group
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-4">
        Are you sure to delete <span class="text-red-500">{{ $bookmarkGroup->name }}</span>?
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
