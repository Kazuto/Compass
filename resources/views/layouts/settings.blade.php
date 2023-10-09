<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Config::get('app.name') }}</title>

    <!-- Styles -->
    <style>
        :root {
            --color-text: {{ config('compass.theme.colors.text') }};
            --color-accent: {{ config('compass.theme.colors.accent') }};
            --color-background: {{ config('compass.theme.colors.background') }};
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white">
<div class="container mx-auto">
    @include('partials.header')

    <div class="relative min-h-screen p-8">
        <div class="w-full flex-shrink-0">

            <div class="mb-8">
                <h2 class="text-5xl font-bold mb-4">Settings</h2>
                <a href="{{route('dashboard')}}" class="transition-all hover:text-[var(--color-accent)]">Back to
                    Dashboard</a>
            </div>
        </div>
        <div class="grid grid-cols-[250px_1fr] gap-8 ">
            <nav class="flex flex-col gap-2">
                <x-settings-link route="settings.bookmarks.list">Bookmarks</x-settings-link>
                <x-settings-link route="settings.whitelist.list">Whitelist</x-settings-link>
                <x-settings-link route="settings.teams.list">Teams</x-settings-link>
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
