<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Http\Response;

class MarkCommentAsNotSpam extends Component
{
    public Comment $comment;

    protected $listeners = ['setMarkAsNotSpamComment'];

    public function setMarkAsNotSpamComment(int $id)
    {
        $this->comment = Comment::findOrFail($id);
        $this->dispatch('mark-as-not-spam-comment-was-set');
    }

    public function markAsNotSpam()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->comment->spam_reports = 0;
        $this->comment->save();

        $this->dispatch('comment-was-marked-as-not-spam', "Comment was marked as not spam!");
    }
    public function render()
    {
        return view('livewire.mark-comment-as-not-spam');
    }
}
