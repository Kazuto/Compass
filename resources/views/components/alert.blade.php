<div
    @class([
        'py-2.5 px-3 rounded-lg mb-6 shadow-lg',
        'bg-red-600' => $type === 'error',
        'bg-green-600' => $type === 'success',
])
>
    {!! nl2br($slot) !!}
</div>
