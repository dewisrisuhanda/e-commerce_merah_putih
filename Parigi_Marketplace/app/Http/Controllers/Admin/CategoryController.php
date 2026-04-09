<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    /**
     * GET /admin/categories
     */
    public function index() {
        return Inertia::render('Admin/Categories/Index', ['categories' => $this->categoryService->getCategoriesWithCount()]);
    }

    /**
     * GET /admin/categories/create
     */
    public function create(): Response
    {
        return Inertia::render('Admin/Categories/Form');
    }

    /**
     * POST /admin/categories
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:categories,name'],
        ]);

        $this->categoryService->createCategory($request->only('name'));

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * GET /admin/categories/{id}/edit
     */
    public function edit(int $id): Response
    {
        $category = $this->categoryService->getCategoryById($id);
        abort_if(!$category, 404);

        return Inertia::render('Admin/Categories/Form', [
            'category' => $category,
        ]);
    }

    /**
     * PUT /admin/categories/{id}
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50', "unique:categories,name,{$id}"],
        ]);

        $this->categoryService->updateCategory($id, $request->only('name'));

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * DELETE /admin/categories/{id}
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->categoryService->deleteCategory($id);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
