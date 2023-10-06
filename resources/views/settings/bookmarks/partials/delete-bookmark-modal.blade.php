<x-modal title="Delete Bookmark" id="delete-bookmark-{{ $bookmark->uuid }}" class="text-left">
    <x-slot name="button" icon>
        <span class="icon">󰩹</span>
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-4">
        Are you sure to delete <span class="text-red-500">{{ $bookmark->name }}</span>?
    </p>
    <form
        action="{{ route('settings.bookmarks.delete', ['bookmark' => $bookmark]) }}"
        method="POST"
        class="inline"
    >
        @csrf
        @method('DELETE')
        <x-button danger>Confirm</x-button>
    </form>
</x-modal>
