<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartRepository
{
    /**
     * Ambil atau buat cart untuk user.
     */
    private function getOrCreateCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Semua item di cart user, diformat untuk Inertia.
     */
    public function getItems(int $userId): array
    {
        $cart = $this->getOrCreateCart($userId);

        return CartItem::with(['product.category', 'product.primaryImage'])
            ->where('cart_id', $cart->id)
            ->get()
            ->map(function (CartItem $item) {
                $product  = $item->product;
                $subtotal = $product->price * $item->quantity;

                return [
                    'id'                => $item->id,
                    'product_id'        => $product->id,
                    'name'              => $product->name,
                    'category'          => $product->category?->name ?? '',
                    'price'             => $product->price,
                    'price_formatted'   => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'quantity'          => $item->quantity,
                    'subtotal'          => $subtotal,
                    'subtotal_formatted'=> 'Rp ' . number_format($subtotal, 0, ',', '.'),
                    'image'             => $product->primaryImage?->url ?? null,
                    'max_quantity'      => $product->quantity,
                ];
            })
            ->toArray();
    }

    /**
     * Total harga semua item di cart.
     */
    public function calculateTotal(int $userId): int
    {
        $cart = $this->getOrCreateCart($userId);

        return (int) CartItem::with('product')
            ->where('cart_id', $cart->id)
            ->get()
            ->sum(fn ($item) => $item->product->price * $item->quantity);
    }

    /**
     * Tambah item atau update quantity kalau sudah ada.
     */
    public function addOrUpdateItem(int $userId, int $productId, int $quantity): void
    {
        $cart = $this->getOrCreateCart($userId);

        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }
    }

    /**
     * Set quantity item ke nilai tertentu.
     */
    public function updateQuantity(int $userId, int $productId, int $quantity): void
    {
        $cart = $this->getOrCreateCart($userId);

        CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);
    }

    /**
     * Hapus satu item dari cart.
     */
    public function deleteItem(int $userId, int $productId): void
    {
        $cart = $this->getOrCreateCart($userId);

        CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * Kosongkan seluruh cart (setelah checkout).
     */
    public function clearAll(int $userId): void
    {
        $cart = $this->getOrCreateCart($userId);
        CartItem::where('cart_id', $cart->id)->delete();
    }
}
