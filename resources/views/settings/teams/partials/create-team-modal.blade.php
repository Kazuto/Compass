<x-modal title="Create Team">
    <x-slot name="button">
        Create Team
    </x-slot>

    <form
        action="{{ route('settings.teams.store') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            name="name"
            id="name"
            label="Name"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
