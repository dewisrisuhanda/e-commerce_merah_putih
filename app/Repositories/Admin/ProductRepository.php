<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductRepository
{
    public function getAll(): array
    {
        return Product::with(['category', 'primaryImage'])
            ->latest()
            ->get()
            ->map(fn (Product $product) => [
                'id'       => $product->id,
                'slug'     => $product->slug,
                'name'     => $product->name,
                'category' => $product->category?->name ?? '',
                'price'    => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'quantity' => $product->quantity,
                'image'    => $product->primaryImage?->url ?? null,
                'status'   => $product->status,
            ])
            ->toArray();
    }

    public function findBySlug(string $slug): ?array
    {
        $product = Product::with(['category', 'primaryImage'])
            ->where('slug', $slug)
            ->first();

        if (!$product) return null;

        return [
            'id'          => $product->id,
            'slug'        => $product->slug,
            'name'        => $product->name,
            'category_id' => $product->category_id,
            'price'       => $product->price,
            'quantity'    => $product->quantity,
            'description' => $product->description,
            'status'      => $product->status,
            'image_url'   => $product->primaryImage?->url ?? '',
        ];
    }

    public function create(array $data): Product
    {
        $product = Product::create([
            'name'        => $data['name'],
            'slug'        => Str::slug($data['name']) . '-' . rand(100, 999),
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
        ]);

        if (!empty($data['image_url'])) {
            $product->images()->create([
                'url'        => $data['image_url'],
                'is_primary' => true,
                'order'      => 0,
            ]);
        }

        return $product;
    }

    public function update(string $slug, array $data): void
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $product->update([
            'name'        => $data['name'],
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
        ]);

        if (!empty($data['image_url'])) {
            $product->images()->updateOrCreate(
                ['is_primary' => true],
                ['url' => $data['image_url'], 'order' => 0]
            );
        }
    }

    public function delete(string $slug): void
    {
        Product::where('slug', $slug)->firstOrFail()->delete();
    }

    public function getAllCategories(): array
    {
        return Category::orderBy('name')->get(['id', 'name', 'slug'])->toArray();
    }
}
