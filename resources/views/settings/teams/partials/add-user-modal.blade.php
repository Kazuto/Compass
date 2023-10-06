<x-modal title="Add User">
    <x-slot name="button">
        Add User
    </x-slot>

    <form action="{{ route('settings.teams.add-user', ['team' => $team]) }}" method="POST">
        @csrf
        <x-select-input
            id="user_id"
            name="user_id"
            label="User"
            :options="$users"
            option-label="name"
            option-value="id"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
