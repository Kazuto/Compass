<div>
    <h3 class="font-bold uppercase tracking-wide text-accent-medium">
        {{ $bookmarkGroup->name }}
    </h3>
    <ol>
        @forelse($bookmarkGroup->bookmarks as $bookmark)
            <x-bookmark.item :bookmark="$bookmark" />
        @empty
            <li>No bookmarks yet</li>
        @endforelse
    </ol>
</div>
