import { Head, Link, router, useForm, usePage } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface ProductImage {
    id: number;
    url: string;
    is_primary: boolean;
}

interface Product {
    id: number;
    name: string;
    slug: string;
    category: string;
    price: string;
    quantity: number;
    description: string | null;
    images: ProductImage[];
}

interface Props {
    product: Product;
    auth: { user: { name: string; role: string } | null };
}

// ─── Toast component ─────────────────────────────────────
function Toast({ message, type, onClose }: {
    message: string;
    type: 'success' | 'error';
    onClose: () => void;
}) {
    useEffect(() => {
        const t = setTimeout(onClose, 3000);
        return () => clearTimeout(t);
    }, []);

    return (
        <div
            className={`fixed bottom-6 left-1/2 -translate-x-1/2 z-[9999] flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold transition-all animate-in fade-in slide-in-from-bottom-4 duration-300 ${
                type === 'success'
                    ? 'bg-[#1a3a2a] text-white'
                    : 'bg-red-600 text-white'
            }`}
        >
            <span className="text-base">{type === 'success' ? '✅' : '❌'}</span>
            <span>{message}</span>
            <button
                onClick={onClose}
                className="ml-2 text-white/60 hover:text-white bg-transparent border-none cursor-pointer text-base leading-none"
            >
                ×
            </button>
        </div>
    );
}

