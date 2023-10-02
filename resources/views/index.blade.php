@extends('layouts.app')

@section('content')
    <div class="w-full">
        <h2 class="block text-2xl mb-4 font-black">Bookmarks</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <x-bookmark.group name="Microsoft Office" />
            <x-bookmark.group name="Amazon" />
            <x-bookmark.group name="Atlassian" />
            <x-bookmark.group name="GitHub" />
            <x-bookmark.group name="Repositories" />
            <x-bookmark.group name="Dev Environments" />
            <x-bookmark.group name="Tools" />
        </div>
    </div>
@endsection
