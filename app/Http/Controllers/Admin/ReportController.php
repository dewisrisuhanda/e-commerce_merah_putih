<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\ReportService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportController extends Controller
{
    public function __construct(private ReportService $reportService) {}

    public function sales() {
        return Inertia::render('Admin/Reports/Sales', $this->reportService->getSalesData());
    }
    public function finance() {
        return Inertia::render('Admin/Reports/Finance', $this->reportService->getFinanceData());
    }
}
