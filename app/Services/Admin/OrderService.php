<?php

namespace App\Services\Admin;

interface OrderService
{
    public function getAllOrders(): array;
    public function getOrderDetail(int $id): ?array;
    public function updateStatus(int $id, string $status): void;
}
