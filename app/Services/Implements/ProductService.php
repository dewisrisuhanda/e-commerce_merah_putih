<?php

namespace App\Services\Implements;

use App\Repositories\ProductRepository;

class ProductService implements \App\Services\ProductService
{
    private ProductRepository $productRepository;
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Produk terfilter dengan format siap untuk Inertia.
     */
    public function getFilteredProducts(
        ?string $category = null,
        ?string $keyword = null,
        int $perPage = 16
    ): array {
        $paginator = $this->productRepository->getFilteredProducts($category, $keyword, $perPage);

        // Transform data produk di dalam paginator
        $paginator->getCollection()->transform(fn ($product) =>
        $this->productRepository->formatProduct($product)
        );

        return $paginator->toArray();
    }

    /**
     * Semua kategori untuk filter tab.
     */
    public function getAllCategories(): array
    {
        return $this->productRepository->getAllCategories();
    }

    /**
     * Detail satu produk by slug.
     */
    public function getProductBySlug(string $slug): ?array
    {
        $product = $this->productRepository->findBySlug($slug);

        if (!$product) return null;

        return $this->productRepository->formatProductDetail($product);
    }
}
