<?php

namespace App\Repositories;

use App\Models\Order;

class OrderRepository
{
    /**
     * Semua pesanan milik user, diurutkan terbaru.
     */
    public function getByUser(int $userId): array
    {
        return Order::where('user_id', $userId)
            ->with(['shippingMethod', 'paymentMethod'])
            ->latest()
            ->get()
            ->map(fn (Order $order) => [
                'id'           => $order->id,
                'order_number' => $order->order_number,
                'created_at'   => $order->created_at->format('d M Y, H:i'),
                'total_amount' => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                'status'       => $order->status,
                'items_count'  => $order->orderDetails()->count(),
            ])
            ->toArray();
    }

    /**
     * Satu pesanan milik user tertentu (security: user hanya lihat pesanannya sendiri).
     */
    public function findByUserAndId(int $userId, int $orderId): ?Order
    {
        return Order::where('user_id', $userId)
            ->where('id', $orderId)
            ->with(['shippingMethod', 'paymentMethod', 'orderDetails.product.primaryImage'])
            ->first();
    }

    /**
     * Format pesanan untuk halaman detail.
     */
    public function formatDetail(Order $order): array
    {
        return [
            'id'              => $order->id,
            'order_number'    => $order->order_number,
            'created_at'      => $order->created_at->format('d M Y, H:i'),
            'status'          => $order->status,
            'payment_method'  => $order->paymentMethod?->name ?? '-',
            'shipping_method' => $order->shippingMethod?->code ?? 'antar',
            'address'         => $order->address,
            'notes'           => $order->notes,
            'subtotal'        => 'Rp ' . number_format($order->subtotal, 0, ',', '.'),
            'shipping_cost'   => 'Rp ' . number_format($order->shipping_cost, 0, ',', '.'),
            'total_amount'    => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
            'items'           => $order->orderDetails->map(fn ($detail) => [
                'id'            => $detail->id,
                'product_id'    => $detail->product_id,
                'product_name'  => $detail->product_name,
                'product_price' => 'Rp ' . number_format($detail->product_price, 0, ',', '.'),
                'quantity'      => $detail->quantity,
                'subtotal'      => 'Rp ' . number_format($detail->subtotal, 0, ',', '.'),
                'image'         => $detail->product?->primaryImage?->url ?? null,
            ])->toArray(),
        ];
    }
}
