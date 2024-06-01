<?php

namespace App\Livewire;

use App\Models\Idea;
use App\Models\Vote;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    // use WithPagination;

    public function render()
    {
        $statuses = Status::pluck('id', 'name');

        $ideas = Idea::with(['user', 'category', 'status'])
            ->addSelect(['voted_by_user' => Vote::select('id')
                ->where('user_id', auth()->id())
                ->whereColumn('idea_id', 'ideas.id')
            ])
            ->when(request()->status && request()->status !== 'All', function($query) use ($statuses) {
                return $query->where('status_id', $statuses->get(request()->status));
            })
            ->withCount('votes')
            ->orderBy('id', 'desc')
            ->simplePaginate(Idea::PAGINATION_COUNT);

        return view('livewire.ideas-index', compact('ideas'));
    }
}
