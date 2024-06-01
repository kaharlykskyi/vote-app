<nav class="items-center justify-between hidden text-xs text-gray-400 md:flex">
    <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
        <li>
            <a
                wire:click.prevent="setStatus('All')" href="#"
                class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue
                @if ($status === 'All') text-gray-900 border-blue @endif"
            >
                All Ideas (87)
            </a>
        </li>
        <li>
            <a
                wire:click.prevent="setStatus('Considering')" href="#"
                class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue
                @if ($status === 'Considering') text-gray-900 border-blue @endif"
            >
                Considering(6)
            </a>
        </li>
        <li>
            <a
                wire:click.prevent="setStatus('In Progress')"
                href="#"
                class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue
                @if ($status === 'In Progress') text-gray-900 border-blue @endif"
            >
                In Progress (1)
            </a>
        </li>
    </ul>

    <ul class="flex pb-3 space-x-10 font-semibold uppercase border-b-4">
        <li>
            <a
                wire:click.prevent="setStatus('Implemented')"
                href="#"
                class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue
                @if ($status === 'Implemented') text-gray-900 border-blue @endif"
            >
                Implemented (10)
            </a>
        </li>
        <li>
            <a
                wire:click.prevent="setStatus('Closed')"
                href="#"
                class="pb-3 transition duration-150 ease-in border-b-4 hover:border-blue
                @if ($status === 'Closed') text-gray-900 border-blue @endif"
            >
                Closed (55)
            </a>
        </li>
    </ul>
</nav>
