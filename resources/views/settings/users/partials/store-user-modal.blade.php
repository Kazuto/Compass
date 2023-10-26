<x-modal
    title="Create user"
    id="create-user"
    class="text-left"
>
    <x-slot name="button">
        Create User
    </x-slot>

    <form
        action="{{ route('settings.users.store') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            name="name"
            id="name"
            label="Name"
            :value="old('name')"
        />
        <x-text-input
            name="username"
            id="username"
            label="Username"
            :value="old('username')"
        />
        <x-text-input
            name="email"
            id="email"
            label="E-Mail"
            type="email"
            :value="old('email')"
        />
        <x-text-input
            class="!mb-1"
            name="password"
            id="password"
            label="Password"
            type="password"
            required
        />
        <span class="mb-4 block text-xs">Minimum 8 characters</span>

        <x-text-input
            name="confirm_password"
            id="confirm_password"
            label="Confirm password"
            type="password"
            required
        />

        <x-toggle-switch
            name="is_admin"
            id="is_admin"
            label="Is Administrator?"
        />

        <x-button>Save</x-button>
    </form>
</x-modal>
