<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>{{ Config::get('app.name') }}</title>

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>

<body
    class="selection:bg-base-dark selection:text-base-light dark:selection:bg-base-light dark:selection:text-base-dark">
    <div class="container mx-auto">
        @include('partials.header')

        <div class="relative min-h-screen p-6 pb-20 md:p-8">
            <div class="w-full flex-shrink-0">
                <div class="mb-8">
                    <h2 class="mb-4 text-5xl font-bold">Settings</h2>
                    <a
                        href="{{ route('dashboard') }}"
                        class="transition-all hover:text-accent-medium"
                    >Back to Dashboard</a>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-[250px_1fr]">
                <nav class="flex flex-row gap-2 overflow-auto lg:flex-col">
                    @can('manage-bookmarks')
                        <x-settings-link route="settings.bookmarks.list">Bookmarks</x-settings-link>
                    @endcan
                    @can('manage-users')
                        <x-settings-link route="settings.users.list">Users</x-settings-link>
                    @endcan
                    @can('manage-teams')
                        <x-settings-link route="settings.teams.list">Teams</x-settings-link>
                    @endcan
                    @can('manage-whitelist-access')
                        <x-settings-link route="settings.whitelist.list">Whitelist</x-settings-link>
                    @endcan
                </nav>

                <div>
                    @include('partials.alert')

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/app.js')
</body>

</html>
