@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Bookmarks: <span class="text-accent-medium">{{ $bookmarkGroup->name }}</span>
            </x-slot>

            <div>
                @include('settings.bookmarks.partials.update-bookmark-group-modal', [
                    'bookmarkGroup' => $bookmarkGroup,
                ])

                @include('settings.bookmarks.partials.delete-bookmark-group-modal', [
                    'bookmarkGroup' => $bookmarkGroup,
                ])
            </div>
        </x-settings.action-title>

        <div class="overflow-auto">
            <table class="mb-6 w-full">
                <thead class="bg-base-dark/10 dark:bg-base-light/10">
                    <tr class="text-left">
                        <th class="rounded-l p-2">Name</th>
                        <th class="p-2">URL</th>
                        <th class="p-2">Icon</th>
                        <th class="p-2">Order</th>
                        <th
                            class="rounded-r p-2"
                            style="min-width: 128px"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookmarkGroup->bookmarks as $bookmark)
                        <tr
                            class="border-b border-black/10 last:border-transparent dark:border-white/10 dark:last:border-transparent">
                            <td class="px-2 py-3 text-left">{{ $bookmark->name }}</td>
                            <td class="whitespace-nowrap px-2 py-3 text-left">
                                <a
                                    href="{{ $bookmark->url }}"
                                    target="_blank"
                                    class="flex items-center gap-2 text-accent-medium transition-all hover:text-accent-dark dark:hover:text-accent-light"
                                >
                                    {{ \Illuminate\Support\Str::limit($bookmark->url, 65) }}
                                </a>
                            </td>
                            <td class="px-2 py-3 text-left">
                                {{ $bookmark->svgIcon('h-4') }}
                            </td>
                            <td class="px-2 py-3 text-left">{{ $bookmark->order }}</td>
                            <td class="px-2 py-3 text-right">
                                @include('settings.bookmarks.partials.update-bookmark-modal', [
                                    'bookmark' => $bookmark,
                                    'bookmarkGroups' => $bookmarkGroups,
                                ])

                                @include('settings.bookmarks.partials.delete-bookmark-modal', [
                                    'bookmark' => $bookmark,
                                ])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            <h4 class="mb-4 text-2xl font-bold">
                Restriction
            </h4>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                @forelse ($bookmarkGroup->teams as $team)
                    <x-team.card :team="$team" />
                @empty
                    <span class="col-span-full text-neutral-500 dark:text-neutral-400">
                        Not assigned to any specific team. Accessible to every user.
                    </span>
                @endforelse
            </div>

        </div>

    </div>
@endsection
