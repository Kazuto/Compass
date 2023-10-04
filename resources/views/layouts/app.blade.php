<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ Config::get('app.name') }}</title>

    <!-- Styles -->
    <style>
        :root {
            --color-text: {{ config('theme.colors.text') }};
            --color-accent: {{ config('theme.colors.accent') }};
            --color-background: {{ config('theme.colors.background') }};
        }
    </style>
    @vite('resources/css/app.css')
</head>
<body class="antialiased selection:bg-indigo-500 selection:text-white">
<div class="container mx-auto">
    @include('partials.header')

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen px-8">
        @yield('content')
    </div>
</div>
</body>
</html>