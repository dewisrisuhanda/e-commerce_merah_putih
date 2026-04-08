<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
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
}
