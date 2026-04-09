<?php

namespace App\Services\Admin;

interface ProductService
{
    public function getAllProducts(): array;
    public function getProductBySlug(string $slug): ?array;
    public function getCategories(): array;
    public function createProduct(array $data): void;
    public function updateProduct(string $slug, array $data): void;
    public function deleteProduct(string $slug): void;
}
