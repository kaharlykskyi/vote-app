<?php

namespace App\Livewire;

use App\Livewire\Traits\WithAuthRedirects;
use App\Models\Comment;
use App\Notifications\CommentLiked;
use Livewire\Component;

class LikeComment extends Component
{
    use  WithAuthRedirects;

    public Comment $comment;

    public $likeCount;

    public $isLiked;

    public function mount(Comment $comment)
    {
        $this->comment = $comment;
        $this->likeCount = $comment->likes->count();
        $this->isLiked = $comment->isLikedByUser(auth()->user());
    }

    public function toggleLike()
    {
        if (auth()->guest()) {
            return $this->redirectToLogin();
        }

        if ($this->comment->isLikedByUser(auth()->user())) {
            $this->comment->unLike(auth()->user());
            $this->likeCount--;
            $this->isLiked = false;
        } else {
            $this->comment->like(auth()->user());
            if($this->comment->user->id !== auth()->user()->id) {
                $this->comment->user->notify(new CommentLiked($this->comment, auth()->user()));
            }
            $this->likeCount++;
            $this->isLiked = true;
        }
    }

    public function render()
    {
        return view('livewire.like-comment');
    }
}
