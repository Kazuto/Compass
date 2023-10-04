@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-2xl mb-4 font-black">
                Create Bookmark Group
            </h3>

        </div>

        <form action="{{ route('settings.bookmarks.groups.store') }}" method="POST">
            @csrf
            <x-text-input name="name" id="name" label="Name:"></x-text-input>

            <button type="submit" class="rounded-lg bg-[var(--color-accent)] py-2 px-4">Save</button>
        </form>

    </div>
@endsection
