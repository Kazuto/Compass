<x-modal title="Create Bookmark">
    <x-slot name="button">
        Create Bookmark
    </x-slot>

    <form action="{{ route('settings.bookmarks.store') }}" method="POST">
        @csrf
        <x-text-input name="name" id="name" label="Name"/>
        <x-text-input name="url" id="url" label="URL" type="url"/>
        <div class="mb-4">
            <x-text-input name="icon" id="icon" label="Icon" class="!mb-0"/>
            <small class="text-[var(--color-text)]">For icons please see <a href="https://blade-ui-kit.com/blade-icons?set=9#search"
                                                                            class="text-[var(--color-accent)]"
                                                                            target="_blank">FontAwesome or Phosphor Icons</a></small>
        </div>

        <x-select-input
            name="bookmark_group_id"
            id="bookmark_group_id"
            label="Bookmark Group"
            :options="$bookmarkGroups"
            option-label="name"
            option-value="id"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
