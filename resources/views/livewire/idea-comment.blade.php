<div id="comment-{{ $comment->id }}"
    class="relative flex mt-4 transition duration-500 ease-in border border-gray-200 comment-container rounded-xl @if ($comment->is_status_update) is-status-update {{ Str::kebab('status' . $comment->status->name) }} @endif">
    <div class="flex flex-col flex-1 px-4 py-6 md:flex-row">
        <div class="flex-none">
            <a href="#">
                <img src="{{ $comment->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
            </a>
            @if ($comment->user->isAdmin())
                <div class="mt-1 font-bold text-center uppercase text-blue text-xxs">Admin</div>
            @endif
        </div>
        <div class="w-full md:mx-4">
            @if ($comment->is_status_update)
                <h4 class="mb-3 text-xl font-semibold text-gray-700">
                    Status Changed to "{{ $comment->status->name }}"
                </h4>
            @endif

            @admin
                @if ($comment->spam_reports > 0)
                    <div class="mb-2 text-red">Spam Reports: {{ $comment->spam_reports }}</div>
                @endif
            @endadmin

            <div class="text-gray-600">
                {!! nl2br(e($comment->body)) !!}
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                    <div class="font-bold @if ($comment->is_status_update) text-blue @else text-gray-900 @endif">
                        {{ $comment->user->name }}</div>
                    <div>&bull;</div>
                    @if ($comment->user_id === $ideaUserId)
                        <div class="px-3 py-1 bg-gray-100 border rounded-full" title="Original Poster">OP</div>
                        <div>&bull;</div>
                    @endif
                    <div>{{ $comment->created_at->diffForHumans() }}</div>
                </div>

                <div class="flex items-center space-x-2">
                    <livewire:like-comment :comment="$comment" />
                    @auth
                        <div x-data="{ isOpen: false }">
                            <button
                                class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7"
                                @click="isOpen = !isOpen">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                                <ul class="absolute right-0 z-10 py-3 font-semibold text-left text-gray-700 bg-white w-44 shadow-dialog rounded-xl md:ml-8 top-8 md:top-6 md:left-0"
                                    x-cloak x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false"
                                    @keydown.escape.window="isOpen = false">
                                    @can('update', $comment)
                                        <li>
                                            <a @click.prevent="
                                                    isOpen = false
                                                    Livewire.dispatch('setEditComment', { id: {{ $comment->id }}})
                                                "
                                                href="#"
                                                class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                                Edit Comment
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a @click.prevent="
                                                isOpen = false
                                                Livewire.dispatch('setMarkAsSpamComment', { id: {{ $comment->id }}})
                                            "
                                            href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                            Mark as Spam
                                        </a>
                                    </li>
                                    @admin
                                        @if ($comment->spam_reports > 0)
                                            <li>
                                                <a href="#"
                                                    @click.prevent="
                                                        isOpen = false
                                                        Livewire.dispatch('setMarkAsNotSpamComment', {
                                                            id: {{ $comment->id }}
                                                        });
                                                    "
                                                    class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                                    Not Spam
                                                </a>
                                            </li>
                                        @endif
                                    @endadmin
                                    @can('delete', $comment)
                                        <li>
                                            <a @click.prevent="
                                                    isOpen = false
                                                    Livewire.dispatch('setDeleteComment', { id: {{ $comment->id }}})
                                                "
                                                href="#"
                                                class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                                Delete Comment
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </button>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</div>
