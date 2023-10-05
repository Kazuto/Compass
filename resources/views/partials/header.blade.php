<header class="py-4 px-8 fixed bottom-0 right-0 z-10">
    <nav class="flex">
        @auth
            <a
                href="{{ route('settings.bookmarks.list') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-lg font-semibold text-gray-900 dark:text-white transition-all duration-250 focus:outline focus:outline-2 focus:outline-[var(--color-accent)]">
                <span class="icon">󰒓</span>
            </a>
            <a
                href="{{ route('auth.logout') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-lg font-semibold text-gray-900 dark:text-white transition-all duration-250 focus:outline focus:outline-2 focus:outline-[var(--color-accent)]">
               <span class="icon">󰍃</span>
            </a>
        @endauth
    </nav>
</header>
