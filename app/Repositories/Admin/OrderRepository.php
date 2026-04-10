<?php

namespace App\Repositories\Admin;

use App\Models\Order;

class OrderRepository
{
    public function getAll(): array
    {
        return Order::with(['user', 'paymentMethod'])
            ->latest()
            ->get()
            ->map(fn (Order $order) => [
                'id'             => $order->id,
                'order_number'   => $order->order_number,
                'buyer_name'     => $order->user?->name ?? '-',
                'buyer_email'    => $order->user?->email ?? '-',
                'total_amount'   => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
                'created_at'     => $order->created_at->format('d M Y H:i'),
                'status'         => $order->status,
            ])
            ->toArray();
    }

    public function findById(int $id): ?Order
    {
        return Order::with([
            'user',
            'shippingMethod',
            'paymentMethod',
            'orderDetails.product.primaryImage',
        ])->find($id);
    }

    public function formatDetail(Order $order): array
    {
        return [
            'id'              => $order->id,
            'order_number'    => $order->order_number,
            'buyer_name'      => $order->user?->name ?? '-',
            'buyer_email'     => $order->user?->email ?? '-',
            'created_at'      => $order->created_at->format('d M Y H:i'),
            'status'          => $order->status,
            'payment_method'  => $order->paymentMethod?->name ?? '-',
            'shipping_method' => $order->shippingMethod?->code ?? 'antar',
            'address'         => $order->address,
            'subtotal'        => 'Rp ' . number_format($order->subtotal, 0, ',', '.'),
            'shipping_cost'   => 'Rp ' . number_format($order->shipping_cost, 0, ',', '.'),
            'total_amount'    => 'Rp ' . number_format($order->total_amount, 0, ',', '.'),
            'items'           => $order->orderDetails->map(fn ($orderDetail) => [
                'id'            => $orderDetail->id,
                'product_name'  => $orderDetail->product_name,
                'product_price' => 'Rp ' . number_format($orderDetail->product_price, 0, ',', '.'),
                'quantity'      => $orderDetail->quantity,
                'subtotal'      => 'Rp ' . number_format($orderDetail->subtotal, 0, ',', '.'),
                'image'         => $orderDetail->product?->primaryImage?->url ?? null,
            ])->toArray(),
        ];
    }

    public function updateStatus(int $id, string $status): void
    {
        Order::findOrFail($id)->update(['status' => $status]);
    }
}
