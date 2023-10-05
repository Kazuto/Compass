@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-2xl mb-4 font-black">
                Group: <span class="text-[var(--color-accent)]">{{ $bookmarkGroup->name }}</span>
            </h3>

            <div>
                @include('settings.bookmarks.partials.update-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])

                @include('settings.bookmarks.partials.delete-bookmark-group-modal', ['bookmarkGroup' => $bookmarkGroup])
            </div>
        </div>

        <table class="w-full mb-6">
            <thead class="bg-white/20">
            <tr class="text-left">
                <th class="p-2 rounded-l">Name</th>
                <th class="p-2">URL</th>
                <th class="p-2">Icon</th>
                <th class="p-2">Order</th>
                <th class="p-2 rounded-r"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($bookmarkGroup->bookmarks as $bookmark)
                <tr class="border-b border-white/10 last:border-transparent">
                    <td class="text-left py-3 px-2">{{ $bookmark->name }}</td>
                    <td class="text-left py-3 px-2">{{ $bookmark->url }}</td>
                    <td class="text-left py-3 px-2"><span class="icon">{{ $bookmark->icon }}</span></td>
                    <td class="text-left py-3 px-2">{{ $bookmark->order }}</td>
                    <td class="text-right py-3 px-2">
                        <a href="#"
                           class="inline-flex w-8 h-8 items-center justify-center rounded-lg transition-all hover:bg-white/50 mr-2">
                            <span class="icon">󰏫</span>
                        </a>

                        <a href="#"
                           class="inline-flex w-8 h-8 items-center justify-center rounded-lg transition-all hover:bg-red-500 mr-2">
                            <span class="icon">󰩹</span>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
