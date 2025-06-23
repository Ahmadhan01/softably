<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import Facade View
use Illuminate\Support\Facades\Auth; // Import Facade Auth

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Bagikan variabel $loggedInUser ke SEMUA view
        View::composer('*', function ($view) {
            $view->with('loggedInUser', Auth::user());
        });
    }
}