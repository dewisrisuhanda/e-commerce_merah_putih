<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\ProductRepository;

class ProductService implements \App\Services\Admin\ProductService
{
    public function __construct(
        private ProductRepository $productRepository
    ) {}

    public function getAllProducts(): array
    {
        return $this->productRepository->getAll();
    }

    public function getProductBySlug(string $slug): ?array
    {
        return $this->productRepository->findBySlug($slug);
    }

    public function getCategories(): array
    {
        return $this->productRepository->getAllCategories();
    }

    public function createProduct(array $data): void
    {
        $this->productRepository->create($data);
    }

    public function updateProduct(string $slug, array $data): void
    {
        $this->productRepository->update($slug, $data);
    }

    public function deleteProduct(string $slug): void
    {
        $this->productRepository->delete($slug);
    }
}
