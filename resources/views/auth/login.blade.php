@extends('layouts.app')

@section('content')
    <div>
        <h2 class="text-white text-3xl font-bold mb-8 text-center">Sign in to {{ config('app.name') }}</h2>
        <div class="grid grid-cols-1 gap-4">
            <x-auth-link provider="github" class="mb-4"></x-auth-link>
        </div>
    </div>
@endsection
