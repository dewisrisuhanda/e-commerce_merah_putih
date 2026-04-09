<?php

// ============================================================
// ROUTES — tambahkan ke routes/web.php
// ============================================================

// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//
//     // Dashboard
//     Route::get('/',                              [AdminDashboardController::class, 'index'])->name('dashboard');
//
//     // Products
//     Route::get('/products',                      [AdminProductController::class, 'index'])->name('products.index');
//     Route::get('/products/create',               [AdminProductController::class, 'create'])->name('products.create');
//     Route::post('/products',                     [AdminProductController::class, 'store'])->name('products.store');
//     Route::get('/products/{slug}/edit',          [AdminProductController::class, 'edit'])->name('products.edit');
//     Route::put('/products/{slug}',               [AdminProductController::class, 'update'])->name('products.update');
//     Route::delete('/products/{slug}',            [AdminProductController::class, 'destroy'])->name('products.destroy');
//
//     // Orders
//     Route::get('/orders',                        [AdminOrderController::class, 'index'])->name('orders.index');
//     Route::get('/orders/{id}',                   [AdminOrderController::class, 'show'])->name('orders.show');
//     Route::patch('/orders/{id}/status',          [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
//
//     // Users
//     Route::get('/users',                         [AdminUserController::class, 'index'])->name('users.index');
//
//     // Categories
//     Route::get('/categories',                    [AdminCategoryController::class, 'index'])->name('categories.index');
//
//     // Reports
//     Route::get('/reports/sales',                 [AdminReportController::class, 'sales'])->name('reports.sales');
//     Route::get('/reports/finance',               [AdminReportController::class, 'finance'])->name('reports.finance');
// });


// ============================================================
// MIDDLEWARE — role:admin
// Buat middleware untuk cek role admin
// app/Http/Middleware/EnsureUserIsAdmin.php
// ============================================================

// namespace App\Http\Middleware;
// use Closure;
// use Illuminate\Http\Request;
//
// class EnsureUserIsAdmin {
//     public function handle(Request $request, Closure $next) {
//         if (!auth()->check() || auth()->user()->role !== 'admin') {
//             abort(403);
//         }
//         return $next($request);
//     }
// }
//
// // Daftarkan di bootstrap/app.php:
// $middleware->alias(['role' => \App\Http\Middleware\EnsureUserIsAdmin::class]);


// ============================================================
// ADMIN DASHBOARD CONTROLLER
// app/Http/Controllers/Admin/AdminDashboardController.php
// ============================================================


// ============================================================
// ADMIN PRODUCT CONTROLLER
// app/Http/Controllers/Admin/AdminProductController.php
// ============================================================


// ============================================================
// ADMIN ORDER CONTROLLER
// app/Http/Controllers/Admin/AdminOrderController.php
// ============================================================


// ============================================================
// OTHER CONTROLLERS (Users, Categories, Reports)
// ============================================================

// AdminUserController

// AdminCategoryController

// AdminReportController


