@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Bookmarks: <span class="text-accent-medium">{{ $bookmarkGroup->name }}</span>
            </x-slot>

            <div>
                @include('settings.bookmarks.partials.update-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])

                @include('settings.bookmarks.partials.delete-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])
            </div>
        </x-settings.action-title>

        <table class="w-full mb-6">
            <thead class="bg-base-dark/10 dark:bg-base-light/10">
            <tr class="text-left">
                <th class="p-2 rounded-l">Name</th>
                <th class="p-2">URL</th>
                <th class="p-2">Icon</th>
                <th class="p-2">Order</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bookmarkGroup->bookmarks as $bookmark)
                <tr class="border-b border-black/10 dark:border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2 w-2/12">{{ $bookmark->name }}</td>
                    <td class="text-left py-3 px-2 w-6/12 whitespace-nowrap">
                        <a href="{{ $bookmark->url }}" target="_blank" class="flex items-center gap-2 text-accent-medium transition-all hover:text-accent-dark dark:hover:text-accent-light">
                            {{ \Illuminate\Support\Str::limit($bookmark->url, 65) }}
                        </a>
                    </td>
                    <td class="text-left py-3 px-2 w-1/12">
                        {{ $bookmark->svgIcon('h-4') }}
                    </td>
                    <td class="text-left py-3 px-2 w-1/12">{{ $bookmark->order }}</td>
                    <td class="text-right py-3 px-2 w-1/12">
                        @include('settings.bookmarks.partials.update-bookmark-modal', ['bookmark' => $bookmark, 'bookmarkGroups' => $bookmarkGroups])

                        @include('settings.bookmarks.partials.delete-bookmark-modal', ['bookmark' => $bookmark])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div>
            <h4 class="font-bold mb-4 text-2xl">
                Restriction
            </h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
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
