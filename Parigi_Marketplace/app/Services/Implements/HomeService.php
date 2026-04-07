<?php

namespace App\Services\Implements;

use App\Repositories\ProductRepository;

class HomeService implements \App\Services\HomeService
{
    private ProductRepository $productRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Ambil produk unggulan untuk ditampilkan di beranda.
     * Mengambil 12 produk aktif terbaru dari setiap kategori.
     */
    public function getBestProducts(): array
    {
        return $this->productRepository->getBestProducts(limit: 12);
    }

    /**
     * Total produk aktif untuk ditampilkan di stats / badge.
     */
    public function getTotalActiveProduct(): int
    {
        return $this->productRepository->getCountActiveProduct();
    }
}
