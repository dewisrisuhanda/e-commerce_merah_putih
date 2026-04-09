<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use Illuminate\Support\Str;

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

    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }

    public function update(int $id, array $data): void
    {
        Category::findOrFail($id)->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);
    }

    public function delete(int $id): void
    {
        Category::findOrFail($id)->delete();
    }

    public function isSlugUnique(string $slug, ?int $excludeId = null): bool
    {
        $query = Category::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        return $query->doesntExist();
    }
}
