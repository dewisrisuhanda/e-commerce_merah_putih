<?php

namespace App\Providers;

use App\Services\HomeService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        HomeService::class => \App\Services\Implements\HomeService::class,
        ProductService::class => \App\Services\Implements\ProductService::class,
    ];
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
        Vite::prefetch(concurrency: 3);
    }
}
