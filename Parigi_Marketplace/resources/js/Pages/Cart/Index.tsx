import { Head, Link, router, useForm } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface CartItem {
    id: number;
    product_id: number;
    name: string;
    category: string;
    price: number;
    price_formatted: string;
    quantity: number;
    subtotal: number;
    subtotal_formatted: string;
    image: string | null;
    max_quantity: number;
}

interface Props {
    cartItems: CartItem[];
    total: number;
    total_formatted: string;
}

// ─── Component ────────────────────────────────────────────
export default function Index({ cartItems, total, total_formatted }: Props) {
    const render = (name: string) => route().has(name) ? route(name) : '#';

    const handleUpdateQuantity = (productId: number, quantity: number) => {
        router.patch(render('cart.update'), { product_id: productId, quantity }, {
            preserveScroll: true,
        });
    };

    const handleRemove = (productId: number) => {
        router.delete(render('cart.destroy'), {
            data: { product_id: productId },
            preserveScroll: true,
        });
    };

    return (
        <MainLayout>
            <Head title="Keranjang Belanja — Parigi Market" />

            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* Header */}
                <div className="flex items-center gap-3 mb-6">
                    <h5
                        className="text-xl font-black text-[#1a3a2a] m-0"
                        style={{ fontFamily: "'Playfair Display', serif" }}
                    >
                        🛒 Keranjang Belanja
                    </h5>
                    {cartItems.length > 0 && (
                        <span className="bg-[#d8f3dc] text-[#1a3a2a] text-[0.75rem] font-bold px-3 py-0.5 rounded-full">
                            {cartItems.length} item
                        </span>
                    )}
                </div>

                {cartItems.length === 0 ? (
                    /* ── Kosong ── */
                    <div className="text-center py-20">
                        <div className="text-6xl mb-4">🛒</div>
                        <p className="text-gray-400 mb-5">Keranjang kamu masih kosong.</p>
                        <Link
                            href={render('products.index')}
                            className="inline-block bg-[#40916c] text-white font-semibold px-6 py-2.5 rounded-full no-underline transition hover:bg-[#2d6a4f]"
                        >
                            Mulai Belanja
                        </Link>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {/* ── Cart Items ── */}
                        <div className="lg:col-span-2 flex flex-col gap-3">
                            {cartItems.map(item => (
                                <div
                                    key={item.id}
                                    className="bg-white rounded-2xl p-4 flex items-center gap-4 shadow-[0_2px_10px_rgba(26,58,42,0.07)]"
                                >
                                    {/* Image */}
                                    <div className="w-20 h-20 rounded-xl overflow-hidden flex-shrink-0 bg-[#d8f3dc]">
                                        {item.image ? (
                                            <img
                                                src={item.image}
                                                alt={item.name}
                                                className="w-full h-full object-cover"
                                                onError={(e) => { (e.target as HTMLImageElement).style.display = 'none'; }}
                                            />
                                        ) : (
                                            <div className="w-full h-full flex items-center justify-center text-[#40916c] text-2xl">📦</div>
                                        )}
                                    </div>

                                    {/* Info */}
                                    <div className="flex-1 min-w-0">
                                        {item.category && (
                                            <p className="text-[0.65rem] font-bold tracking-[0.08em] uppercase text-[#40916c] mb-0.5">{item.category}</p>
                                        )}
                                        <p className="font-semibold text-[#1a3a2a] text-sm mb-1 truncate">{item.name}</p>
                                        <p className="text-[#40916c] font-semibold text-[0.85rem] mb-2">{item.price_formatted}</p>

                                        {/* Qty Control */}
                                        <div className="flex items-center border border-gray-200 rounded-lg overflow-hidden w-fit">
                                            <button
                                                onClick={() => handleUpdateQuantity(item.product_id, Math.max(1, item.quantity - 1))}
                                                className="w-8 h-8 flex items-center justify-center text-[#40916c] font-bold bg-gray-50 hover:bg-[#d8f3dc] border-none cursor-pointer transition text-lg"
                                            >
                                                −
                                            </button>
                                            <span className="w-9 text-center text-sm font-bold text-[#1a3a2a] border-x border-gray-200">
                                                {item.quantity}
                                            </span>
                                            <button
                                                onClick={() => handleUpdateQuantity(item.product_id, Math.min(item.max_quantity, item.quantity + 1))}
                                                className="w-8 h-8 flex items-center justify-center text-[#40916c] font-bold bg-gray-50 hover:bg-[#d8f3dc] border-none cursor-pointer transition text-lg"
                                            >
                                                +
                                            </button>
                                        </div>
                                    </div>

                                    {/* Subtotal + Delete */}
                                    <div className="flex flex-col items-end gap-2 flex-shrink-0">
                                        <span className="font-bold text-[#1a3a2a] text-[0.95rem]">{item.subtotal_formatted}</span>
                                        <button
                                            onClick={() => handleRemove(item.product_id)}
                                            className="w-8 h-8 flex items-center justify-center text-red-400 border border-red-100 rounded-lg bg-transparent cursor-pointer hover:bg-red-50 hover:border-red-300 transition text-sm"
                                            title="Hapus"
                                        >
                                            🗑️
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* ── Summary ── */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-2xl p-6 shadow-[0_4px_18px_rgba(26,58,42,0.09)] sticky top-20">
                                <h6 className="font-bold text-[#1a3a2a] mb-4">Ringkasan Belanja</h6>

                                <div className="flex justify-between text-sm text-gray-500 mb-2">
                                    <span>{cartItems.length} produk</span>
                                    <span>{total_formatted}</span>
                                </div>
                                <div className="flex justify-between text-sm text-gray-500 mb-4">
                                    <span>Ongkos kirim</span>
                                    <span className="text-[#40916c] font-semibold">Gratis</span>
                                </div>

                                <div className="flex justify-between items-center font-bold text-[#1a3a2a] pt-3 border-t border-gray-100 mb-5">
                                    <span>Total</span>
                                    <span
                                        className="text-lg text-[#2d6a4f]"
                                        style={{ fontFamily: "'Playfair Display', serif" }}
                                    >
                                        {total_formatted}
                                    </span>
                                </div>

                                <Link
                                    href={render('checkout.index')}
                                    className="block text-center bg-[#40916c] text-white font-bold py-3 rounded-xl no-underline transition hover:bg-[#2d6a4f] hover:-translate-y-0.5"
                                >
                                    Lanjut ke Pembayaran →
                                </Link>
                                <Link
                                    href={render('products.index')}
                                    className="block text-center mt-3 text-sm text-[#40916c] no-underline hover:underline"
                                >
                                    ← Lanjut Belanja
                                </Link>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
