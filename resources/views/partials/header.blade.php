@auth
    <header class="fixed bottom-0 right-0 z-10 rounded-tl-lg bg-base-dark/10 px-4 py-2 dark:bg-base-light/10">
        <nav class="flex gap-4">
            @can('access-settings')
                <button
                    id="theme_toggle"
                    class="duration-250 flex h-10 w-10 items-center justify-center rounded-lg text-lg font-semibold text-gray-900 transition-all focus:outline focus:outline-2 focus:outline-accent-medium dark:text-white"
                >
                    @svg('fas-spinner', ['class' => 'h-4'])
                </button>
            @endcan
            @can('access-settings')
                <a
                    href="{{ route('settings.bookmarks.list') }}"
                    class="duration-250 flex h-10 w-10 items-center justify-center rounded-lg text-lg font-semibold text-gray-900 transition-all focus:outline focus:outline-2 focus:outline-accent-medium dark:text-white"
                >
                    @svg('fas-cog', ['class' => 'h-4'])
                </a>
            @endcan
            <a
                href="{{ route('auth.logout') }}"
                class="duration-250 flex h-10 w-10 items-center justify-center rounded-lg text-lg font-semibold text-gray-900 transition-all focus:outline focus:outline-2 focus:outline-accent-medium dark:text-white"
            >
                @svg('fas-sign-out-alt', ['class' => 'h-4'])
            </a>
        </nav>
    </header>
@endauth
