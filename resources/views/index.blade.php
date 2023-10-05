@extends('layouts.app')

@section('content')
    <div class="w-full">
        <h2 class="block text-2xl mb-4 font-black">
            Bookmarks
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($bookmarkGroups as $group)
                <x-bookmark.group :bookmark-group="$group"/>
            @endforeach
        </div>
    </div>
@endsection
