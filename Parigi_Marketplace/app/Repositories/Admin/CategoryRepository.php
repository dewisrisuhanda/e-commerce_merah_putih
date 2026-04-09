<?php

namespace App\Repositories\Admin;

use App\Models\Category;

class CategoryRepository
{
    public function getAllWithCount(): array
    {
        return Category::withCount('products')
            ->orderBy('name')
            ->get()
            ->map(fn (Category $category) => [
                'id'            => $category->id,
                'name'          => $category->name,
                'slug'          => $category->slug,
                'product_count' => $category->products_count,
            ])
            ->toArray();
    }
}
