<x-card class="p-4">
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        <x-text-input id="username" name="username" />
        <x-text-input id="password" name="password" type="password" />
        <x-button type="submit" class="block w-full mt-6">Login</x-button>
    </form>
</x-card>
