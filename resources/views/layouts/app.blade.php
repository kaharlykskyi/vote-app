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
</head>

<body class="text-sm text-gray-900 font-hanken-grotesk bg-gray-background">
    <header class='flex items-center justify-between px-8 py-4'>
        <a href="/">
            <img src="{{ asset('img/logo.svg') }}" alt="Voting App Logo">
        </a>
        <div class="flex items-center">
            @if (Route::has('login'))
                <nav class="flex justify-end flex-1 -mx-3">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="{{ route('logout') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
            <a href="#">
                <img src="https://gravatar.com/avatar/efccac84f5221ed54b368608d35b261acb82244381bc6790bf0269bb1a478f63"
                    class="w-10 h-10 ml-4 rounded-full" alt="avatar">
            </a>
        </div>
    </header>

    <main class="container flex mx-auto max-w-custom">
        <div class="mr-5 w-70">
            <div class="mt-16 bg-white border-2 border-blue rounded-xl"
                style="
            border-image-source: linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
              border-image-slice: 1;
              background-image: linear-gradient(to bottom, #ffffff, #ffffff), linear-gradient(to bottom, rgba(50, 138, 241, 0.22), rgba(99, 123, 255, 0));
              background-origin: border-box;
              background-clip: content-box, border-box;">
                <div class="px-6 py-2 pt-6 text-center">
                    <h3 class="text-base font-semibold">Add an Idea</h3>
                    <p class="mt-4 text-xs">Let us know what you would like and we'll take a look over!</p>
                </div>

                <form action="#" class="px-4 py-6 space-y-4">
                    <div>
                        <input type="text"
                            class="w-full px-4 py-2 text-sm placeholder-gray-900 bg-gray-100 border-none rounded-xl"
                            placeholder="Your idea">
                    </div>
                    <div>
                        <select name="category_add" id="category_add"
                            class='w-full px-4 py-2 text-sm bg-gray-100 border-none rounded-xl'>
                            <option value="all">Category</option>
                            <option value="all">Category</option>
                        </select>
                    </div>
                    <div>
                        <textarea name="idea" id="idea" cols="30" rows="4"
                            class="w-full px-4 py-2 text-sm placeholder-gray-900 bg-gray-100 border-none rounded-xl"
                            placeholder="Describe your idea"></textarea>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button"
                            class="flex items-center justify-center w-1/2 px-6 py-3 text-xs font-semibold transition duration-150 ease-in bg-gray-200 border border-gray-200 h-11 rounded-xl hover:border-gray-400">
                            <svg class="w-4 text-gray-600 -rotate-45" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                            </svg>
                            <span class="ml-1">Attach</span>
                        </button>
                        <button type="submit"
                            class="flex items-center justify-center w-1/2 px-6 py-3 text-xs font-semibold text-white transition duration-150 ease-in border bg-blue border-blue h-11 rounded-xl hover:bg-blue-hover ">
                            <span class="ml-1">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-175">
            <nav class="flex items-center justify-between text-xs">
                <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
                    <li><a href="#" class="pb-3 border-b-4 border-b-blue">All ideads (87)</a></li>
                    <li><a href="#"
                            class="pb-3 text-gray-400 transition duration-150 ease-in border-b-4 hover:border-b-blue">Considering
                            (104)</a></li>
                    <li><a href="#"
                            class="pb-3 text-gray-400 transition duration-150 ease-in border-b-4 hover:border-b-blue">In
                            Progress (1)</a></li>
                </ul>

                <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
                    <li><a href="#" class="pb-3 border-b-4 border-b-blue">Implemented (3)</a></li>
                    <li><a href="#"
                            class="pb-3 text-gray-400 transition duration-150 ease-in border-b-4 hover:border-b-blue">Closed
                            (55)</a></li>
                </ul>
            </nav>

            <div class="mt-8">
                {{ $slot }}
            </div>
        </div>
    </main>
</body>

</html>
