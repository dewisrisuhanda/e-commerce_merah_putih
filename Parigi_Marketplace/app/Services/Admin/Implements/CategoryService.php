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
}