// ─── Component ────────────────────────────────────────────
export default function Show({ product, auth }: Props) {
    const primaryImage = product.images.find(img => img.is_primary) ?? product.images[0] ?? null;
    const [activeImage, setActiveImage] = useState(primaryImage?.url ?? null);

    // Toast state
    const [toast, setToast] = useState<{ message: string; type: 'success' | 'error' } | null>(null);

    const { data, setData, post, processing, errors, reset } = useForm({
        product_id: product.id,
        quantity: 1,
    });

    const r = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const handleAddToCart = (e: React.FormEvent) => {
        e.preventDefault();
        post(r('cart.store'), {
            preserveScroll: true,
            onSuccess: () => {
                setToast({
                    message: `${product.name} berhasil ditambahkan ke keranjang 🛒`,
                    type: 'success',
                });
                reset('quantity');
                setData('quantity', 1);
            },
            onError: () => {
                setToast({
                    message: 'Gagal menambahkan ke keranjang. Coba lagi.',
                    type: 'error',
                });
            },
        });
    };

    return (
        <MainLayout>
            <Head title={`${product.name} — Parigi Market`} />

            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

            {/* Toast notification */}
            {toast && (
                <Toast
                    message={toast.message}
                    type={toast.type}
                    onClose={() => setToast(null)}
                />
            )}

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* ── Breadcrumb ── */}
                <nav className="flex items-center gap-2 text-sm text-gray-400 mb-6">
                    <Link href="/" className="text-[#40916c] no-underline hover:underline">Beranda</Link>
                    <span>/</span>
                    <Link href={r('products.index')} className="text-[#40916c] no-underline hover:underline">Marketplace</Link>
                    <span>/</span>
                    <span className="text-gray-500 truncate max-w-[200px]">{product.name}</span>
                </nav>

                <div className="max-w-5xl mx-auto">
                    <div className="grid md:grid-cols-2 gap-8">

                        {/* ── Image Column ── */}
                        <div>
                            <div className="relative rounded-2xl overflow-hidden bg-[#f4faf6] shadow-[0_8px_32px_rgba(26,58,42,0.1)] mb-3">
                                {activeImage ? (
                                    <img
                                        src={activeImage}
                                        alt={product.name}
                                        className="w-full h-80 md:h-96 object-cover"
                                        onError={(e) => {
                                            (e.target as HTMLImageElement).src =
                                                `https://placehold.co/600x400/e8f5e9/2e7d32?text=${encodeURIComponent(product.name)}`;
                                        }}
                                    />
                                ) : (
                                    <div className="w-full h-80 md:h-96 flex items-center justify-center text-gray-300">
                                        <span className="text-7xl">🖼️</span>
                                    </div>
                                )}
                            </div>

                            {product.images.length > 1 && (
                                <div className="flex gap-2 flex-wrap">
                                    {product.images.map(img => (
                                        <button
                                            key={img.id}
                                            onClick={() => setActiveImage(img.url)}
                                            className={`w-16 h-16 rounded-xl overflow-hidden border-2 transition cursor-pointer ${activeImage === img.url ? 'border-[#40916c]' : 'border-transparent hover:border-[#40916c]/40'}`}
                                        >
                                            <img src={img.url} alt="" className="w-full h-full object-cover" />
                                        </button>
                                    ))}
                                </div>
                            )}
                        </div>

                        {/* ── Detail Column ── */}
                        <div>
                            {product.category && (
                                <span className="inline-block text-[0.7rem] font-bold tracking-[0.1em] uppercase text-[#40916c] bg-[#40916c]/10 px-3 py-1 rounded-full mb-3">
                                    {product.category}
                                </span>
                            )}

                            <h1 className="text-2xl md:text-3xl font-black text-[#1a3a2a] mb-2 leading-tight" style={{ fontFamily: "'Playfair Display', serif" }}>
                                {product.name}
                            </h1>

                            <p className="text-2xl font-black text-[#2d6a4f] mb-1" style={{ fontFamily: "'Playfair Display', serif" }}>
                                {product.price}
                            </p>

                            <p className="text-sm text-gray-500 mb-4">
                                Stok tersedia:{' '}
                                <strong className={product.quantity > 0 ? 'text-[#40916c]' : 'text-red-500'}>
                                    {product.quantity > 0 ? product.quantity : 'Habis'}
                                </strong>
                            </p>

                            <hr className="border-gray-100 mb-4" />

                            {product.description && (
                                <div className="text-sm text-gray-600 leading-relaxed mb-5 whitespace-pre-line">
                                    {product.description}
                                </div>
                            )}

                            <hr className="border-gray-100 mb-4" />

                            {auth.user ? (
                                product.quantity > 0 ? (
                                    <form onSubmit={handleAddToCart} className="flex items-center gap-3">
                                        <input type="hidden" name="product_id" value={product.id} />
                                        <div className="flex items-center border border-[#40916c]/30 rounded-xl overflow-hidden">
                                            <button
                                                type="button"
                                                onClick={() => setData('quantity', Math.max(1, data.quantity - 1))}
                                                className="w-10 h-10 flex items-center justify-center text-[#40916c] font-bold text-lg bg-transparent border-none cursor-pointer hover:bg-[#40916c]/10 transition"
                                            >
                                                −
                                            </button>
                                            <input
                                                type="number"
                                                value={data.quantity}
                                                min={1}
                                                max={product.quantity}
                                                onChange={e => setData('quantity', Number(e.target.value))}
                                                className="w-14 text-center text-sm font-semibold text-[#1a3a2a] border-none bg-transparent"
                                                style={{ outline: 'none' }}
                                            />
                                            <button
                                                type="button"
                                                onClick={() => setData('quantity', Math.min(product.quantity, data.quantity + 1))}
                                                className="w-10 h-10 flex items-center justify-center text-[#40916c] font-bold text-lg bg-transparent border-none cursor-pointer hover:bg-[#40916c]/10 transition"
                                            >
                                                +
                                            </button>
                                        </div>
                                        <button
                                            type="submit"
                                            disabled={processing}
                                            className="flex-1 bg-[#40916c] text-white font-semibold py-2.5 px-5 rounded-xl border-none cursor-pointer transition hover:bg-[#2d6a4f] disabled:opacity-60 disabled:cursor-not-allowed"
                                        >
                                            {processing ? (
                                                <span className="flex items-center justify-center gap-2">
                                                    <svg className="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                                        <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                                        <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                                    </svg>
                                                    Menambahkan...
                                                </span>
                                            ) : (
                                                '🛒 Tambah ke Keranjang'
                                            )}
                                        </button>
                                    </form>
                                ) : (
                                    <div className="bg-red-50 border border-red-100 text-red-500 text-sm font-medium px-4 py-3 rounded-xl">
                                        Stok habis, produk tidak tersedia saat ini.
                                    </div>
                                )
                            ) : (
                                <Link
                                    href={r('login')}
                                    className="block text-center bg-[#40916c]/10 text-[#40916c] font-semibold py-2.5 px-5 rounded-xl no-underline transition hover:bg-[#40916c] hover:text-white"
                                >
                                    Login untuk Membeli
                                </Link>
                            )}

                            <Link
                                href={r('products.index')}
                                className="inline-block mt-4 text-sm text-gray-400 no-underline hover:text-[#40916c] transition"
                            >
                                ← Kembali ke Katalog
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
