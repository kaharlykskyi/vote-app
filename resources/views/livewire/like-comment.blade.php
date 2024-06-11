<button
    class="relative flex items-center px-3 text-gray-400 transition duration-300 ease-in-out bg-gray-100 border rounded-full h-7 hover:bg-gray-200"
    wire:click.prevent="toggleLike">
    <svg id="heart-{{ $comment->id }}"
        class="w-5 h-5 @if ($isLiked) fill-blue @else fill-current @endif" viewBox="0 0 24 24"
        stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
    </svg>
    <span class="px-1 @if ($isLiked) text-blue @endif">
        {{ $likeCount }}
    </span>
</button>
