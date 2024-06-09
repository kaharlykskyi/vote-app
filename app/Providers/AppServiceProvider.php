<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('admin', function () {
            return !auth()->guest() && auth()->user()->isAdmin();
        });
    }
}
