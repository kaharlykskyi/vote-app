<?php

namespace App\Livewire;

use Livewire\Component;

class Notifications extends Component
{

    public $notifications;
    public $loading = true;

    protected $listeners = [
        'fetch-notifications' => 'fetchNotifications'
    ];

    public function fetchNotifications()
    {
        usleep(rand(100000, 600000));
        $this->notifications = auth()->user()->unreadNotifications;
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.notifications');
    }
}
