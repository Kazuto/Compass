@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Users
            </x-slot>
        </x-settings.action-title>

        <table class="w-full mb-6">
            <thead class="bg-base-dark/10 dark:bg-base-light/10">
            <tr class="text-left">
                <th class="p-2 rounded-l">#</th>
                <th class="p-2">Name</th>
                <th class="p-2">Username</th>
                <th class="p-2">E-Mail</th>
                <th class="p-2">Administrator</th>
                <th class="p-2">Auth Method</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-black/10 dark:border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $user->id }}</td>
                    <td class="text-left py-3 px-2">{{ $user->name }}</td>
                    <td class="text-left py-3 px-2">{{ $user->username }}</td>
                    <td class="text-left py-3 px-2">{{ $user->email }}</td>
                    <td class="text-left py-3 px-2">
                        @if($user->is_admin)
                            @svg('far-check-circle', ['class' => 'h-4 w-4 text-green-600'])
                        @else
                            @svg('far-times-circle', ['class' => 'h-4 w-4 text-red-600'])
                        @endif
                    </td>
                    <td class="text-left py-3 px-2">
                        @if(isset($user->github_id))
                            @svg('fab-github', ['class' => 'h-4 w-4', 'title' => 'GitHub OAuth'])
                        @elseif(isset($user->microsoft_id))
                            @svg('fab-microsoft', ['class' => 'h-4 w-4', 'title' => 'Microsoft OAuth'])
                        @else
                            @svg('phosphor-password', ['class' => 'h-4 w-4', 'title' => 'Basic Auth (Password)'])
                        @endif
                    </td>
                    <td class="text-right py-3 px-2">
                        @include('settings.users.partials.update-user-modal', ['user' => $user])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
