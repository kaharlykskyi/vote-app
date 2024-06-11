<?php

namespace App\Livewire;

use App\Livewire\Traits\WithAuthRedirects;
use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{

    use WithAuthRedirects;

    public Idea $idea;
    public $votesCount;
    public $hasVoted;

    public $listeners = [
        'status-was-updated' => '$refresh',
        'idea-was-updated' => '$refresh',
        'idea-was-deleted' => '$refresh',
        'idea-was-marked-as-spam' => '$refresh',
        'idea-was-marked-as-not-spam' => '$refresh',
        'idea-was-commented' => '$refresh',
        'comment-was-deleted' => '$refresh',
    ];

    public function mount(int $votesCount)
    {
        $this->votesCount = $votesCount;
        $this->hasVoted = $this->idea->isVotedByUser(auth()->user());
    }

    public function vote()
    {
        if (auth()->guest()) {
            return $this->redirectToLogin();
        }

        if ($this->hasVoted) {
            $this->idea->removeVote(user: auth()->user());
            $this->hasVoted = false;
            $this->votesCount--;
        } else {
            $this->idea->vote(user: auth()->user());
            $this->hasVoted = true;
            $this->votesCount++;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
