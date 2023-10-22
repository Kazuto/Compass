<x-modal title="Create Bookmark Group">
    <x-slot name="button">
        Create Group
    </x-slot>

    <form
        action="{{ route('settings.bookmarks.groups.store') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            name="name"
            id="name"
            label="Name"
        ></x-text-input>

        <x-button>Save</x-button>
    </form>
</x-modal>
