<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\OrderRepository;

class OrderService implements \App\Services\Admin\OrderService
{
    public function __construct(
        private OrderRepository $orderRepository
    ) {}

    public function getAllOrders(): array
    {
        return $this->orderRepository->getAll();
    }

    public function getOrderDetail(int $id): ?array
    {
        $order = $this->orderRepository->findById($id);

        if (!$order) return null;

        return $this->orderRepository->formatDetail($order);
    }

    public function updateStatus(int $id, string $status): void
    {
        $this->orderRepository->updateStatus($id, $status);
    }
}
