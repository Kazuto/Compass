<x-modal title="Delete Bookmark" class="text-left">
    <x-slot name="button" icon>
        <span class="icon">󰩹</span>
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-8">
        Are you sure to delete this team?
    </p>
    <form
        action="{{ route('settings.teams.delete', ['team' => $team]) }}"
        method="POST"
        class="inline"
    >
        @csrf
        @method('DELETE')
        <x-button danger>Confirm</x-button>
    </form>
</x-modal>
