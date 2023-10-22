<x-card class="p-4">
    <form
        action="{{ route('auth.login') }}"
        method="POST"
    >
        @csrf
        <x-text-input
            id="username"
            name="username"
        />
        <x-text-input
            id="password"
            name="password"
            type="password"
        />
        <x-button
            type="submit"
            class="mt-6 block w-full"
        >Login</x-button>
    </form>
</x-card>
