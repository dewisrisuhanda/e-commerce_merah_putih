<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getStats(): array
    {
        return [
            [
                'label' => 'Total Produk',
                'value' => (string) Product::count(),
                'icon'  => '📦',
                'color' => 'bg-green-50',
            ],
            [
                'label' => 'Total Pesanan',
                'value' => (string) Order::count(),
                'icon'  => '🛍️',
                'color' => 'bg-blue-50',
            ],
            [
                'label' => 'Pengguna',
                'value' => (string) User::where('role', '!=', 'admin')->count(),
                'icon'  => '👥',
                'color' => 'bg-amber-50',
            ],
            [
                'label' => 'Pendapatan',
                'value' => 'Rp ' . number_format(
                        Order::where('status', 'completed')->sum('total_amount'),
                        0, ',', '.'
                    ),
                'icon'  => '💰',
                'color' => 'bg-teal-50',
            ],
        ];
    }

    public function getRecentProducts(int $limit = 5): array
    {
        return Product::with(['category', 'primaryImage'])
            ->latest()
            ->limit($limit)
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

    public function getRecentOrders(int $limit = 6): array
    {
        return Order::with(['user', 'paymentMethod'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn (Order $order) => [
                'id'             => $order->id,
                'order_number'   => $order->order_number,
                'buyer_name'     => $order->user?->name ?? '-',
                'buyer_email'    => $order->user?->email ?? '-',
                'total_amount'   => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                'payment_method' => $order->paymentMethod?->name ?? '-',
                'status'         => $order->status,
                'created_at'     => $order->created_at->format('d M Y'),
            ])
            ->toArray();
    }

    public function getCategoryCounts(): array
    {
        return Category::withCount('products')
            ->orderByDesc('products_count')
            ->get()
            ->map(fn (Category $category) => [
                'name'  => $category->name,
                'count' => $category->products_count,
            ])
            ->toArray();
    }


    public function getDailyChartData(): array
    {
        // Ambil 7 hari terakhir (hari ini - 6 hari)
        $days = collect(range(6, 0))->map(fn ($i) => Carbon::today()->subDays($i));

        // Query total per hari dari DB
        $rows = Order::where('status', 'completed')
            ->whereBetween('created_at', [
                Carbon::today()->subDays(6)->startOfDay(),
                Carbon::today()->endOfDay(),
            ])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->pluck('total', 'date'); // ['2026-04-04' => 520000, ...]

        $labels = [];
        $data   = [];

        $dayNames = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

        foreach ($days as $day) {
            $labels[] = $dayNames[$day->dayOfWeek];
            $data[]   = (int) ($rows[$day->toDateString()] ?? 0);
        }

        return compact('labels', 'data');
    }
}
