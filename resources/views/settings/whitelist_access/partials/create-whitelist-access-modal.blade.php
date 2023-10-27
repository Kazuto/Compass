<x-modal title="Create Whitelist">
    <x-slot name="button">
        Create Entry
    </x-slot>

    <form
        action="{{ route('settings.whitelist.store') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            name="email"
            id="email"
            label="Email"
            type="email"
        />

        <div>
            <div class="mb-2">

            <h4>Teams</h4>
            <span class="text-xs text-black/50 dark:text-white/50">Teams will be automatically assigned upon user sign up.</span>
            </div>
            @forelse($teams as $id => $name)
                <x-toggle-switch
                    id="team_{{ $id }}"
                    name="team_ids[{{ $id }}]"
                    label="{{ $name }}"
                />
            @empty
                <p class="text-black/50 dark:text-white/50">
                    No teams created yet
                </p>
            @endforelse
        </div>

        <x-button>Save</x-button>
    </form>
</x-modal>
