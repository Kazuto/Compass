@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                General
            </x-slot>
        </x-settings.action-title>

        <div class="mb-4">
            <h3 class="mb-2 text-2xl font-medium">Application</h3>
            <p>Version: {{ config('compass.version') }}</p>
        </div>

        <h3 class="mb-2 text-2xl font-medium">Theme</h3>
        <form
            action="{{ route('settings.general.rebuild-theme') }}"
            method="POST"
        >
            @csrf

            @if ($colors)
                @include('settings.general.partials.color-group')
            @endif

            <x-button>Rebuild Theme</x-button>
        </form>

    </div>
@endsection
