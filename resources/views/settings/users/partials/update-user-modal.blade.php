<x-modal title="Update user" id="update-user-{{ $user->uuid }}" class="text-left">
    <x-slot name="button" icon>
        @svg('fas-edit', ['class' => 'h-3 w-3'])
    </x-slot>

    <form action="{{ route('settings.users.update', ['user' => $user]) }}" method="POST">
        @csrf
        @method('PATCH')
        <x-text-input name="name" id="name" label="Name" :value="$user->name"/>
        <x-text-input name="username" id="username" label="Username" :value="$user->username"/>
        <x-text-input name="email" id="email" label="E-Mail" type="email" :value="$user->email"/>

        <x-toggle-switch name="is_admin" id="is_admin-{{ $user->uuid }}" label="Is Administrator?" :value="$user->is_admin">

        </x-toggle-switch>

        <x-button>Save</x-button>
    </form>
</x-modal>
