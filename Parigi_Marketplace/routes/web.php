<?php

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

require __DIR__.'/auth.php';
