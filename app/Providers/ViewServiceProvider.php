<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use App\Models\Notification; // Tambahkan ini

class ViewServiceProvider extends ServiceProvider
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
        // Mengikat data 'unreadNotificationsCount' ke view 'layouts.sidebar'
        View::composer('layouts.sidebar', function ($view) {
            $unreadNotificationsCount = 0; // Default value
            if (Auth::check()) {
                // Hanya hitung jika user login
                $unreadNotificationsCount = Notification::where('user_id', Auth::id())
                                                        ->where('is_read', false)
                                                        ->count();
            }
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        });
    }
}