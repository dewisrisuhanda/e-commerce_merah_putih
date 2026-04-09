<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\CategoryRepository;

class CategoryService implements \App\Services\Admin\CategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getCategoriesWithCount(): array
    {
        return $this->categoryRepository->getAllWithCount();
    }

    public function getCategoryById(int $id): ?array
    {
        $category = $this->categoryRepository->findById($id);
        if (!$category) return null;

        return [
            'id'   => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ];
    }

    public function createCategory(array $data): void
    {
        $this->categoryRepository->create($data);
    }

    public function updateCategory(int $id, array $data): void
    {
        $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory(int $id): void
    {
        $this->categoryRepository->delete($id);
    }
}
