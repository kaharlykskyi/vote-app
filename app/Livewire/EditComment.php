<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Http\Response;

class EditComment extends Component
{
    public Comment $comment;

    public $body;

    protected $listeners = ['setEditComment'];

    protected $rules = [
        'body' => 'required|min:4'
    ];

    public function setEditComment(int $id)
    {
        $this->comment = Comment::findOrFail($id);
        $this->body = $this->comment->body;
        $this->dispatch('edit-comment-was-set');
    }

    public function updateComment()
    {
        if (auth()->guest() || auth()->user()->cannot('update', $this->comment)) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to update this comment.');
        }

        $this->validate();

        $this->comment->update(['body' => $this->body]);

        $this->dispatch('comment-was-updated', "Comment was updated successfully!");
    }

    public function render()
    {
        return view('livewire.edit-comment');
    }
}
