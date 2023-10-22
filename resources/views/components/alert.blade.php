<div @class([
    'flex items-center justify-between gap-4 py-2.5 px-3 rounded-lg mb-6 shadow-lg transition-all',
    'bg-red-500 dark:bg-red-600 text-white' => $type === 'error',
    'bg-green-500 dark:bg-green-600 text-white' => $type === 'success',
    'bg-blue-500 dark:bg-blue-600 text-white' => $type === 'info',
])>
    <p>
        {!! nl2br($slot) !!}
    </p>
    <span
        class="flex h-8 w-8 shrink-0 items-center justify-center self-start rounded-lg text-2xl transition-all hover:cursor-pointer hover:bg-black/20"
        onclick="dismissAlert(this.parentElement)"
    >&times;</span>
</div>

<script>
    function dismissAlert(alert) {
        alert.classList.add('opacity-0');

        setTimeout(() => {
            alert.remove();
        }, 500);
    }
</script>
