<x-app-layout>
    <div>
        <a href="{{ route('home') }}" class="flex items-center font-semibold hover:underline">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
            <span class="ml-2">All ideas</span>
        </a>
    </div>

    <div class="flex mt-4 bg-white idea-container rounded-xl">
        <div class="flex flex-1 px-4 py-6">
            <div class="flex-none">
                <a href="#">
                    <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="avatar"
                        class="w-14 h-14 rounded-xl">
                </a>
            </div>
            <div class="w-full mx-4">
                <h4 class="text-xl font-semibold">
                    <a href="#" class="hover:underline">A random title can go here</a>
                </h4>
                <div class="mt-3 text-gray-600">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum possimus quasi reprehenderit earum
                    incidunt. Ad reprehenderit repudiandae
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                        <div class="font-bold text-gray-900">John Doe</div>
                        <div>&bull;</div>
                        <div>10 hours ago</div>
                        <div>&bull;</div>
                        <div>Category 1</div>
                        <div>&bull;</div>
                        <div class="text-gray-900">3 Comments</div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div
                            class="px-4 py-2 font-bold leading-none text-center uppercase bg-gray-200 rounded-full text-xxs w-28 h-7">
                            Open</div>
                        <button
                            class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                            <svg fill="currentColor" width="24" height="6">
                                <path
                                    d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                    style="color: rgba(163, 163, 163, .5)">
                            </svg>
                            <ul
                                class="absolute hidden py-3 ml-8 font-semibold text-left bg-white w-44 shadow-dialog rounded-xl">
                                <li><a href="#"
                                        class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark
                                        as Spam</a></li>
                                <li><a href="#"
                                        class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete
                                        Post</a></li>
                            </ul>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- end idea-container -->

    <div class="flex items-center justify-between mt-4 buttons-container">
        <div class="flex items-center ml-6 space-x-4">
            <button type="button"
                class="flex items-center justify-center w-32 px-6 py-3 text-xs font-semibold text-white transition duration-150 ease-in border bg-blue border-blue h-11 rounded-xl hover:bg-blue-hover ">
                <span class="ml-1">Reply</span>
            </button>
            <button type="button"
                class="flex items-center justify-center px-6 py-3 text-xs font-semibold transition duration-150 ease-in bg-gray-200 border border-gray-200 w-36 h-11 rounded-xl hover:border-gray-400">
                <span>Set Status</span>
                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                  </svg>
            </button>
        </div>

        <div class="flex items-center space-x-3">
            <div class="px-3 py-2 font-semibold text-center bg-white rounded-xl">
                <div class="text-xl leading-snug">12</div>
                <div class="text-xs leading-none text-gray-400">Votes</div>
            </div>
            <button type="button"
                class="w-32 px-6 py-3 text-xs font-semibold uppercase transition duration-150 ease-in bg-gray-200 border border-gray-200 h-11 rounded-xl hover:border-gray-400">
                <span>Vote</span>
            </button>
        </div>
    </div> <!-- end buttons-container -->

    <div class="relative pt-4 my-8 mt-1 space-y-6 ml-22 comments-container">
        <div class="relative flex mt-4 bg-white comment-container rounded-xl">
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://randomuser.me/api/portraits/women/2.jpg" alt="avatar"
                            class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="w-full mx-4">
                    {{-- <h4 class="mb-3 text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here</a>
                    </h4> --}}
                    <div class="text-gray-600 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum possimus quasi reprehenderit earum
                        incidunt. Ad reprehenderit repudiandae
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                            <div class="font-bold text-gray-900">John Doe</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                                <ul
                                    class="absolute hidden py-3 ml-8 font-semibold text-left bg-white w-44 shadow-dialog rounded-xl">
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark
                                            as Spam</a></li>
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete
                                            Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end comment-container -->

        <div class="relative flex mt-4 bg-white is-admin comment-container rounded-xl">
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://randomuser.me/api/portraits/women/3.jpg" alt="avatar"
                            class="w-14 h-14 rounded-xl">
                    </a>
                    <div class="mt-1 font-bold text-center uppercase text-xxs text-blue">Admin</div>
                </div>
                <div class="w-full mx-4">
                    <h4 class="mb-3 text-xl font-semibold">
                        <a href="#" class="hover:underline">Status changed to 'In Progress'</a>
                    </h4>
                    <div class="text-gray-600">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum possimus quasi reprehenderit earum
                        incidunt. Ad reprehenderit repudiandae
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                            <div class="font-bold text-blue">Andrea</div>
                            <div>&bull;</div>
                            <div>2 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                                <ul
                                    class="absolute hidden py-3 ml-8 font-semibold text-left bg-white w-44 shadow-dialog rounded-xl">
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark
                                            as Spam</a></li>
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete
                                            Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end comment-container -->

        <div class="relative flex mt-4 bg-white comment-container rounded-xl">
            <div class="flex flex-1 px-4 py-6">
                <div class="flex-none">
                    <a href="#">
                        <img src="https://randomuser.me/api/portraits/women/4.jpg" alt="avatar"
                            class="w-14 h-14 rounded-xl">
                    </a>
                </div>
                <div class="w-full mx-4">
                    {{-- <h4 class="mb-3 text-xl font-semibold">
                        <a href="#" class="hover:underline">A random title can go here</a>
                    </h4> --}}
                    <div class="text-gray-600 line-clamp-3">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum possimus quasi reprehenderit earum
                        incidunt. Ad reprehenderit repudiandae
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <div class="flex items-center space-x-2 text-xs font-semibold text-gray-400">
                            <div class="font-bold text-gray-900">John Doe</div>
                            <div>&bull;</div>
                            <div>10 hours ago</div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                class="relative px-3 py-2 transition duration-150 ease-in bg-gray-100 border rounded-full hover:bg-gray-200 h-7">
                                <svg fill="currentColor" width="24" height="6">
                                    <path
                                        d="M2.97.061A2.969 2.969 0 000 3.031 2.968 2.968 0 002.97 6a2.97 2.97 0 100-5.94zm9.184 0a2.97 2.97 0 100 5.939 2.97 2.97 0 100-5.939zm8.877 0a2.97 2.97 0 10-.003 5.94A2.97 2.97 0 0021.03.06z"
                                        style="color: rgba(163, 163, 163, .5)">
                                </svg>
                                <ul
                                    class="absolute hidden py-3 ml-8 font-semibold text-left bg-white w-44 shadow-dialog rounded-xl">
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Mark
                                            as Spam</a></li>
                                    <li><a href="#"
                                            class="block px-5 py-3 transition duration-150 ease-in hover:bg-gray-100">Delete
                                            Post</a></li>
                                </ul>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end comment-container -->
    </div> <!-- end comments-container -->
</x-app-layout>
