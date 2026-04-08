<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    private CartService $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * GET /cart — Halaman keranjang
     */
    public function index(): Response
    {
        $userId = auth()->id();

        return Inertia::render('Cart/Index', [
            'cartItems'       => $this->cartService->getCartItems($userId),
            'total'           => $this->cartService->getTotal($userId),
            'total_formatted' => $this->cartService->getTotalFormatted($userId),
        ]);
    }

    /**
     * POST /cart — Tambah produk ke keranjang
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $this->cartService->addItem(
            userId:    auth()->id(),
            productId: $request->product_id,
            quantity:  $request->quantity,
        );

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * PATCH /cart — Update jumlah item
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity'   => ['required', 'integer', 'min:1'],
        ]);

        $this->cartService->updateItem(
            userId:    auth()->id(),
            productId: $request->product_id,
            quantity:  $request->quantity,
        );

        return back();
    }

    /**
     * DELETE /cart — Hapus item dari keranjang
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => ['required', 'integer'],
        ]);

        $this->cartService->removeItem(
            userId:    auth()->id(),
            productId: $request->product_id,
        );

        return back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
