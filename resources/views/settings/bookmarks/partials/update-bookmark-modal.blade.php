<x-modal title="Update Bookmark" id="update-bookmark-{{ $bookmark->uuid }}" class="text-left">
    <x-slot name="button" icon>
        @svg('fas-edit', ['class' => 'h-3 w-3'])
    </x-slot>

    <form action="{{ route('settings.bookmarks.update', ['bookmark' => $bookmark]) }}" method="POST">
        @csrf
        @method('PATCH')
        <x-text-input name="name" id="name" label="Name" :value="$bookmark->name"/>
        <x-text-input name="url" id="url" label="URL" type="url" :value="$bookmark->url"/>
        <div class="mb-4">
            <x-text-input name="icon" id="icon" label="Icon" class="!mb-0 icon-font" :value="$bookmark->icon"/>
            <small class="text-[var(--color-text)]">
                Please see <a href="https://blade-ui-kit.com/blade-icons?set=9#search"
                                        class="text-[var(--color-accent)]"
                                        target="_blank">Blade UI Icons</a>.
                (FontAwesome, Phosphor or Simple Icons)
            </small>
        </div>

        <x-text-input name="order" id="order" label="Order" type="number" :value="$bookmark->order"/>
        <x-select-input
            name="bookmark_group_id"
            id="bookmark_group_id"
            label="Bookmark Group"
            :selection="$bookmark->bookmark_group_id"
            :options="$bookmarkGroups"
            option-label="name"
            option-value="id"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
