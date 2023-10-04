@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-2xl mb-4 font-black">Bookmarks</h3>
            <a href="{{ route('settings.bookmarks.groups.create') }}" class="text-sm py-1.5 px-2 rounded-lg bg-[var(--color-accent)]">Add Group</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($bookmarkGroups as $group)
                <a href="{{ route('settings.bookmarks.groups.show', ['bookmarkGroup' => $group]) }}"
                   class="rounded-lg p-3 shadow border border-white/5 bg-gradient-to-bl from-white/5 to-transparent">
                    <h4 class="text-lg font-bold mb-2">
                        {{ $group->name }}
                    </h4>

                    <ol class="text-neutral-300">
                        @forelse($group->bookmarks->take(3) as $bookmark)
                            <li class="text-sm">{{ $bookmark->name }}</li>
                        @empty
                            <li>No bookmarks yet</li>
                        @endforelse
                        @if($group->bookmarks->count() > 3)
                            <li class="text-sm">...</li>
                        @endif
                    </ol>
                </a>
            @endforeach
        </div>

    </div>
@endsection
