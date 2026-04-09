<?php

namespace App\Services\Admin;

interface CategoryService
{
    public function getCategoriesWithCount(): array;
}
