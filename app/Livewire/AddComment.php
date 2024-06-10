<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Notifications\CommentAdded;

class AddComment extends Component
{

    public Idea $idea;

    public $body;

    protected $rules = [
        'body' => 'required|min:4'
    ];

    public function postComment()
    {
        if (auth()->guest()) {
            return redirect(route('login'));
        }

        $this->validate();

        $comment = $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'status_id' => 1,
            'body' => $this->body
        ]);

        $this->body = '';

        $this->idea = Idea::find($this->idea->id);

        $this->idea->user->notify(new CommentAdded($comment));

        $this->dispatch('idea-was-commented', [
            'id' => $comment->id,
            'text' => 'Comment was added!'
        ]);
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
