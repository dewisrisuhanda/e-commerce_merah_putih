<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    private OrderService $orderService;
    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    /**
     * GET /orders — Riwayat pesanan user
     */
    public function index(): Response
    {
        return Inertia::render('Orders/Index', [
            'orders' => $this->orderService->getUserOrders(auth()->id()),
        ]);
    }

    /**
     * GET /orders/{id} — Detail satu pesanan
     */
    public function show(int $id): Response
    {
        $order = $this->orderService->getOrderDetail(auth()->id(), $id);

        abort_if(!$order, 404);

        return Inertia::render('Orders/Show', [
            'order' => $order,
        ]);
    }

    public function repay(int $id): JsonResponse
    {
        try {
            $result = $this->orderService->repayOrder(auth()->id(), $id);

            return response()->json([
                'success'    => true,
                'snap_token' => $result['snap_token'],
                'client_key' => $result['client_key'],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
