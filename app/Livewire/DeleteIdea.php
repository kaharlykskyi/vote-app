<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

class DeleteIdea extends Component
{
    public Idea $idea;

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function deleteIdea()
    {
        if (auth()->guest() || auth()->user()->cannot('delete', $this->idea)) {
            abort(Response::HTTP_FORBIDDEN, 'You are not allowed to delete this idea.');
        }

        Idea::destroy($this->idea->id);

        return redirect()->route('idea.index');
    }
    public function render()
    {
        return view('livewire.delete-idea');
    }
}
