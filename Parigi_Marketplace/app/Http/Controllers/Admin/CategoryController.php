<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index() {
        return Inertia::render('Admin/Categories/Index', ['categories' => $this->categoryService->getCategoriesWithCount()]);
    }
}
