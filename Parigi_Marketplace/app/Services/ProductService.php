<?php

namespace App\Services;

interface ProductService
{
    public function getFilteredProducts(?string $category, ?string $keyword, int $perPage = 16): array;
    public function getAllCategories(): array;
    public function getProductBySlug(string $slug): ?array;
}
