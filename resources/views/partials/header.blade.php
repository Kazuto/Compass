<header class="py-4 px-8 absolute top-0 left-0 right-0 z-10">
    <nav class="flex">
        <span class="flex-grow"></span>
        @auth
            <a
                href="{{ route('auth.logout') }}"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-lg font-semibold text-gray-900 dark:text-white transition-all duration-250 focus:outline focus:outline-2 focus:outline-[var(--color-accent)]">
                @svg('fas-sign-out-alt', 'w-5 h-5 inline')
            </a>
        @endauth
    </nav>
</header>
