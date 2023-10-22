@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Teams
            </x-slot>

            <div>
                @include('settings.teams.partials.create-team-modal')
            </div>
        </x-settings.action-title>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
            @foreach ($teams as $team)
                <x-team.card :team="$team" />
            @endforeach
        </div>

    </div>
@endsection
