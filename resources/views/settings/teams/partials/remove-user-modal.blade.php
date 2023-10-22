<x-modal
    title="Remove User"
    id="remove-user-{{ $user->id }}"
    class="text-left"
>
    <x-slot
        name="button"
        icon
    >
        @svg('fas-trash', ['class' => 'h-3 w-3'])
    </x-slot>

    <p class="mb-4 text-lg">
        Are you sure to remove <span class="text-red-500">{{ $user->name }}</span>?
    </p>
    <form
        action="{{ route('settings.teams.remove-user', ['team' => $team, 'user' => $user]) }}"
        method="POST"
        class="inline"
    >
        @csrf
        <input
            type="hidden"
            name="user_id"
            value="{{ $user->id }}"
        >
        <x-button danger>Confirm</x-button>
    </form>
</x-modal>
