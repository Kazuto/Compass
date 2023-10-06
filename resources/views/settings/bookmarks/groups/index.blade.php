@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-3xl mb-4 font-black">Bookmarks</h3>

            <div>
                @include('settings.bookmarks.partials.create-bookmark-modal')
                @include('settings.bookmarks.partials.create-bookmark-group-modal')
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($bookmarkGroups as $bookmarkGroup)
                <x-bookmark.group-card :bookmark-group="$bookmarkGroup"></x-bookmark.group-card>
            @endforeach
        </div>
    </div>
@endsection
