<?php

namespace App\Services\Implements;

use App\Repositories\OrderRepository;

class OrderService implements \App\Services\OrderService
{
    private OrderRepository $orderRepository;
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
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
}
