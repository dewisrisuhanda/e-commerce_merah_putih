<?php

namespace App\Services;

interface OrderService
{
    public function getUserOrders(int $userId): array;
    public function getOrderDetail(int $userId, int $orderId): ?array;
    public function repayOrder(int $userId, int $orderId): array;
}
