@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Bookmarks: <span class="text-[var(--color-accent)]">{{ $bookmarkGroup->name }}</span>
            </x-slot>

            <div>
                @include('settings.bookmarks.partials.update-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])

                @include('settings.bookmarks.partials.delete-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])
            </div>
        </x-settings.action-title>

        <table class="w-full mb-6">
            <thead class="bg-white/20">
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
                <tr class="border-b border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $bookmark->name }}</td>
                    <td class="text-left py-3 px-2">{{ $bookmark->url }}</td>
                    <td class="text-left py-3 px-2"><span class="icon">{{ $bookmark->icon }}</span></td>
                    <td class="text-left py-3 px-2">{{ $bookmark->order }}</td>
                    <td class="text-right py-3 px-2">
                        @include('settings.bookmarks.partials.update-bookmark-modal', ['bookmark' => $bookmark, 'bookmarkGroups' => $bookmarkGroups])

                        @include('settings.bookmarks.partials.delete-bookmark-modal', ['bookmark' => $bookmark])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
