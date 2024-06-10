<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Comment;
use Livewire\Component;

class IdeaComments extends Component
{
    public Idea $idea;

    public $comments;

    public $listeners = [
        'idea-was-commented' => 'ideaWasCommented',
    ];

    public function ideaWasCommented(array $event)
    {
        $this->idea->refresh();
        $this->comments->push(Comment::find($event['id']));
        $this->dispatch('scroll-to-comment');
    }

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->comments = $this->idea->comments()->with('user')->get();
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->comments,
        ]);
    }
}
