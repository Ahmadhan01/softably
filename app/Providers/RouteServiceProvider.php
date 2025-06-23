<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Http\Middleware\RoleMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        Route::aliasMiddleware('role', RoleMiddleware::class);

        $this->routes(function () {
            // Web
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Admin
            Route::middleware(['web', 'auth', 'role:admin']) // middleware custom
                ->prefix('admin')
                ->as('admin.')
                ->group(base_path('routes/web.php'));

            // Seller
            Route::middleware(['web', 'auth', 'role:seller'])
                ->prefix('seller')
                ->as('seller.')
                ->group(base_path('routes/web.php'));

            // Customer
            Route::middleware(['web', 'auth', 'role:customer'])
                ->prefix('customer')
                ->as('customer.')
                ->group(base_path('routes/web.php'));
        });
    }
}