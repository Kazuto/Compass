<div>
    <h3 class="text-[var(--color-accent)] font-bold uppercase tracking-wide">
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
