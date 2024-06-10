<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Illuminate\Http\Response;

class MarkCommentAsSpam extends Component
{

    public Comment $comment;

    protected $listeners = ['setMarkAsSpamComment'];

    public function setMarkAsSpamComment(int $id)
    {
        $this->comment = Comment::findOrFail($id);
        $this->dispatch('mark-as-spam-comment-was-set');
    }

    public function markAsSpam()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->comment->spam_reports++;
        $this->comment->save();

        $this->dispatch('comment-was-marked-as-spam', "Comment was marked as spam!");
    }

    public function render()
    {
        return view('livewire.mark-comment-as-spam');
    }
}
