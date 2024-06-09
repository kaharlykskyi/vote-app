<x-modal-confirm
    eventToOpenModal="custom-show-mark-idea-as-not-spam-modal"
    eventToCloseModal="idea-was-marked-as-not-spam"
    title="Reset Spam Counter"
    description="Are you sure you want to mark this idea as NOT spam? This will reset the spam counter to 0."
    action="Reset Spam Counter"
    wire-click="markAsNotSpam"
/>
