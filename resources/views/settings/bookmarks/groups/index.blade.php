@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Bookmarks
            </x-slot>

            <div>
                @include('settings.bookmarks.partials.create-bookmark-modal')
                @include('settings.bookmarks.partials.create-bookmark-group-modal')
            </div>
        </x-settings.action-title>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($bookmarkGroups as $bookmarkGroup)
                <x-bookmark.group-card :bookmark-group="$bookmarkGroup"></x-bookmark.group-card>
            @endforeach
        </div>
    </div>
@endsection
