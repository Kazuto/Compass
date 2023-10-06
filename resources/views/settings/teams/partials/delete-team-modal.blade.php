<x-modal title="Delete Bookmark" class="text-left">
    <x-slot name="button">
        Delete Team
    </x-slot>

    <p class="text-lg text-[var(--color-text)] mb-4">
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
