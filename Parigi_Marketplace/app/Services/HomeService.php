<?php

namespace App\Services;

interface HomeService
{
    public function getBestProducts(): array;
    public function getTotalActiveProduct(): int;
}
