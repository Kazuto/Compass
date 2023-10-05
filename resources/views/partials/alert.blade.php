<div class="fixed bottom-8 left-1/2 -translate-x-1/2 mx-auto">
    @if(Session::has('error'))
        <x-alert type="error">{!! Session::get('error') !!}</x-alert>
    @endif

    @if(Session::has('success'))
        <x-alert type="success">{!! Session::get('success') !!}</x-alert>
    @endif
</div>
