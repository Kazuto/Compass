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

        <div class="overflow-scroll">
            <table class="mb-6 w-full">
                <thead class="bg-base-dark/10 dark:bg-base-light/10">
                    <tr class="text-left">
                        <th class="rounded-l p-2">#</th>
                        <th class="p-2">E-Mail</th>
                        <th class="p-2">Active</th>
                        <th class="min-w-[112px] rounded-r p-2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($whitelistAccess as $access)
                        <tr
                            class="border-b border-black/10 last:border-transparent dark:border-white/10 dark:last:border-transparent">
                            <td class="px-2 py-3 text-left">{{ $access->id }}</td>
                            <td class="px-2 py-3 text-left">{{ $access->email }}</td>
                            <td class="px-2 py-3 text-left">
                                @if ($access->is_active)
                                    @svg('far-check-circle', ['class' => 'h-4 w-4 text-green-600'])
                                @else
                                    @svg('far-times-circle', ['class' => 'h-4 w-4 text-red-600'])
                                @endif
                            </td>
                            <td class="px-2 py-3 text-right">
                                @include(
                                    'settings.whitelist_access.partials.delete-whitelist-access-modal',
                                    [
                                        'whitelistAccess' => $access,
                                    ]
                                )
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
