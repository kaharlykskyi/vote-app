<x-modal-confirm
    eventToOpenModal="custom-show-delete-modal"
    eventToCloseModal="idea-was-deleted"
    title="Delete idea"
    description="Are you sure you want to delete this idea? This action cannot be undone."
    action="Delete"
    wire-click="deleteIdea"
/>
