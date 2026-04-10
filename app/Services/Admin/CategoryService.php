<?php

namespace App\Services\Admin;

interface CategoryService
{
    public function getCategoriesWithCount(): array;
    public function getCategoryById(int $id): ?array;
    public function createCategory(array $data): void;
    public function updateCategory(int $id, array $data): void;
    public function deleteCategory(int $id): void;
}
