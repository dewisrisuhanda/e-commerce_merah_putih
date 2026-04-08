<?php

namespace App\Services\Implements;

use App\Repositories\CartRepository;

class CartService implements \App\Services\CartService
{
    private CartRepository $cartRepository;
    public function __construct(CartRepository $cartRepository) {
        $this->cartRepository = $cartRepository;
    }

    public function getCartItems(int $userId): array
    {
        return $this->cartRepository->getItems($userId);
    }

    public function getTotal(int $userId): int
    {
        return $this->cartRepository->calculateTotal($userId);
    }

    public function getTotalFormatted(int $userId): string
    {
        return 'Rp ' . number_format($this->getTotal($userId), 0, ',', '.');
    }

    public function addItem(int $userId, int $productId, int $quantity): void
    {
        $this->cartRepository->addOrUpdateItem($userId, $productId, $quantity);
    }

    public function updateItem(int $userId, int $productId, int $quantity): void
    {
        $this->cartRepository->updateQuantity($userId, $productId, $quantity);
    }

    public function removeItem(int $userId, int $productId): void
    {
        $this->cartRepository->deleteItem($userId, $productId);
    }

    public function clearCart(int $userId): void
    {
        $this->cartRepository->clearAll($userId);
    }
}
