@props(['title'])

<div
    {{ $attributes->merge(['class' => 'flex flex-col md:flex-row items-start md:items-center md:justify-between gap-4 mb-6']) }}>
    @if (isset($title))
        <h3 {{ $title->attributes->merge(['class' => 'block text-3xl font-black']) }}>
            {{ $title }}
        </h3>
    @else
        <span class="flex-grow-1"></span>
    @endif

    {{ $slot }}
</div>
