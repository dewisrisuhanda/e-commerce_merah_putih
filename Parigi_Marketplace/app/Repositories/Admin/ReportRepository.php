<?php

namespace App\Repositories\Admin;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;

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
}
