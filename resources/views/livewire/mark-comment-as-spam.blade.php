<x-modal-confirm
    livewireEventToOpenModal="mark-as-spam-comment-was-set"
    eventToCloseModal="comment-was-marked-as-spam"
    title="Mark Comment as Spam"
    description="Are you sure you want to mark this comment as spam?"
    action="Mark as Spam"
    wire-click="markAsSpam"
/>
