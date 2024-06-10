<x-modal-confirm
    livewireEventToOpenModal="mark-as-not-spam-comment-was-set"
    eventToCloseModal="comment-was-marked-as-not-spam"
    title="Reset Comment Spam Counter"
    description="Are you sure you want to mark this comment as NOT spam? This will reset the spam counter to 0."
    action="Reset Spam Counter"
    wire-click="markAsNotSpam"
/>
