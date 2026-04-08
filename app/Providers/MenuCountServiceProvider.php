<?php

namespace App\Providers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class MenuCountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer('includes.admin.sidebar', function (View $view) {
            $view->with([
                'user_count' => User::count(),
                'organization_count' => Organization::count()
            ]);
        });
    }
}
