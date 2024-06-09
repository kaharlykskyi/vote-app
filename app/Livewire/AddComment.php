<?php

namespace App\Livewire;

use App\Models\Idea;
use Livewire\Component;

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

        $this->idea->comments()->create([
            'user_id' => auth()->id(),
            'body' => $this->body
        ]);

        $this->body = '';

        $this->idea = Idea::find($this->idea->id); // Refresh the idea

        $this->dispatch('idea-was-commented', "Your comment was added!");
    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
