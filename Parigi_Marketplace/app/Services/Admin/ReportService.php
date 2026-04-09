<?php

namespace App\Services\Admin;

interface ReportService
{
    public function getSalesData(): array;
    public function getFinanceData(): array;
}
