<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Payment;

class OrderRepository
{

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

    public function findByUserAndId(int $userId, int $orderId): ?Order
    {
        return Order::where('user_id', $userId)
            ->where('id', $orderId)
            ->with(['shippingMethod', 'paymentMethod', 'orderDetails.product.primaryImage', 'user'])
            ->first();
    }

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

    // Hanya simpan/update payment record — tidak ada logika bisnis
    public function upsertPayment(Order $order, string $midtransOrderId, string $snapToken): void
    {
        $payment = $order->payment;

        if ($payment) {
            $payment->update([
                'snap_token'        => $snapToken,
                'midtrans_order_id' => $midtransOrderId,
                'status'            => 'pending',
            ]);
        } else {
            Payment::create([
                'order_id'          => $order->id,
                'midtrans_order_id' => $midtransOrderId,
                'snap_token'        => $snapToken,
                'gross_amount'      => $order->total_amount,
                'status'            => 'pending',
            ]);
        }
    }

    public function updateOrderStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);
    }
}
