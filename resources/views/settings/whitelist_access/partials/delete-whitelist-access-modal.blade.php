<x-modal title="Delete Bookmark" id="delete-bookmark-{{ $whitelistAccess->uuid }}" class="text-left">
    <x-slot name="button" icon>
        <span class="icon">󰩹</span>
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-8">
        Are you sure to delete this whitelist entry?
    </p>
    <form
        action="{{ route('settings.whitelist.delete', ['whitelistAccess' => $whitelistAccess]) }}"
        method="POST"
        class="inline"
    >
        @csrf
        @method('DELETE')
        <x-button danger>Confirm</x-button>
    </form>
</x-modal>
