<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    public function index()
    {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => $this->orderService->getAllOrders(),
        ]);
    }

    public function show(int $id)
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $this->orderService->getOrderDetail($id),
        ]);
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => ['required', 'in:pending_payment,paid,processing,shipped,completed,canceled']]);
        $this->orderService->updateStatus($id, $request->status);
        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
