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
    <style>
        :root {
            --color-text: {{ config('compass.theme.colors.text') }};
            --color-accent: {{ config('compass.theme.colors.accent') }};
            --color-background: {{ config('compass.theme.colors.background') }};
        }
    </style>
    @vite('resources/css/app.css')
</head>

<body
    class="selection:bg-base-dark selection:text-base-light dark:selection:bg-base-light dark:selection:text-base-dark">
    <div class="container mx-auto">

        <div class="relative min-h-screen p-6 pb-20 sm:flex sm:items-center sm:justify-center md:p-8">
            @include('partials.alert')

            @yield('content')
        </div>

        @include('partials.header')
    </div>
</body>

@vite('resources/js/app.js')

</html>
