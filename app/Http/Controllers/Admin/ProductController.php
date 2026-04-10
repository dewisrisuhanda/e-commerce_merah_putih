<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index()
    {
        return Inertia::render('Admin/Products/Index', [
            'products' => $this->productService->getAllProducts(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Products/Form', [
            'categories' => $this->productService->getCategories(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price'       => ['required', 'numeric', 'min:0'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:ready,out_of_stock,discontinued'],
            'image_url'   => ['nullable', 'url'],
        ]);

        $this->productService->createProduct($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(string $slug)
    {
        return Inertia::render('Admin/Products/Form', [
            'product'    => $this->productService->getProductBySlug($slug),
            'categories' => $this->productService->getCategories(),
        ]);
    }

    public function update(Request $request, string $slug)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price'       => ['required', 'numeric', 'min:0'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:ready,out_of_stock,discontinued'],
            'image_url'   => ['nullable', 'url'],
        ]);

        $this->productService->updateProduct($slug, $validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(string $slug)
    {
        $this->productService->deleteProduct($slug);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
