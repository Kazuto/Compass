<a href="{{ route('settings.teams.show', ['team' => $team]) }}">
    <x-card>
        <h4 class="mb-2 text-lg font-bold">
            {{ $team->name }}
        </h4>

        <ol class="opacity-75">
            @forelse($team->users as $user)
                <li class="text-sm">{{ $user->name }}</li>
            @empty
                <li>No users added yet</li>
            @endforelse
        </ol>
    </x-card>
</a>
