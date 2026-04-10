<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $dashboardService) {}

    public function index()
    {
        return Inertia::render('Admin/Dashboard', [
            'stats'          => $this->dashboardService->getStats(),
            'recentProducts' => $this->dashboardService->getRecentProducts(),
            'recentOrders'   => $this->dashboardService->getRecentOrders(),
            'categoryCounts' => $this->dashboardService->getCategoryCounts(),
            'dailyChart'     => $this->dashboardService->getDailyChartData(),
        ]);
    }
}
