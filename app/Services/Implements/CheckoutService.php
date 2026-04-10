<?php

namespace App\Services\implements;

use App\Repositories\CheckoutRepository;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutService implements \App\Services\CheckoutService
{
    private CheckoutRepository $checkoutRepository;
    public function __construct(CheckoutRepository $checkoutRepository) {
        $this->checkoutRepository = $checkoutRepository;

        Config::$serverKey    = config('midtrans.server_key');
        Config::$clientKey    = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
    }

    /**
     * Data untuk halaman checkout (cart items + opsi pengiriman/pembayaran).
     */
    public function getCheckoutData(int $userId): array
    {
        $items   = $this->checkoutRepository->getCartItems($userId);
        $subtotal = array_sum(array_column($items, 'subtotal'));

        return [
            'items'           => $items,
            'subtotal'        => $subtotal,
            'subtotal_formatted' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
            'shippingMethods' => $this->checkoutRepository->getShippingMethods(),
            'paymentMethods'  => $this->checkoutRepository->getPaymentMethods(),
        ];
    }

    /**
     * Proses checkout:
     * 1. Buat Order & OrderDetails di DB
     * 2. Request snap_token ke Midtrans
     * 3. Simpan snap_token ke tabel payments
     * 4. Return snap_token ke FE untuk render popup
     */
    public function processCheckout(int $userId, array $data): array
    {
        $items    = $this->checkoutRepository->getCartItems($userId);
        $subtotal = array_sum(array_column($items, 'subtotal'));

        // Hitung ongkir sesuai metode pengiriman
        $shippingCost = $data['shipping_method_code'] === 'ambil' ? 0 : 5000;
        $totalAmount  = $subtotal + $shippingCost;

        // Buat order di DB
        $order = $this->checkoutRepository->createOrder([
            'user_id'            => $userId,
            'shipping_method_id' => $data['shipping_method_id'],
            'payment_method_id'  => $data['payment_method_id'],
            'address'            => $data['address'] ?? null,
            'notes'              => $data['notes'] ?? null,
            'subtotal'           => $subtotal,
            'shipping_cost'      => $shippingCost,
            'total_amount'       => $totalAmount,
            'items'              => $items,
        ]);

        // Midtrans order ID = order_number agar mudah di-trace
        $midtransOrderId = $order->order_number;

        // ── Cash: skip Midtrans, langsung return tanpa snap_token
        if ($data['payment_method_code'] === 'cash') {
            // Simpan payment record dengan status settlement (cash langsung dianggap confirmed)
            $this->checkoutRepository->createPayment(
                orderId:         $order->id,
                midtransOrderId: $midtransOrderId,
                grossAmount:     $totalAmount,
                snapToken:       '', // tidak ada snap token untuk cash
            );

            // Update order status langsung ke processing (skip pending_payment)
            $order->update(['status' => 'processing']);

            $this->checkoutRepository->clearCart($userId);

            return [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'snap_token'   => null,
                'client_key'   => null,
                'is_cash'      => true,
            ];
        }

        // Siapkan payload untuk Midtrans Snap
        $params = [
            'transaction_details' => [
                'order_id'     => $midtransOrderId,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $data['customer_name'] ?? auth()->user()->name,
                'email'      => $data['customer_email'] ?? auth()->user()->email,
                'phone'      => $data['customer_phone'] ?? '',
                'billing_address' => [
                    'address' => $data['address'] ?? '',
                ],
            ],
            'item_details' => array_map(fn ($item) => [
                'id'       => (string) $item['product_id'],
                'price'    => (int) $item['price'],
                'quantity' => $item['quantity'],
                'name'     => substr($item['name'], 0, 50), // Midtrans max 50 char
            ], $items),
            // Opsional: batasi metode pembayaran
            // 'enabled_payments' => ['credit_card', 'bca_va', 'bni_va', 'gopay', 'qris'],
        ];

        // Tambahkan ongkir ke item_details kalau ada
        if ($shippingCost > 0) {
            $params['item_details'][] = [
                'id'       => 'SHIPPING',
                'price'    => (int) $shippingCost,
                'quantity' => 1,
                'name'     => 'Ongkos Kirim',
            ];
        }

        // Request snap token ke Midtrans
        $snapToken = Snap::getSnapToken($params);

        // Simpan ke tabel payments
        $this->checkoutRepository->createPayment(
            orderId:         $order->id,
            midtransOrderId: $midtransOrderId,
            grossAmount:     $totalAmount,
            snapToken:       $snapToken,
        );

        // Kosongkan cart
        $this->checkoutRepository->clearCart($userId);

        return [
            'order_id'    => $order->id,
            'order_number'=> $order->order_number,
            'snap_token'  => $snapToken,
            'client_key'  => config('midtrans.client_key'),
        ];
    }

    /**
     * Handle webhook/notification dari Midtrans.
     * Dipanggil oleh MidtransWebhookController.
     */
    public function handleWebhook(array $payload): void
    {
        // Verifikasi signature dari Midtrans
        $signatureKey = hash('sha512',
            $payload['order_id'] .
            $payload['status_code'] .
            $payload['gross_amount'] .
            config('midtrans.server_key')
        );

        if ($signatureKey !== $payload['signature_key']) {
            throw new \Exception('Invalid Midtrans signature');
        }

        $payment = $this->checkoutRepository->findPaymentByMidtransOrderId($payload['order_id']);
        if (!$payment) return;

        $transactionStatus = $payload['transaction_status'];
        $fraudStatus       = $payload['fraud_status'] ?? 'accept';

        // Tentukan status payment berdasarkan response Midtrans
        $paymentStatus = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'settlement',
            $transactionStatus === 'settlement'                            => 'settlement',
            $transactionStatus === 'pending'                               => 'pending',
            in_array($transactionStatus, ['deny', 'cancel', 'expire'])    => $transactionStatus,
            $transactionStatus === 'refund'                                => 'refund',
            default                                                        => 'pending',
        };

        // Update payment
        $this->checkoutRepository->updatePaymentByMidtransOrderId($payload['order_id'], [
            'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
            'payment_type'            => $payload['payment_type'] ?? null,
            'status'                  => $paymentStatus,
            'midtrans_response'       => $payload,
            'paid_at'                 => $paymentStatus === 'settlement' ? now() : null,
        ]);

        // Update status order sesuai payment status
        $orderStatus = match ($paymentStatus) {
            'settlement' => 'paid',
            'expire', 'cancel', 'deny' => 'canceled',
            default => 'pending_payment',
        };

        $payment->order->update(['status' => $orderStatus]);
    }
}
