<div>
    <div class="flex flex-col space-y-3 filters md:flex-row md:space-y-0 md:space-x-6">
        <div class="w-full md:w-1/3">
            <select wire:model.live="category" name="category" id="category" class="w-full px-4 py-2 border-gray-200 rounded-xl">
                <option value="All Categories">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/3">
            <select wire:model.live="filter" name="other_filters" id="other_filters" class="w-full px-4 py-2 border-gray-200 rounded-xl">
                <option value="No Filters">No Filters</option>
                <option value="Top Voted">Top Voted</option>
                <option value="Top Commented">Top Commented</option>
                <option value="My Ideas">My Ideas</option>
                @admin
                    <option value="Spam Ideas">Spam Ideas</option>
                    <option value="Spam Comments">Spam Comments</option>
                @endadmin
            </select>
        </div>
        <div class="relative w-full md:w-2/3">
            <input wire:model.live="search" type="search" placeholder="Find an idea"
                class="w-full px-4 py-2 pl-8 placeholder-gray-500 bg-white border-gray-200 rounded-xl">
            <div class="absolute top-0 flex items-center h-full ml-2">
                <svg class="w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="my-8 space-y-6 ideas-container">
        @forelse ($ideas as $idea)
            <livewire:idea-index :key="$idea->id" :idea="$idea" :votesCount="$idea->votes_count" />
        @empty
            <div class="mx-auto mt-12 w-70">
                <img src="{{ asset('img/no-ideas.svg') }}" alt="No Ideas" class="mx-auto mix-blend-luminosity">
                <div class="mt-6 font-bold text-center text-gray-400">No ideas were found...</div>
            </div>
        @endforelse
    </div>

    <div class="my-8">
        {{ $ideas->links() }}
    </div>
</div>
