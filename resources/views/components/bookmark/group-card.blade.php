<a href="{{ route('settings.bookmarks.groups.show', ['bookmarkGroup' => $bookmarkGroup]) }}">
    <x-card>
        <h4 class="text-lg font-bold mb-2">
            {{ $bookmarkGroup->name }}
        </h4>

        <ol class="opacity-75">
            @forelse($bookmarkGroup->bookmarks->take(3) as $bookmark)
                <li class="text-sm">{{ $bookmark->name }}</li>
            @empty
                <li>No bookmarks yet</li>
            @endforelse
            @if($bookmarkGroup->bookmarks->count() > 3)
                <li class="text-sm">...</li>
            @endif
        </ol>
    </x-card>
</a>
