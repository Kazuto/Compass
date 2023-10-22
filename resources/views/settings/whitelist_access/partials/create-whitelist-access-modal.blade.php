<x-modal title="Create Whitelist">
    <x-slot name="button">
        Create Entry
    </x-slot>

    <form
        action="{{ route('settings.whitelist.store') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            name="email"
            id="email"
            label="Email"
            type="email"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
