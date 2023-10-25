@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Users
            </x-slot>

            <div>
                @include('settings.users.partials.store-user-modal')
            </div>
        </x-settings.action-title>

        <div class="overflow-auto">
            <table class="mb-6 w-full">
                <thead class="bg-base-dark/10 dark:bg-base-light/10">
                    <tr class="text-left">
                        <th class="rounded-l p-2">#</th>
                        <th class="p-2">Name</th>
                        <th class="p-2">Username</th>
                        <th class="p-2">E-Mail</th>
                        <th class="p-2">Admin</th>
                        <th class="p-2">Auth Method</th>
                        <th
                            class="rounded-r p-2"
                            style="width: 128px"
                        ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr
                            class="border-b border-black/10 last:border-transparent dark:border-white/10 dark:last:border-transparent">
                            <td class="px-2 py-3 text-left">{{ $user->id }}</td>
                            <td class="px-2 py-3 text-left">{{ $user->name }}</td>
                            <td class="px-2 py-3 text-left">{{ $user->username }}</td>
                            <td class="px-2 py-3 text-left">{{ $user->email }}</td>
                            <td class="px-2 py-3 text-left">
                                @if ($user->is_admin)
                                    @svg('far-check-circle', ['class' => 'h-4 w-4 text-green-600'])
                                @else
                                    @svg('far-times-circle', ['class' => 'h-4 w-4 text-red-600'])
                                @endif
                            </td>
                            <td class="px-2 py-3 text-left">
                                {{ $user->getAuthProviderIcon() }}
                            </td>
                            <td class="px-2 py-3 text-right">
                                @include('settings.users.partials.update-user-modal', ['user' => $user])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
