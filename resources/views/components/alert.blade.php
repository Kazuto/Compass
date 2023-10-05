<div
    @class([
        'py-2.5 px-3 rounded-lg mb-6',
        'bg-red-600' => $type === 'error',
        'bg-green-600' => $type === 'success',
])
>
    {{ $slot }}
</div>
