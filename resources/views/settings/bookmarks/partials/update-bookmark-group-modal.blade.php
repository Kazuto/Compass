<x-modal title="Edit Bookmark Group">
    <x-slot name="button">
        Edit Group
    </x-slot>

    <form action="{{ route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]) }}" method="POST">
        @csrf
        @method('PATCH')
        <x-text-input name="name" id="name" label="Name" :value="$bookmarkGroup->name" />

        <x-button>Save</x-button>
    </form>
</x-modal>
