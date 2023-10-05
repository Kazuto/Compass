@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-2xl mb-4 font-black">
                Teams: <span class="text-[var(--color-accent)]">{{ $team->name }}</span>
            </h3>
        </div>

            <table class="w-full mb-6">
                <thead class="bg-white/20">
                <tr class="text-left">
                    <th class="p-2 rounded-l">#</th>
                    <th class="p-2">Name</th>
                    <th class="p-2">E-Mail</th>
                    <th class="p-2 rounded-r"></th>
                </tr>
                </thead>
                <tbody>
                @forelse ($team->users as $user)
                    <tr class="border-b border-white/10 last:border-transparent">
                        <td class="text-left py-3 px-2">{{ $user->id }}</td>
                        <td class="text-left py-3 px-2">{{ $user->name }}</td>
                        <td class="text-left py-3 px-2">{{ $user->email }}</td>
                        <td class="text-right py-3 px-2">
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="999" class="text-center pt-4 px-2 text-xl text-neutral-400">No users added yet</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

    </div>
@endsection
