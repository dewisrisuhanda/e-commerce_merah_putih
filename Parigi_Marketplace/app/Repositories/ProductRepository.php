<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Broadcasting\PrivateChannel;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getBestProducts(int $limit = 12): array
    {
        return Product::query()
            ->with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->where('quantity', '>', 0)
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn (Product $product) => [
                'id'           => $product->id,
                'name'         => $product->name,
                'category'     => $product->category?->name ?? 'Lainnya',
                'category_slug'=> $product->category?->slug ?? 'lainnya',
                'price'        => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'image'         => $product->primaryImage?->url
                    ?? 'https://placehold.co/400x300/e8f5e9/2e7d32?text=' . urlencode($product->nama),
            ])
            ->toArray();
    }

    /**
     * Hitung total produk aktif.
     */
    public function getCountActiveProduct(): int
    {
        return Product::where('status', 'active')->count();
    }

    /**
     * Ambil produk dengan filter kategori & keyword (untuk halaman produk).
     */
    public function getFilteredProducts(
        ?string $category = null,
        ?string $keyword = null,
        int $perPage = 16
    ) {
        return Product::query()
            ->with(['category', 'primaryImage'])
            ->where('status', 'active')
            ->when($category && $category !== 'All', function ($query) use ($category) {
                $query->whereHas('category', fn ($query) => $query->where('name', $category));
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate($perPage);
    }
}
