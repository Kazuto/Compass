<div class="fixed bottom-2 left-2 right-2 z-50 mx-auto sm:left-1/2 sm:right-auto sm:-translate-x-1/2 md:bottom-8">
    @if (Session::has('error'))
        <x-alert type="error">{!! Session::get('error') !!}</x-alert>
    @endif

    @if (Session::has('info'))
        <x-alert type="info">{!! Session::get('info') !!}</x-alert>
    @endif

    @if (Session::has('success'))
        <x-alert type="success">{!! Session::get('success') !!}</x-alert>
    @endif
</div>
