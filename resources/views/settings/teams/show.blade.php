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

        <h4 class="mb-4 text-2xl font-bold">
            Users
        </h4>

        <div class="overflow-auto">
            <table class="mb-6 w-full">
                <thead class="bg-base-dark/10 dark:bg-base-light/10">
                    <tr class="text-left">
                        <th class="rounded-l p-2">Name</th>
                        <th class="p-2">E-Mail</th>
                        <th
                            class="rounded-r p-2"
                            style="width: 128px"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($team->users as $user)
                        <tr
                            class="border-b border-black/10 last:border-transparent dark:border-white/10 dark:last:border-transparent">
                            <td class="px-2 py-3 text-left">{{ $user->name }}</td>
                            <td class="px-2 py-3 text-left">{{ $user->email }}</td>
                            <td class="px-2 py-3 text-right">
                                @include('settings.teams.partials.remove-user-modal', [
                                    'team' => $team,
                                    'user' => $user,
                                ])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="999"
                                class="px-2 pt-4 text-center text-xl text-neutral-400"
                            >No users added yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <h4 class="mb-4 text-2xl font-bold">
                Bookmark groups
            </h4>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
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