// ============================================================
// ADMIN REPOSITORY
// app/Repositories/Admin/AdminRepository.php
// ============================================================

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class AdminRepository
{
    // ── Dashboard ───────────────────────────────────────────

    public function getStats(): array
    {
        return [
            ['label' => 'Total Produk',   'value' => (string) Product::count(),                           'icon' => '📦', 'color' => 'bg-green-50'],
            ['label' => 'Total Pesanan',  'value' => (string) Order::count(),                             'icon' => '🛍️', 'color' => 'bg-blue-50'],
            ['label' => 'Pengguna',       'value' => (string) User::where('role', '!=', 'admin')->count(),'icon' => '👥', 'color' => 'bg-amber-50'],
            ['label' => 'Pendapatan',     'value' => 'Rp ' . number_format(Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.'), 'icon' => '💰', 'color' => 'bg-teal-50'],
        ];
    }

    public function getRecentProducts(int $limit = 5): array
    {
        return Product::with(['category', 'primaryImage'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($p) => [
                'id'       => $p->id,
                'slug'     => $p->slug,
                'name'     => $p->name,
                'category' => $p->category?->name ?? '',
                'price'    => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'quantity' => $p->quantity,
                'image'    => $p->primaryImage?->url,
                'status'   => $p->status,
            ])
            ->toArray();
    }

    public function getRecentOrders(int $limit = 6): array
    {
        return Order::with(['user', 'paymentMethod'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($o) => [
                'id'             => $o->id,
                'order_number'   => $o->order_number,
                'buyer_name'     => $o->user?->name ?? '-',
                'buyer_email'    => $o->user?->email ?? '-',
                'total_amount'   => 'Rp ' . number_format($o->total_amount, 0, ',', '.'),
                'payment_method' => $o->paymentMethod?->name ?? '-',
                'status'         => $o->status,
                'created_at'     => $o->created_at->format('d M Y'),
            ])
            ->toArray();
    }

    public function getCategoryCounts(): array
    {
        return Category::withCount('produk')
            ->get()
            ->map(fn ($c) => ['name' => $c->name, 'count' => $c->produk_count])
            ->toArray();
    }

    // ── Products ─────────────────────────────────────────────

    public function getAllProducts(): array
    {
        return Product::with(['category', 'primaryImage'])
            ->latest()
            ->get()
            ->map(fn ($p) => [
                'id'       => $p->id,
                'slug'     => $p->slug,
                'name'     => $p->name,
                'category' => $p->category?->name ?? '',
                'price'    => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'quantity' => $p->quantity,
                'image'    => $p->primaryImage?->url,
                'status'   => $p->status,
            ])
            ->toArray();
    }

    public function getProductBySlug(string $slug): ?array
    {
        $p = Product::where('slug', $slug)->first();
        if (!$p) return null;
        return [
            'id' => $p->id, 'slug' => $p->slug, 'name' => $p->name,
            'category_id' => $p->category_id, 'price' => $p->price,
            'quantity' => $p->quantity, 'description' => $p->description,
            'status' => $p->status,
            'image_url' => $p->primaryImage?->url ?? '',
        ];
    }

    public function createProduct(array $data): Product
    {
        $product = Product::create([
            'name'        => $data['name'],
            'slug'        => \Illuminate\Support\Str::slug($data['name']) . '-' . rand(100, 999),
            'category_id' => $data['category_id'],
            'price'       => $data['price'],
            'quantity'    => $data['quantity'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status'],
        ]);

        if (!empty($data['image_url'])) {
            $product->images()->create(['url' => $data['image_url'], 'is_primary' => true, 'order' => 0]);
        }

        return $product;
    }

    public function updateProduct(string $slug, array $data): void
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
            $product->images()->updateOrCreate(['is_primary' => true], ['url' => $data['image_url'], 'order' => 0]);
        }
    }

    public function deleteProduct(string $slug): void
    {
        Product::where('slug', $slug)->firstOrFail()->delete();
    }

    // ── Orders ───────────────────────────────────────────────

    public function getAllOrders(): array
    {
        return Order::with(['user', 'paymentMethod'])
            ->latest()
            ->get()
            ->map(fn ($o) => [
                'id'             => $o->id,
                'order_number'   => $o->order_number,
                'buyer_name'     => $o->user?->name ?? '-',
                'buyer_email'    => $o->user?->email ?? '-',
                'total_amount'   => 'Rp ' . number_format($o->total_amount, 0, ',', '.'),
                'created_at'     => $o->created_at->format('d M Y H:i'),
                'status'         => $o->status,
            ])
            ->toArray();
    }

    public function getOrderDetail(int $id): ?array
    {
        $o = Order::with(['user', 'shippingMethod', 'paymentMethod', 'orderDetails.product.primaryImage'])
            ->find($id);
        if (!$o) return null;

        return [
            'id'              => $o->id,
            'order_number'    => $o->order_number,
            'buyer_name'      => $o->user?->name ?? '-',
            'buyer_email'     => $o->user?->email ?? '-',
            'created_at'      => $o->created_at->format('d M Y H:i'),
            'status'          => $o->status,
            'payment_method'  => $o->paymentMethod?->name ?? '-',
            'shipping_method' => $o->shippingMethod?->code ?? 'antar',
            'address'         => $o->address,
            'subtotal'        => 'Rp ' . number_format($o->subtotal, 0, ',', '.'),
            'shipping_cost'   => 'Rp ' . number_format($o->shipping_cost, 0, ',', '.'),
            'total_amount'    => 'Rp ' . number_format($o->total_amount, 0, ',', '.'),
            'items'           => $o->orderDetails->map(fn ($d) => [
                'id'            => $d->id,
                'product_name'  => $d->product_name,
                'product_price' => 'Rp ' . number_format($d->product_price, 0, ',', '.'),
                'quantity'      => $d->quantity,
                'subtotal'      => 'Rp ' . number_format($d->subtotal, 0, ',', '.'),
                'image'         => $d->product?->primaryImage?->url,
            ])->toArray(),
        ];
    }

    public function updateOrderStatus(int $id, string $status): void
    {
        Order::findOrFail($id)->update(['status' => $status]);
    }

    // ── Users ─────────────────────────────────────────────────

    public function getAllUsers(): array
    {
        return User::latest()->get()->map(fn ($u) => [
            'id'         => $u->id,
            'name'       => $u->name,
            'email'      => $u->email,
            'address'    => $u->address,
            'role'       => $u->role,
            'created_at' => $u->created_at->format('d M Y'),
        ])->toArray();
    }

    // ── Categories ────────────────────────────────────────────

    public function getCategoriesWithCount(): array
    {
        return Category::withCount('produk')
            ->orderBy('name')
            ->get()
            ->map(fn ($c) => [
                'id'            => $c->id,
                'name'          => $c->name,
                'slug'          => $c->slug,
                'product_count' => $c->produk_count,
            ])
            ->toArray();
    }

    public function getCategories(): array
    {
        return Category::orderBy('name')->get(['id', 'name', 'slug'])->toArray();
    }

    // ── Reports ──────────────────────────────────────────────

    public function getSalesData(): array
    {
        return [
            'totalSold'    => (int) \App\Models\OrderDetail::sum('quantity'),
            'totalOrders'  => Order::where('status', 'completed')->count(),
            'totalRevenue' => 'Rp ' . number_format(Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.'),
            'products'     => $this->getAllProducts(),
        ];
    }

    public function getFinanceData(): array
    {
        return [
            'totalIncome'    => 'Rp ' . number_format(Order::where('status', 'completed')->sum('total_amount'), 0, ',', '.'),
            'totalPending'   => Order::where('status', 'pending_payment')->count(),
            'totalCanceled'  => Order::where('status', 'canceled')->count(),
            'transactions'   => $this->getAllOrders(),
        ];
    }
}


// ============================================================
// SERVICES (thin wrappers atas AdminRepository)
// Semua service tinggal inject AdminRepository
// ============================================================

// app/Services/Admin/AdminDashboardService.php
// app/Services/Admin/AdminProductService.php
// app/Services/Admin/AdminOrderService.php
// app/Services/Admin/AdminUserService.php
// app/Services/Admin/AdminCategoryService.php
// app/Services/Admin/AdminReportService.php
//
// Contoh AdminDashboardService:
//
// class AdminDashboardService {
//     public function __construct(private AdminRepository $repo) {}
//     public function getStats(): array { return $this->repo->getStats(); }
//     public function getRecentProducts(): array { return $this->repo->getRecentProducts(); }
//     public function getRecentOrders(): array { return $this->repo->getRecentOrders(); }
//     public function getCategoryCounts(): array { return $this->repo->getCategoryCounts(); }
// }
//
// Pola yang sama berlaku untuk semua service admin lainnya.


// ============================================================
// APP SERVICE PROVIDER — tambahkan binding admin services
// ============================================================

// public $singletons = [
//     // ... existing ...
//     \App\Services\Admin\AdminDashboardService::class => \App\Services\Admin\AdminDashboardService::class,
//     \App\Services\Admin\AdminProductService::class   => \App\Services\Admin\AdminProductService::class,
//     \App\Services\Admin\AdminOrderService::class     => \App\Services\Admin\AdminOrderService::class,
//     \App\Services\Admin\AdminUserService::class      => \App\Services\Admin\AdminUserService::class,
//     \App\Services\Admin\AdminCategoryService::class  => \App\Services\Admin\AdminCategoryService::class,
//     \App\Services\Admin\AdminReportService::class    => \App\Services\Admin\AdminReportService::class,
// ];
