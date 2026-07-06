<?php

namespace App\Providers;

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
        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $view->with('wishlistCount', \App\Models\Wishlist::where('user_id', auth()->id())->count());
            } else {
                $view->with('wishlistCount', 0);
            }
        });
    }
}
