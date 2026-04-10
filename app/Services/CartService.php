<?php

namespace App\Services;

interface CartService
{
    public function getCartItems(int $userId): array;
    public function getTotal(int $userId): int;
    public function getTotalFormatted(int $userId): string;
    public function addItem(int $userId, int $productId, int $quantity): void;
    public function updateItem(int $userId, int $productId, int $quantity): void;
    public function removeItem(int $userId, int $productId): void;
    public function clearCart(int $userId): void;
}
