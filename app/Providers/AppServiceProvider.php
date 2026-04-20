<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register CartService as singleton
        $this->app->singleton(\App\Services\CartService::class, function () {
            return new \App\Services\CartService();
        });
    }

    public function boot(): void
    {
        // Use our custom pagination views
        Paginator::defaultView('vendor.pagination.default');
    }
}
