<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class IdeaComments extends Component
{
    use WithPagination;

    public Idea $idea;

    public $listeners = [
        'idea-was-commented' => 'ideaWasCommented',
        'comment-was-deleted' => '$refresh',
        'status-was-updated' => '$refresh',
    ];

    public function mount(Idea $idea)
    {
        $this->idea = $idea;
    }

    public function ideaWasCommented()
    {
        $this->idea->refresh();
        $this->setPage($this->idea->comments()->paginate()->lastPage());
        $this->dispatch('scroll-to-comment');
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments()->with('user')->paginate()->withQueryString(),
        ]);
    }
}
