<x-modal title="Edit Bookmark Group">
    <x-slot name="button">
        Edit Group
    </x-slot>

    <form action="{{ route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]) }}" method="POST">
        @csrf
        @method('PATCH')
        <x-text-input name="name" id="name" label="Name" :value="old('name', $bookmarkGroup->name)" />

        <p class="text-[var(--color-text)]">Restriction</p>
        <small class="block text-white/70 mb-2">Only these teams will have access to the bookmarks</small>
        <div class="mb-4 text-[var(--color-text)]">
            @foreach(App\Models\Team::all() as $team)
                <x-toggle-switch
                    id="team_{{$team->id}}"
                    name="team_ids[{{$team->id}}]"
                    label="{{ $team->name }}"
                    value="{{ $bookmarkGroup->teams->contains(fn (\App\Models\Team $related) => $related->id === $team->id) }}"
                />
            @endforeach
        </div>


        <x-button>Save</x-button>
    </form>
</x-modal>
