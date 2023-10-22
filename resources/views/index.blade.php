@extends('layouts.app')

@section('content')
    <div class="w-full">
        <h2 class="mb-4 block text-2xl font-black">
            Bookmarks
        </h2>

        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @foreach ($bookmarkGroups as $group)
                <x-bookmark.group :bookmark-group="$group" />
            @endforeach
        </div>
    </div>
@endsection
