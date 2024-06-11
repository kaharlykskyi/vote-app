<?php

namespace App\Livewire;

use App\Models\Comment;
use Livewire\Component;

class IdeaComment extends Component
{
    public Comment $comment;

    public $ideaUserId;

    public $listeners = [
        'comment-was-updated' => '$refresh',
        'comment-was-marked-as-spam' => '$refresh',
        'comment-was-marked-as-not-spam' => '$refresh',
    ];

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
