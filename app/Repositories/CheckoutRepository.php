<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ShippingMethod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CheckoutRepository
{
    public function getCartItems(int $userId): array
    {
        $cart = Cart::where('user_id', $userId)->first();
        if (!$cart) return [];

        return CartItem::with(['product.category', 'product.primaryImage'])
            ->where('cart_id', $cart->id)
            ->get()
            ->map(fn (CartItem $item) => [
                'product_id'    => $item->product_id,
                'name'          => $item->product->name,
                'price'         => (float) $item->product->price,
                'quantity'      => $item->quantity,
                'subtotal'      => (float) $item->product->price * $item->quantity,
                'image'         => $item->product->primaryImage?->url,
                'max_quantity'  => $item->product->quantity,
            ])
            ->toArray();
    }

    public function getShippingMethods(): array
    {
        return ShippingMethod::where('active', true)
            ->get(['id', 'name', 'code', 'description'])
            ->toArray();
    }

    public function getPaymentMethods(): array
    {
        return PaymentMethod::where('active', true)
            ->get(['id', 'name', 'code', 'description'])
            ->toArray();
    }

    /**
     * Buat Order + OrderDetails dalam satu transaksi DB.
     * Mengurangi stok produk secara atomik.
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            // Generate order number: INV-YYYYMMDD-XXXX
            $orderNumber = 'INV-' . Carbon::now()->format('Ymd') . '-'
                . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_number'       => $orderNumber,
                'user_id'            => $data['user_id'],
                'shipping_method_id' => $data['shipping_method_id'],
                'payment_method_id'  => $data['payment_method_id'],
                'address'            => $data['address'],
                'subtotal'           => $data['subtotal'],
                'shipping_cost'      => $data['shipping_cost'],
                'total_amount'       => $data['total_amount'],
                'notes'              => $data['notes'] ?? null,
                'status'             => 'pending_payment',
            ]);

            // Buat order details (snapshot harga saat checkout)
            foreach ($data['items'] as $item) {
                OrderDetail::create([
                    'order_id'      => $order->id,
                    'product_id'    => $item['product_id'],
                    'product_name'  => $item['name'],
                    'product_price' => $item['price'],
                    'quantity'      => $item['quantity'],
                    'subtotal'      => $item['subtotal'],
                ]);

                // Kurangi stok produk
                Product::where('id', $item['product_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            return $order;
        });
    }

    /**
     * Simpan snap_token ke tabel payments setelah dapat dari Midtrans.
     */
    public function createPayment(int $orderId, string $midtransOrderId, float $grossAmount, string $snapToken): Payment
    {
        return Payment::create([
            'order_id'          => $orderId,
            'midtrans_order_id' => $midtransOrderId,
            'snap_token'        => $snapToken,
            'gross_amount'      => $grossAmount,
            'status'            => 'pending',
        ]);
    }

    /**
     * Update payment setelah webhook diterima dari Midtrans.
     */
    public function updatePaymentByMidtransOrderId(string $midtransOrderId, array $data): void
    {
        Payment::where('midtrans_order_id', $midtransOrderId)
            ->update($data);
    }

    public function findPaymentByMidtransOrderId(string $midtransOrderId): ?Payment
    {
        return Payment::with('order')
            ->where('midtrans_order_id', $midtransOrderId)
            ->first();
    }

    /**
     * Kosongkan cart setelah checkout berhasil.
     */
    public function clearCart(int $userId): void
    {
        $cart = Cart::where('user_id', $userId)->first();
        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
        }
    }
}
