<li>
    <a class="inline-block text-sm transition-all hover:translate-x-2" href="{{ $bookmark->url }}">
        @if($bookmark->icon)
        <span class="icon mr-1">{{ $bookmark->icon }}</span>
        @endif
        {{ $bookmark->name }}
    </a>
</li>
