<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class DeleteComment extends Component
{
    public Comment $comment;

    protected $listeners = ['setDeleteComment'];

    public function setDeleteComment(int $id)
    {
        $this->comment = Comment::findOrFail($id);
        $this->dispatch('delete-comment-was-set');
    }

    public function deleteComment()
    {
        $this->comment->delete();
        $this->dispatch('comment-was-deleted', "Comment was deleted successfully!");
    }

    public function render()
    {
        return view('livewire.delete-comment');
    }
}
