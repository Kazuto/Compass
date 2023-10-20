<div
    @class([
        'py-2.5 px-3 rounded-lg mb-6 shadow-lg',
        'bg-red-500 dark:bg-red-600 text-white' => $type === 'error',
        'bg-green-500 dark:bg-green-600 text-white' => $type === 'success',
        'bg-blue-500 dark:bg-blue-600 text-white' => $type === 'info',
])
>
    {!! nl2br($slot) !!}
</div>
