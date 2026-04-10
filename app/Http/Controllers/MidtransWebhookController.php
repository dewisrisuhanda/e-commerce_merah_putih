<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    private CheckoutService $checkoutService;
    public function __construct(CheckoutService $checkoutService) {
        $this->checkoutService = $checkoutService;
    }

    /**
     * POST /midtrans/webhook
     * Midtrans akan POST ke endpoint ini setiap ada perubahan status pembayaran.
     * Endpoint ini HARUS dikecualikan dari CSRF middleware.
     */
    public function handle(Request $request): Response
    {
        try {
            $this->checkoutService->handleWebhook($request->all());
            return response('OK', 200);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage(), $request->all());
            return response('Error', 400);
        }
    }
}
