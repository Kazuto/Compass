<div class="fixed bottom-2 md:bottom-8 left-2 right-2 sm:right-auto sm:left-1/2 sm:-translate-x-1/2 mx-auto z-50">
    @if(Session::has('error'))
        <x-alert type="error">{!! Session::get('error') !!}</x-alert>
    @endif

    @if(Session::has('info'))
        <x-alert type="info">{!! Session::get('info') !!}</x-alert>
    @endif

    @if(Session::has('success'))
        <x-alert type="success">{!! Session::get('success') !!}</x-alert>
    @endif
</div>
