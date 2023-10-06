<x-modal title="Delete Entry" id="delete-bookmark-{{ $whitelistAccess->uuid }}" class="text-left">
    <x-slot name="button" icon>
        <span class="icon">󰩹</span>
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-4">
        Are you sure to delete the entry for <span class="text-red-500">{{ $whitelistAccess->email }}</span>?
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
