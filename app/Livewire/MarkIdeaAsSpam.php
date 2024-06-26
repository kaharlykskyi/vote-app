<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Illuminate\Http\Response;

class MarkIdeaAsSpam extends Component
{

    public Idea $idea;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function markAsSpam()
    {
        if (auth()->guest()) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->update([
            'spam_reports' => $this->idea->spam_reports + 1
        ]);

        $this->dispatch('idea-was-marked-as-spam', 'Idea was marked as spam');
    }

    public function render()
    {
        return view('livewire.mark-idea-as-spam');
    }
}
