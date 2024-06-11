@props([
    'type' => 'success',
    'redirect' => false,
    'messageToDisplay' => '',
])

<div
    x-cloak
    x-data="{
        isOpen: false,
        isError: @if($type === 'error') true @else false @endif,
        messageToDisplay: '{{ $messageToDisplay }}',
        showNotification(message) {
            this.isOpen = true
            this.messageToDisplay = message
            setTimeout(() => {
                this.isOpen = false
            }, 5000)
        }
    }"
    x-init="
        $nextTick(() => {
            @if ($redirect)
                $nextTick(() => showNotification(messageToDisplay))
            @else
                Livewire.on('idea-was-updated', message => {
                    showNotification(message)
                })

                Livewire.on('idea-was-marked-as-spam', message => {
                    showNotification(message)
                })

                Livewire.on('idea-was-marked-as-not-spam', message => {
                    showNotification(message)
                })

                Livewire.on('status-was-updated', message => {
                    showNotification(message)
                })

                Livewire.on('idea-was-commented', message => {
                    showNotification(message[0].text)
                })

                Livewire.on('comment-was-updated', message => {
                    showNotification(message)
                })

                Livewire.on('status-was-updated-error', message => {
                    isError = true
                    showNotification(message)
                })

                Livewire.on('comment-was-deleted', message => {
                    showNotification(message)
                })

                Livewire.on('comment-was-marked-as-spam', message => {
                    showNotification(message)
                })

                Livewire.on('comment-was-marked-as-not-spam', message => {
                    showNotification(message)
                })
            @endif
        });
    "
    x-show="isOpen"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-x-8"
    x-transition:enter-end="opacity-100 transform translate-x-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 transform translate-x-0"
    x-transition:leave-end="opacity-0 transform translate-x-8"
    @keydown.escape.window="isOpen = false"

    class="fixed right-0 z-20 flex justify-between w-full max-w-xs px-4 py-5 mx-2 my-8 bg-white border shadow-lg bottom-4 sm:max-w-sm rounded-xl sm:mx-6"
>
    <div class="flex items-center">

        <svg x-show="!isError" class="w-6 h-6 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <svg x-show="isError" class="w-6 h-6 text-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <div class="ml-2 text-sm text-gray-500 sm:text-base" x-text="messageToDisplay"></div>
    </div>
    <button @click="isOpen = false" class="text-gray-400 hover:text-gray-500">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
