@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-3xl mb-4 font-black">Teams</h3>

            <div>
                @include('settings.teams.partials.create-team-modal')
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($teams as $team)
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
            @endforeach
        </div>

    </div>
@endsection
