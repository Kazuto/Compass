<x-modal
    title="Delete Team"
    class="text-left"
>
    <x-slot
        name="button"
        danger
    >
        Delete Team
    </x-slot>

    <p class="mb-4 text-lg">
        Are you sure to delete <span class="text-red-500">{{ $team->name }}</span>?
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
