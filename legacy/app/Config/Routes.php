<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('beranda');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->get('/', 'Home::beranda');
$routes->get('produk', 'Home::index');
$routes->get('produk/(:num)', 'Home::detail/$1');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginProcess');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::registerProcess');
$routes->get('logout', 'Auth::logout');
$routes->get('keranjang', 'Cart::index');
$routes->post('keranjang/tambah', 'Cart::tambah');
$routes->post('keranjang/hapus', 'Cart::hapus');
$routes->post('keranjang/update', 'Cart::update');
$routes->get('checkout', 'Order::checkout');
$routes->post('checkout/proses', 'Order::proses');
$routes->get('pesanan', 'Order::riwayat');
$routes->get('pesanan/(:num)', 'Order::detail/$1');

$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    // Produk
    $routes->get('produk', 'Admin\Products::index');
    $routes->get('produk/tambah', 'Admin\Products::tambah');
    $routes->post('produk/simpan', 'Admin\Products::simpan');
    $routes->get('produk/edit/(:num)', 'Admin\Products::edit/$1');
    $routes->post('produk/update/(:num)', 'Admin\Products::update/$1');
    $routes->get('produk/hapus/(:num)', 'Admin\Products::hapus/$1');
    // Pesanan
    $routes->get('pesanan', 'Admin\Orders::index');
    $routes->get('pesanan/(:num)', 'Admin\Orders::detail/$1');
    $routes->post('pesanan/status', 'Admin\Orders::updateStatus');
    // Kelola
    $routes->get('kelola/pengguna', 'Admin\Kelola::pengguna');
    $routes->get('kelola/kategori', 'Admin\Kelola::kategori');
    // Laporan
    $routes->get('laporan/penjualan', 'Admin\Laporan::penjualan');
    $routes->get('laporan/keuangan', 'Admin\Laporan::keuangan');
});
