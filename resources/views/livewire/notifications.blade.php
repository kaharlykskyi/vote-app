<div x-data="{ isOpen: false }" class="relative" >
    <button
        @click="
            isOpen = !isOpen
            if(isOpen) {
                $dispatch('fetch-notifications')
            }
        "
    >
        <svg class="w-8 h-8 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
        </svg>
        <div class="absolute flex items-center justify-center w-6 h-6 text-white border-2 rounded-full bg-red text-xxs -top-1 -right-1">8</div>
    </button>
    <ul
        class="absolute z-10 overflow-y-auto text-sm text-left text-gray-700 bg-white w-76 md:w-96 shadow-dialog rounded-xl max-h-128 -right-28 md:-right-12"
        x-cloak
        x-show.transition.origin.top="isOpen"
        @click.away="isOpen = false"
        @keydown.escape.window="isOpen = false"
    >
        @if($loading)
            <div class="grid justify-items-center">
                <div class="m-8 text-gray-200 loader"></div>
            </div>
        @endif
        @isset($notifications)
            @forelse ($notifications as $notification)
                <x-comment-notification :$notification />
            @empty
                <li class="px-5 py-4 border-b border-gray-300">
                    <div class="text-center text-gray-400">No new notifications</div>
                </li>
            @endforelse
        @endisset

        <li class="text-center border-t border-gray-300">
            <button
                class="block w-full px-5 py-4 font-semibold transition duration-150 ease-in hover:bg-gray-100"
            >
                Mark all as read
            </button>
        </li>
    </ul>
</div>
