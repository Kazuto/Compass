<x-modal
    id="create-bookmark"
    title="Create Bookmark"
    button-text="Create Bookmark"
>
    <form action="{{ route('settings.bookmarks.store') }}" method="POST">
        @csrf
        <x-text-input name="name" id="name" label="Name" />
        <x-text-input name="url" id="url" label="URL" type="url" />
        <div class="mb-4">
            <x-text-input name="icon" id="icon" label="Icon" class="!mb-0 icon-font" />
            <small class="text-[var(--color-text)]">For icons please see <a href="https://www.nerdfonts.com/cheat-sheet" class="text-[var(--color-accent)]" target="_blank">NF Icons</a></small>
        </div>

        <x-select-input
            name="bookmark_group_id"
            id="bookmark_group_id"
            label="Bookmark Group"
            :options="$bookmarkGroups"
            optionLabel="name"
            optionValue="id"
        />

        <button type="submit" class="rounded-lg bg-[var(--color-accent)] text-[var(--color-text)] py-2 px-4">Save</button>
    </form>
</x-modal>
