@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen w-full items-center justify-center lg:w-9/12 xl:w-7/12 2xl:w-1/2">
        <div class="w-full">
            <h2 class="mb-8 text-center text-3xl font-bold">Sign in to {{ config('app.name') }}</h2>
            <div
                class="mx-auto grid w-full grid-cols-1 items-center justify-center gap-8 sm:w-8/12 md:w-full md:grid-cols-[1fr_50px_1fr]">
                <div class="w-full">
                    <x-auth.login></x-auth.login>
                </div>

                <p
                    class="grid grid-cols-3 items-center text-2xl font-semibold before:h-px before:bg-white/10 after:h-px after:bg-white/10 md:h-full md:grid-cols-1 md:grid-rows-3 md:justify-items-center md:before:h-full md:before:w-px md:after:h-full md:after:w-px">
                    <span class="text-center">or</span>
                </p>

                <div class="flex flex-col gap-2">
                    <x-auth.link
                        provider="github"
                        icon="fab-github"
                        class="mb-4"
                    />
                    <x-auth.link
                        provider="microsoft"
                        icon="fab-microsoft"
                        class="mb-4"
                    />
                </div>
            </div>
        </div>
    </div>
@endsection
