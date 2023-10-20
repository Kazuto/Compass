@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center w-full lg:w-9/12 xl:w-7/12 2xl:w-1/2 min-h-screen">
        <div class="w-full">
            <h2 class="text-3xl font-bold mb-8 text-center">Sign in to {{ config('app.name') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-[1fr_50px_1fr] w-full sm:w-8/12 md:w-full items-center justify-center gap-8 mx-auto">
                <div class="w-full">
                    <x-auth.login></x-auth.login>
                </div>

                <p class="grid grid-cols-3 md:grid-cols-1 md:grid-rows-3  md:h-full items-center md:justify-items-center font-semibold text-2xl before:h-px before:bg-white/10 md:before:h-full md:before:w-px after:h-px after:bg-white/10 md:after:h-full md:after:w-px">
                    <span class="text-center">or</span>
                </p>

                <div class="flex flex-col gap-4">
                    <x-auth.link provider="github" icon="fab-github" class="mb-4"/>
                    <x-auth.link provider="microsoft" icon="fab-microsoft" class="mb-4"/>
                </div>
            </div>
        </div>
    </div>
@endsection
