@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <x-settings.action-title>
            <x-slot name="title">
                Users
            </x-slot>
        </x-settings.action-title>

        <table class="w-full mb-6">
            <thead class="bg-white/20">
            <tr class="text-left">
                <th class="p-2 rounded-l">#</th>
                <th class="p-2">Name</th>
                <th class="p-2">Username</th>
                <th class="p-2">E-Mail</th>
                <th class="p-2">Administrator</th>
                <th class="p-2">Provider</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr class="border-b border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $user->id }}</td>
                    <td class="text-left py-3 px-2">{{ $user->name }}</td>
                    <td class="text-left py-3 px-2">{{ $user->username }}</td>
                    <td class="text-left py-3 px-2">{{ $user->email }}</td>
                    <td class="text-left py-3 px-2">
                        @if($user->is_admin)
                            <span class="icon text-green-600">󰄬</span>
                        @else
                            <span class="icon text-red-600">󰂭</span>
                        @endif
                    </td>
                    <td class="text-left py-3 px-2">
                        @if(isset($user->github_id))
                            <span class="icon text-[var(--color-text)]" title="GitHub OAuth">GitHub</span>
                        @elseif(isset($user->microsoft_id))
                            <span class="icon text-[var(--color-text)]" title="Microsoft OAuth">󰍲</span>
                        @else
                            <span class="icon text-[var(--color-text)]" title="Basic Auth (Password)">󰟵</span>
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
