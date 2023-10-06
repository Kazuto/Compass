<a href="{{ route('settings.teams.show', ['team' => $team]) }}">
    <x-card>
        <h4 class="text-lg font-bold mb-2">
            {{ $team->name }}
        </h4>

        <ol class="text-neutral-400">
            @forelse($team->users as $user)
                <li class="text-sm">{{ $user->name }}</li>
            @empty
                <li>No users added yet</li>
            @endforelse
        </ol>
    </x-card>
</a>
