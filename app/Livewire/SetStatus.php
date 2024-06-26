<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Mail\IdeaStatusUpdatedMail;
use App\Models\Comment;
use Illuminate\Support\Facades\Mail;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $notifyAllVotes;

    public $comment = null;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
        $this->status = $idea->status_id;
    }
    public function setStatus()
    {
        if (auth()->guest() || !auth()->user()->isAdmin()) {
            abort(403);
        }

        if($this->idea->status_id === (int) $this->status) {
            $this->dispatch('status-was-updated-error', "Status is already set to {$this->idea->status->name}");
            return;
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if ($this->notifyAllVotes) {
            $this->notifyAllVotes();
        }

        $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'status_id' => $this->status,
            'is_status_update' => true,
            'body' => $this->comment ?? Comment::EMPTY_UPDATE_STATUS_MESSAGE,
        ]);

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
