@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-6 mb-6 border-b border-white/20">
            <h3 class="block text-3xl font-black">
                Whitelist
            </h3>

            <div>
                @include('settings.whitelist_access.partials.create-whitelist-access-modal')
            </div>
        </div>


        <table class="w-full mb-6">
            <thead class="bg-white/20">
            <tr class="text-left">
                <th class="p-2 rounded-l">#</th>
                <th class="p-2">E-Mail</th>
                <th class="p-2">Available</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($whitelistAccess as $access)
                <tr class="border-b border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $access->id }}</td>
                    <td class="text-left py-3 px-2">{{ $access->email }}</td>
                    <td class="text-left py-3 px-2">
                        @if($access->is_available)
                            <span class="icon text-green-600">󰄬</span>
                        @else
                            <span class="icon text-red-600">󰂭</span>
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
