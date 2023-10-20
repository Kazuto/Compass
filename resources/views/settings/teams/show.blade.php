@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Teams: <span class="text-accent-medium">{{ $team->name }}</span>
            </x-slot>
            <div>
                @include('settings.teams.partials.add-user-modal', ['team' => $team, 'users' => $users])
                @include('settings.teams.partials.delete-team-modal', ['team' => $team])
            </div>
        </x-settings.action-title>

        <div>
            <h4 class="font-bold mb-4 text-2xl">
                Users
            </h4>
            <table class="w-full mb-6">
                <thead class="bg-base-dark/10 dark:bg-base-light/10">
                <tr class="text-left">
                    <th class="p-2 rounded-l">Name</th>
                    <th class="p-2">E-Mail</th>
                    <th class="p-2 rounded-r"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($team->users as $user)
                    <tr class="border-b border-black/10 dark:border-white/10 last:border-transparent">
                        <td class="text-left py-3 px-2">{{ $user->name }}</td>
                        <td class="text-left py-3 px-2">{{ $user->email }}</td>
                        <td class="text-right py-3 px-2">
                            @include('settings.teams.partials.remove-user-modal', ['team' => $team, 'user' => $user])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="999" class="text-center pt-4 px-2 text-xl text-neutral-400">No users added yet</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <h4 class="font-bold mb-4 text-2xl">
                Bookmark groups
            </h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                @forelse($team->bookmarkGroups as $bookmarkGroup)
                    <x-bookmark.group-card :bookmark-group="$bookmarkGroup"></x-bookmark.group-card>
                @empty
                    <span class="col-span-full text-neutral-400">
                        This team has no access to restricted bookmark.
                    </span>
                @endforelse
            </div>
        </div>
    </div>
@endsection
