<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Pagination\LengthAwarePaginator;

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
//    public function getFilteredProducts(
//        ?string $category = null,
//        ?string $keyword = null,
//        int $perPage = 16
//    ) {
//        return Product::query()
//            ->with(['category', 'primaryImage'])
//            ->where('status', 'active')
//            ->when($category && $category !== 'All', function ($query) use ($category) {
//                $query->whereHas('category', fn ($query) => $query->where('name', $category));
//            })
//            ->when($keyword, function ($query) use ($keyword) {
//                $query->where('name', 'like', "%{$keyword}%")
//                    ->orWhere('description', 'like', "%{$keyword}%");
//            })
//            ->latest()
//            ->paginate($perPage);
//    }

    /**
     * Produk dengan filter + pagination.
     */
    public function getFilteredProducts(
        ?string $category = null,
        ?string $keyword = null,
        int $perPage = 16
    ): LengthAwarePaginator {
        return Product::query()
            ->with(['category', 'primaryImage'])
            ->where('status', 'ready')
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', fn ($q) => $q->where('name', $category));
            })
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString(); // penting: agar link pagination bawa filter
    }

    /**
     * Cari produk by slug.
     */
    public function findBySlug(string $slug): ?Product
    {
        return Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->first();
    }

    /**
     * Semua kategori aktif.
     */
    public function getAllCategories(): array
    {
        return Category::orderBy('name')
            ->get()
            ->map(fn ($cat) => [
                'id'   => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
            ])
            ->toArray();
    }

    /**
     * Format produk untuk list (index page).
     */
    public function formatProduct(Product $product): array
    {
        return [
            'id'       => $product->id,
            'name'     => $product->name,
            'slug'     => $product->slug,
            'category' => $product->category?->name ?? '',
            'price'    => 'Rp ' . number_format($product->price, 0, ',', '.'),
            'quantity' => $product->quantity,
            'image'    => $product->primaryImage?->url
                ?? null,
        ];
    }

    /**
     * Format produk untuk detail (show page).
     */
    public function formatProductDetail(Product $product): array
    {
        return [
            'id'          => $product->id,
            'name'        => $product->name,
            'slug'        => $product->slug,
            'category'    => $product->category?->name ?? '',
            'price'       => 'Rp ' . number_format($product->price, 0, ',', '.'),
            'quantity'    => $product->quantity,
            'description' => $product->description,
            'images'      => $product->images->map(fn ($img) => [
                'id'         => $img->id,
                'url'        => $img->url,
                'is_primary' => $img->is_primary,
            ])->toArray(),
        ];
    }
}
