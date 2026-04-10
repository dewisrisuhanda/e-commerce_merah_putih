<?php

namespace App\Services;

interface CheckoutService
{
    public function getCheckoutData(int $userId): array;
    public function processCheckout(int $userId, array $data): array;
    public function handleWebhook(array $payload): void;
}
