<li>
    <a
        href="{{ route('idea.show', $notification->data['idea_slug']) }}"
        class="flex px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
    >
        <img src="{{ $notification->data['user_avatar'] }}" class="w-10 h-10 rounded-xl" alt="avatar">
        <div class="ml-4">
            <div class="line-clamp-6">
                <span class="font-semibold">{{ $notification->data['user_name'] }}</span> commented on
                <span class="font-semibold">{{ $notification->data['idea_title'] }}</span>:
                <span>"{{ $notification->data['comment_body'] }}"</span>
            </div>
            <div class="mt-2 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
        </div>
    </a>
</li>
