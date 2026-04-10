<?php

namespace App\Http\Controllers;

use App\Services\CheckoutService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    private CheckoutService $checkoutService;
    public function __construct(CheckoutService $checkoutService) {
        $this->checkoutService = $checkoutService;
    }

    /**
     * GET /checkout — Halaman konfirmasi pesanan
     */
    public function index(): RedirectResponse | \Inertia\Response
    {
        $data = $this->checkoutService->getCheckoutData(auth()->id());

        // Kalau cart kosong, redirect ke cart
        if (empty($data['items'])) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang kamu kosong.');
        }

        return Inertia::render('Checkout/Index', $data);
    }

    /**
     * POST /checkout — Proses checkout, dapat snap_token
     */
    public function store(Request $request): JsonResponse
    {

        $shippingCode = $request->input('shipping_method_code', '');
        $addressRule = ($shippingCode !== 'ambil')
            ? ['required', 'string', 'max:500']
            : ['nullable', 'string', 'max:500'];

        $request->validate([
            'shipping_method_id'   => ['required', 'exists:shipping_methods,id'],
            'payment_method_id'    => ['required', 'exists:payment_methods,id'],
            'shipping_method_code' => ['required', 'string'],
            'payment_method_code'  => ['required', 'string'],
            'address'              => $addressRule,
            'notes'                => ['nullable', 'string', 'max:500'],
        ],
            [
                'address.required' => 'Alamat pengiriman wajib diisi untuk metode pengiriman ke rumah.',
            ]
        );

        try {
            $result = $this->checkoutService->processCheckout(
                userId: auth()->id(),
                data: $request->only([
                    'shipping_method_id',
                    'payment_method_id',
                    'shipping_method_code',
                    'payment_method_code',
                    'address',
                    'notes',
                ])
            );

            return response()->json([
                'success'      => true,
                'snap_token'   => $result['snap_token'],
                'client_key'   => $result['client_key'],
                'order_number' => $result['order_number'],
                'order_id'     => $result['order_id'],
                'is_cash'      => $result['is_cash'] ?? false,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pesanan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
