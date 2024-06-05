<?php

namespace App\Livewire;

use App\Models\Status;
use Illuminate\Support\Facades\Route;
use Livewire\Component;

class StatusFilters extends Component
{
    public $status = 'All';
    public $statusCount;

    protected $queryString = ['status'];

    public function mount()
    {
        $this->statusCount = Status::getCount();

        if(Route::currentRouteName() === 'idea.show') {
            $this->status = null;
            $this->queryString = [];
        }
    }

    public function setStatus(string $status)
    {
        $this->status = $status;

        // if($this->getPreviousRouteName() === 'idea.show') {
            return redirect()->route('idea.index', ['status' => $this->status]);
        // }
    }

    private function getPreviousRouteName()
    {
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }

    public function render()
    {
        return view('livewire.status-filters');
    }
}
