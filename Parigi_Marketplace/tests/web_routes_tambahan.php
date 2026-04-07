<?php

// Tambahkan ke routes/web.php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController; // nanti dibuat
use Illuminate\Support\Facades\Route;

// Beranda
Route::get('/', [BerandaController::class, 'index'])->name('home');

// Produk (perlu dibuat ProdukController nanti)
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{produk:slug}', [ProdukController::class, 'show'])->name('produk.show');
