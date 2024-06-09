<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $hasVoted;

    public $listeners = [
        'status-was-updated' => '$refresh',
        'idea-was-updated' => '$refresh',
        'idea-was-deleted' => '$refresh',
        'idea-was-marked-as-spam' => '$refresh',
        'idea-was-marked-as-not-spam' => '$refresh',
    ];

    public function mount(Idea $idea, int $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function vote()
    {
        if (!auth()->check()) {
            return redirect(route('login'));
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
