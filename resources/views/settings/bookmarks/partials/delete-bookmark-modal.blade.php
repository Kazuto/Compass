<x-modal title="Delete Bookmark" id="delete-bookmark-{{ $bookmark->uuid }}" class="text-left">
    <x-slot name="button" icon>
        <span class="icon">󰩹</span>
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-8">
        Are you sure to delete this bookmark?
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
