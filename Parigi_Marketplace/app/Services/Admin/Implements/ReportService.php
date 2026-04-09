<?php

namespace App\Services\Admin\Implements;

use App\Repositories\Admin\ReportRepository;

class ReportService implements \App\Services\Admin\ReportService
{
    public function __construct(
        private ReportRepository $reportRepository
    ) {}

    public function getSalesData(): array
    {
        $stats = $this->reportRepository->getSalesStats();

        return [
            'totalSold'    => $stats['total_sold'],
            'totalOrders'  => $stats['total_orders'],
            'totalRevenue' => 'Rp ' . number_format($stats['total_revenue'], 0, ',', '.'),
            'products'     => $this->reportRepository->getProductList(),
        ];
    }

    public function getFinanceData(): array
    {
        $stats = $this->reportRepository->getFinanceStats();

        return [
            'totalIncome'   => 'Rp ' . number_format($stats['total_income'], 0, ',', '.'),
            'totalPending'  => $stats['total_pending'],
            'totalCanceled' => $stats['total_canceled'],
            'transactions'  => $this->reportRepository->getTransactions(),
        ];
    }
}
