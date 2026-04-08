<?php

namespace App\Providers;

use App\Services\CartService;
use App\Services\HomeService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        HomeService::class => \App\Services\Implements\HomeService::class,
        ProductService::class => \App\Services\Implements\ProductService::class,
        CartService::class => \App\Services\Implements\CartService::class,
        OrderService::class => \App\Services\Implements\OrderService::class,
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
