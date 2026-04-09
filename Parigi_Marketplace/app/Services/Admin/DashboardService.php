<?php

namespace App\Services\Admin;

interface DashboardService
{
    public function getStats(): array;
    public function getRecentProducts(): array;
    public function getRecentOrders(): array;
    public function getCategoryCounts(): array;
}
