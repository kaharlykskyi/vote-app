<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Comment;
use Livewire\Component;

class IdeaComment extends Component
{

    public Comment $comment;
    public $ideaUserId;

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
