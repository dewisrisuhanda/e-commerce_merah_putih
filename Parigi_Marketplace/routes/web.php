<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome');
//});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

 Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
 Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/cart',          [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart',         [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart',        [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart',       [CartController::class, 'destroy'])->name('cart.destroy');

    // Orders
    Route::get('/orders',        [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',   [OrderController::class, 'show'])->name('orders.show');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/',                              [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products',                      [\App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',               [\App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/products',                     [\App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{slug}/edit',          [\App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{slug}',               [\App\Http\Controllers\Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{slug}',            [\App\Http\Controllers\Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Orders
    Route::get('/orders',                        [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}',                   [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status',          [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Users
    Route::get('/users',                         [UserController::class, 'index'])->name('users.index');

    // Categories
    Route::get('/categories',                    [CategoryController::class, 'index'])->name('categories.index');

    // Reports
    Route::get('/reports/sales',                 [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/finance',               [ReportController::class, 'finance'])->name('reports.finance');
});

require __DIR__.'/auth.php';
