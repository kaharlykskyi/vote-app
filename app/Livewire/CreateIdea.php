<?php

namespace App\Livewire;

use App\Livewire\Traits\WithAuthRedirects;
use App\Models\Idea;
use Livewire\Component;
use App\Models\Category;

class CreateIdea extends Component
{

    use WithAuthRedirects;

    public $title;
    public $description;

    public $category = 1;

    protected $rules = [
        'title' => 'required|min:4',
        'category' => 'required|integer|exists:categories,id',
        'description' => 'required|min:4',
    ];

    public function createIdea()
    {
        if(auth()->guest()) abort(403, 'You must be logged in to create an idea.');

        $this->validate();

        $idea = Idea::create([
            'category_id' => $this->category,
            'user_id' => auth()->id(),
            'status_id' => 1,
            'title' => $this->title,
            'description' => $this->description,
        ]);

        $idea->vote(user: auth()->user());

        session()->flash('success_message', 'Idea was added successfully!');

        $this->reset();

        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.create-idea',[
            'categories' => Category::all()
        ]);
    }
}
