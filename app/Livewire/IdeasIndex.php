<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Idea;
use App\Models\Vote;
use App\Models\Status;
use Livewire\Component;
use Livewire\WithPagination;

class IdeasIndex extends Component
{
    use WithPagination;
    public $status;
    public $category;
    public $filter;
    public $search;

    protected $queryString = ['status', 'category', 'filter', 'search'];

    protected $listeners = ['queryStringUpdatedStatus'];

    public function mount()
    {
        $this->status = request()->status ?? 'All';
        $this->category = request()->category ?? 'All Categories';
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedFilter()
    {
        if($this->filter == 'My Ideas' && auth()->guest()) {
            return redirect()->route('login');
        }
    }

    public function queryStringUpdatedStatus($newStatus)
    {
        $this->resetPage();
        $this->status = $newStatus;
    }

    public function render()
    {
        $statuses = Status::pluck('id', 'name');
        $categories = Category::all();

        $ideas = Idea::with(['user', 'category', 'status'])
            ->addSelect(['voted_by_user' => Vote::select('id')
                ->where('user_id', auth()->id())
                ->whereColumn('idea_id', 'ideas.id')
            ])
            ->when($this->status && $this->status !== 'All', function($query) use ($statuses) {
                return $query->where('status_id', $statuses->get($this->status));
            })
            ->when($this->category && $this->category !== 'All Categories', function($query) use ($categories) {
                return $query->where('category_id', $categories->pluck('id', 'name')->get($this->category));
            })
            ->when($this->filter && $this->filter == 'Top Voted', function($query) {
                return $query->orderByDesc('votes_count');
            })
            ->when($this->filter && $this->filter == 'My Ideas', function($query) {
                return $query->where('user_id', auth()->id());
            })
            ->when(strlen($this->search) >= 3, function($query) {
                return $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
            })
            ->withCount('votes')
            ->orderBy('id', 'desc')
            ->simplePaginate(Idea::PAGINATION_COUNT);



        return view('livewire.ideas-index', compact('ideas', 'categories'));
    }
}