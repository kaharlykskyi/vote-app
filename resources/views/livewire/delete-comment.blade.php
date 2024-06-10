<x-modal-confirm
    livewireEventToOpenModal="delete-comment-was-set"
    eventToCloseModal="comment-was-deleted"
    title="Delete comment"
    description="Are you sure you want to delete this comment? This action cannot be undone."
    action="Delete"
    wire-click="deleteComment"
/>
