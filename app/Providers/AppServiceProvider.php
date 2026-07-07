<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Role;
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
        Route::model('role', \App\Models\Role::class);
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('wishlistCount', \App\Models\Wishlist::where('user_id', auth()->id())->count());
            } else {
                $view->with('wishlistCount', 0);
            }
        });
    }
}
