<x-modal-confirm
    eventToOpenModal="custom-show-delete-modal"
    eventToCloseModal="ideaWasDeleted"
    title="Delete idea"
    description="Are you sure you want to delete this idea? This action cannot be undone."
    action="Delete"
    wire-click="deleteIdea"
/>
