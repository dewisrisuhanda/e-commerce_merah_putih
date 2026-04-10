<?php

namespace App\Providers;

use App\Services\Admin\CategoryService;
use App\Services\Admin\DashboardService;
use App\Services\Admin\ReportService;
use App\Services\Admin\UserService;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\HomeService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $singletons = [
        HomeService::class => \App\Services\Implements\HomeService::class,
        ProductService::class => \App\Services\Implements\ProductService::class,
        CartService::class => \App\Services\Implements\CartService::class,
        OrderService::class => \App\Services\Implements\OrderService::class,

        CategoryService::class => \App\Services\Admin\Implements\CategoryService::class,
        DashboardService::class => \App\Services\Admin\Implements\DashboardService::class,
        ReportService::class => \App\Services\Admin\Implements\ReportService::class,
        UserService::class => \App\Services\Admin\Implements\UserService::class,
        \App\Services\Admin\OrderService::class => \App\Services\Admin\Implements\OrderService::class,
        \App\Services\Admin\ProductService::class => \App\Services\Admin\Implements\ProductService::class,

        CheckoutService::class => \App\Services\Implements\CheckoutService::class,
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
        URL::forceScheme('https');
    }
}
