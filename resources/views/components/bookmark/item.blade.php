<li>
    <a class="inline-flex items-center gap-1 text-sm transition-all hover:translate-x-2" href="{{ $bookmark->url }}">
        @if($bookmark->icon)
        @svg($bookmark->icon, ['class' => 'h-3 w-3'])
        @endif
        {{ $bookmark->name }}
    </a>
</li>
