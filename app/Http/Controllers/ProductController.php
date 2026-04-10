<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    private ProductService $productService;
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * GET /produk
     * Halaman list produk dengan filter & pagination.
     */
    public function index(Request $request): Response
    {
        $filters = [
            'search'   => $request->get('search', ''),
            'category' => $request->get('category', ''),
        ];

        return Inertia::render('Product/Index', [
            'products'   => $this->productService->getFilteredProducts(
                category: $filters['category'],
                keyword:  $filters['search'],
            ),
            'categories' => $this->productService->getAllCategories(),
            'filters'    => $filters,
        ]);
    }

    /**
     * GET /produk/{slug}
     * Halaman detail produk.
     */
    public function show(string $slug): Response
    {
        $product = $this->productService->getProductBySlug($slug);

        abort_if(!$product, 404);

        return Inertia::render('Product/Show', [
            'product' => $product,
        ]);
    }
}
