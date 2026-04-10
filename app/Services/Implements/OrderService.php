<?php

namespace App\Services\Implements;

use App\Repositories\OrderRepository;
use Midtrans\Config;
use Midtrans\Snap;

class OrderService implements \App\Services\OrderService
{
    private OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;

        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    public function getUserOrders(int $userId): array
    {
        return $this->orderRepository->getByUser($userId);
    }

    public function getOrderDetail(int $userId, int $orderId): ?array
    {
        $order = $this->orderRepository->findByUserAndId($userId, $orderId);
        if (!$order) return null;
        return $this->orderRepository->formatDetail($order);
    }

    public function repayOrder(int $userId, int $orderId): array
    {
        $order = $this->orderRepository->findByUserAndId($userId, $orderId);

        if (!$order) {
            throw new \Exception('Pesanan tidak ditemukan.');
        }

        if ($order->status !== 'pending_payment') {
            throw new \Exception('Pesanan ini tidak perlu dibayar lagi (status: ' . $order->status . ').');
        }

        // Generate Midtrans order ID baru agar tidak conflict dengan transaksi sebelumnya
        $newMidtransOrderId = $order->order_number . '-' . time();

        // Bangun item_details
        $itemDetails = $order->orderDetails->map(fn ($d) => [
            'id'       => (string) $d->product_id,
            'price'    => (int) $d->product_price,
            'quantity' => $d->quantity,
            'name'     => substr($d->product_name, 0, 50),
        ])->toArray();

        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $order->shipping_cost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $newMidtransOrderId,
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->user?->name ?? '',
                'email'      => $order->user?->email ?? '',
            ],
            'item_details' => $itemDetails,
        ];

        // Request snap token baru ke Midtrans
        $newToken = Snap::getSnapToken($params);

        // Simpan ke DB via repository (hanya query, tidak ada logika)
        $this->orderRepository->upsertPayment($order, $newMidtransOrderId, $newToken);

        return [
            'snap_token' => $newToken,
            'client_key' => config('midtrans.client_key'),
        ];
    }
}
