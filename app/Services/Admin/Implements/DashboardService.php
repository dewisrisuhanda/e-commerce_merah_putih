<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\DashboardRepository;

class DashboardService implements \App\Services\Admin\DashboardService
{

    private DashboardRepository $dashboardRepository;
    /**
     * Create a new class instance.
     */
    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }


    public function getStats(): array
    {
        return $this->dashboardRepository->getStats();
    }

    public function getRecentProducts(): array
    {
        return $this->dashboardRepository->getRecentProducts(limit: 5);
    }

    public function getRecentOrders(): array
    {
        return $this->dashboardRepository->getRecentOrders(limit: 6);
    }

    public function getCategoryCounts(): array
    {
        return $this->dashboardRepository->getCategoryCounts();
    }

    public function getDailyChartData(): array
    {
        return $this->dashboardRepository->getDailyChartData();
    }
}
