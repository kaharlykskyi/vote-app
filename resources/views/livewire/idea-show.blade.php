<div class="idea-and-buttons-container">
    <div class="flex mt-4 bg-white idea-container rounded-xl shadow-card">
        <div class="flex flex-col flex-1 px-4 py-6 md:flex-row">
            <div class="flex-none mx-2 md:mx-4">
                <a href="#">
                    <img src="{{ $idea->user->getAvatar() }}" alt="avatar" class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full mx-2 md:mx-4">
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">{{ $idea->title }}</a>
                </h4>
                <div class="mt-3 text-gray-600">
                    @admin
                        @if ($idea->spam_reports > 0)
                            <div class="mb-2 text-red">Spam Reports: {{ $idea->spam_reports }}</div>
                        @endif
                    @endadmin
                    {{ $idea->description }}
                </div>

                <div class="flex flex-col justify-between mt-6 md:flex-row md:items-center">
                    <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                        <div class="hidden font-bold text-gray-900 md:block">{{ $idea->user->name }}</div>
                        <div class="hidden md:block">&bull;</div>
                        <div>{{ $idea->created_at->diffForHumans() }}</div>
                        <div>&bull;</div>
                        <div>{{ $idea->category->name }}</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">{{ $idea->comments()->count() }} Comments</div>
                    </div>
                    <div class="flex items-center mt-4 space-x-2 md:mt-0" x-data="{ isOpen: false }">
                        <div
                            class="{{ Str::kebab('status' . $idea->status->name) }} px-4 py-2 font-bold leading-none text-center uppercase rounded-full text-xxs w-28 h-7">
                            {{ $idea->status->name }}
                        </div>
                        @auth
                            <button
                                class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7"
                                @click="
                                    isOpen = !isOpen;
                                ">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                                <ul class="absolute right-0 z-10 py-3 font-semibold text-left bg-white w-44 shadow-dialog rounded-xl md:ml-8 top-8 md:top-6 md:left-0"
                                    x-cloak x-show.transition.origin.top.left="isOpen" @click.away="isOpen = false"
                                    @keydown.escape.window="isOpen = false">
                                    @can('update', $idea)
                                        <li>
                                            <a @click.prevent="
                                                    isOpen = false
                                                    $dispatch('custom-show-edit-modal')
                                                "
                                                href="#"
                                                class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                                Edit Idea
                                            </a>

                                        </li>
                                    @endcan
                                    <li>
                                        <a @click.prevent="
                                                        isOpen = false
                                                        $dispatch('custom-show-spam-modal')
                                                    "
                                            href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                            Mark as Spam
                                        </a>
                                    </li>
                                    @can('delete', $idea)
                                        <li>
                                            <a @click.prevent="
                                                            isOpen = false
                                                            $dispatch('custom-show-delete-modal')
                                                        "
                                                href="#"
                                                class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">
                                                Delete Idea
                                            </a>
                                        </li>
                                    @endcan
                                    @admin
                                        @if ($idea->spam_reports > 0)
                                            <li>
                                                <a
                                                    href="#"
                                                    @click.prevent="
                                                        isOpen = false
                                                        $dispatch('custom-show-mark-idea-as-not-spam-modal')
                                                    "
                                                    class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100"
                                                >
                                                    Not Spam
                                                </a>
                                            </li>
                                        @endif
                                    @endadmin
                                </ul>
                            </button>
                        @endauth
                    </div>

                    <div class="flex items-center mt-4 md:hidden md:mt-0">
                        <div class="h-10 px-4 py-2 pr-8 text-center bg-gray-100 rounded-xl">
                            <div
                                class="text-sm font-bold leading-none @if ($hasVoted) text-blue @endif">
                                {{ $votesCount }}</div>
                            <div class="font-semibold leading-none text-gray-400 text-xxs">Votes</div>
                        </div>
                        @if ($hasVoted)
                            <button wire:click.prevent="vote"
                                class="w-20 px-4 py-3 -mx-5 font-bold text-white uppercase transition duration-150 ease-in border border-blue bg-blue text-xxs rounded-xl hover:bg-blue-hover">
                                Voted
                            </button>
                        @else
                            <button wire:click.prevent="vote"
                                class="w-20 px-4 py-3 -mx-5 font-bold uppercase transition duration-150 ease-in bg-gray-200 border border-gray-200 text-xxs rounded-xl hover:border-gray-400">
                                Vote
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end idea-container -->

    <div class="flex items-center justify-between mt-6 buttons-container">
        <div class="flex flex-col items-center space-x-4 md:flex-row md:ml-6">
            <livewire:add-comment :idea="$idea" />
            @admin
                <livewire:set-status :idea="$idea" />
            @endadmin
        </div>

        <div class="items-center hidden space-x-3 md:flex">
            <div class="px-3 py-2 font-semibold text-center bg-white rounded-xl">
                <div class="text-xl leading-snug @if ($hasVoted) text-blue @endif">
                    {{ $votesCount }}</div>
                <div class="text-xs leading-none text-gray-400">Votes</div>
            </div>
            @if ($hasVoted)
                <button wire:click.prevent="vote" type="button"
                    class="w-32 px-6 py-3 text-xs font-semibold text-white uppercase transition duration-150 ease-in border border-gray-200 h-11 rounded-xl hover:bg-blue-hover bg-blue">
                    <span>
                        Voted
                    </span>
                </button>
            @else
                <button wire:click.prevent="vote" type="button"
                    class="w-32 px-6 py-3 text-xs font-semibold uppercase transition duration-150 ease-in bg-gray-200 border border-gray-200 h-11 rounded-xl hover:border-gray-400">
                    <span>
                        Vote
                    </span>
                </button>
            @endif
        </div>
    </div> <!-- end buttons-container -->
</div>
