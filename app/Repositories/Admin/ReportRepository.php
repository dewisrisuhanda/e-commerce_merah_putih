<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function getSalesStats(): array
    {
        return [
            'total_sold'    => (int) OrderDetail::sum('quantity'),
            'total_orders'  => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
        ];
    }

    public function getProductList(): array
    {
        return Product::with('category')
            ->latest()
            ->get()
            ->map(fn (Product $p) => [
                'name'     => $p->name,
                'category' => $p->category?->name ?? '-',
                'price'    => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'quantity' => $p->quantity,
            ])
            ->toArray();
    }

    public function getFinanceStats(): array
    {
        return [
            'total_income'   => Order::where('status', 'completed')->sum('total_amount'),
            'total_pending'  => Order::where('status', 'pending_payment')->count(),
            'total_canceled' => Order::where('status', 'canceled')->count(),
        ];
    }

    public function getTransactions(): array
    {
        return Order::with(['user', 'paymentMethod', 'shippingMethod'])
            ->latest()
            ->get()
            ->map(fn (Order $order) => [
                'id'              => $order->id,
                'order_number'    => $order->order_number,
                'buyer_name'      => $order->user?->name ?? '-',
                'total_amount'    => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                'payment_method'  => $order->paymentMethod?->name ?? '-',
                'shipping_method' => $order->shippingMethod?->code ?? 'antar',
                'status'          => $order->status,
            ])
            ->toArray();
    }

    public function getMonthlyChartData(int $year = null): array
    {
        $year = $year ?? Carbon::now()->year;

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        // Query total per bulan dari DB
        $rows = Order::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('month')
            ->pluck('total', 'month'); // [1 => 2100000, 3 => 4500000, ...]

        $labels = [];
        $data   = [];

        foreach (range(1, 12) as $month) {
            $labels[] = $monthNames[$month - 1];
            $data[]   = (int) ($rows[$month] ?? 0);
        }

        return compact('labels', 'data');
    }
}
