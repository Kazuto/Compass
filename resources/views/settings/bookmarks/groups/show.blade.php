@extends('layouts.settings')

@section('content')
    <div class="w-full">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/20">
            <h3 class="block text-2xl mb-4 font-black">
                Group: <span class="text-[var(--color-accent)]">{{ $bookmarkGroup->name }}</span>
            </h3>

            <div>
                <x-modal
                    id="edit-bookmark-group"
                    title="Edit Bookmark Group"
                    button-text="Edit Group"
                >
                    <form action="{{ route('settings.bookmarks.groups.update', ['bookmarkGroup' => $bookmarkGroup]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <x-text-input name="name" id="name" label="Name:" value="{{ $bookmarkGroup->name }}" />

                        <button type="submit" class="rounded-lg bg-[var(--color-accent)] text-[var(--color-text)] py-2 px-4">Save</button>
                    </form>
                </x-modal>

                <x-modal
                    id="delete-bookmark-group"
                    title="Delete Bookmark Group"
                    button-text="Delete Group"
                    button-type="danger"
                >
                    <p class="text-lg text-[var(--color-text)] mb-8">
                        Are you sure to delete this bookmark group?
                    </p>
                    <form
                        action="{{ route('settings.bookmarks.groups.delete', ['bookmarkGroup' => $bookmarkGroup]) }}"
                        method="POST"
                        class="inline"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="py-2 px-3 rounded-lg bg-red-600 text-[var(--color-text)]">Confirm</button>
                    </form>
                </x-modal>
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
