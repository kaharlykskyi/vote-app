<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Inter:wght@100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="text-sm text-gray-900 font-hanken-grotesk bg-gray-background">
    <header class="flex flex-col items-center justify-between px-8 py-4 md:flex-row">
        <a href="/"><x-application-logo /></a>
        <div class="flex items-center mt-2 md:mt-0">
            @if (Route::has('login'))
                <div class="px-6 py-4">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log out') }}
                            </a>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
            @auth
                <a href="#">
                    <img src="{{ auth()->user()->getAvatar() }}" alt="avatar" class="w-10 h-10 rounded-full">
                </a>
            @endauth
        </div>
    </header>

    <main class="container flex flex-col mx-auto max-w-custom md:flex-row">
        <div class="mx-auto w-70 md:mx-0 md:mr-5">
            <div class="mt-16 bg-white border-2 md:sticky md:top-8 border-blue rounded-xl"
                style="
                      border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        border-image-slice: 1;
                        background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
                        background-origin: border-box;
                        background-clip: content-box, border-box;
                ">
                <div class="px-6 py-2 pt-6 text-center">
                    <h3 class="text-base font-semibold">Add an idea</h3>
                    <p class="mt-4 text-xs">
                        @auth
                            Let us know what you would like and we'll take a look over!
                        @else
                            Please log in to create an idea
                        @endauth
                    </p>
                </div>

                @auth()
                    <livewire:create-idea />
                @else
                    <div class="my-4 text-center">
                        <a href="{{ route('login') }}"
                            class="justify-center inline-block w-1/2 px-6 py-3 text-xs font-bold text-white transition duration-150 ease-in border h-11 bg-blue border-blue hover:bg-blue-hover rounded-xl">Log
                            in</a>
                        <a href="{{ route('register') }}"
                            class="justify-center inline-block w-1/2 px-6 py-3 mt-4 text-xs font-bold transition duration-150 ease-in bg-gray-200 border border-gray-200 h-11 hover:border-gray-400 rounded-xl">Register</a>
                    </div>
                @endauth
            </div>
        </div>
        <div class="w-full px-2 md:px-0 md:w-175">
            <livewire:status-filters />
            <div class="mt-8">
                {{ $slot }}
            </div>
        </div>


    </main>
    @livewireScripts
</body>

</html>
