<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Mail\IdeaStatusUpdatedMail;
use Illuminate\Support\Facades\Mail;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $notifyAllVotes;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $idea->status_id;
    }
    public function setStatus()
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            return;
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if ($this->notifyAllVotes) {
            $this->notifyAllVotes();
        }

        $this->dispatch('status-was-updated', 'Status was updated to ' . $this->idea->status->name);
    }

    public function notifyAllVotes()
    {
        $this->idea->votes()
            ->select('name', 'email')
            ->chunk(100, function ($voters) {
                foreach ($voters as $voter) {
                    Mail::to($voter->email)
                        ->queue(new IdeaStatusUpdatedMail($this->idea));
                }
            });
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
