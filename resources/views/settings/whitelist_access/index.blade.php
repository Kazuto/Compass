@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Whitelist
            </x-slot>

            <div>
                @include('settings.whitelist_access.partials.create-whitelist-access-modal')
            </div>
        </x-settings.action-title>

        <table class="w-full mb-6">
            <thead class="bg-white/20">
            <tr class="text-left">
                <th class="p-2 rounded-l">#</th>
                <th class="p-2">E-Mail</th>
                <th class="p-2">Active</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($whitelistAccess as $access)
                <tr class="border-b border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $access->id }}</td>
                    <td class="text-left py-3 px-2">{{ $access->email }}</td>
                    <td class="text-left py-3 px-2">
                        @if($access->is_active)
                            @svg('far-check-circle', ['class' => 'h-4 w-4 text-green-600'])
                        @else
                            @svg('far-times-circle', ['class' => 'h-4 w-4 text-red-600'])
                        @endif
                    </td>
                    <td class="text-right py-3 px-2">
                        @include('settings.whitelist_access.partials.delete-whitelist-access-modal', ['whitelistAccess' => $access])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
