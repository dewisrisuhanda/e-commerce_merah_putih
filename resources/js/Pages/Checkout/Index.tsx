import { Head, Link, router } from '@inertiajs/react';
import { useState, useEffect } from 'react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface CartItem {
    product_id: number;
    name: string;
    price: number;
    quantity: number;
    subtotal: number;
    image: string | null;
}

interface ShippingMethod {
    id: number;
    name: string;
    code: string;
    description: string | null;
}

interface PaymentMethod {
    id: number;
    name: string;
    code: string;
    description: string | null;
}

interface Props {
    items: CartItem[];
    subtotal: number;
    subtotal_formatted: string;
    shippingMethods: ShippingMethod[];
    paymentMethods: PaymentMethod[];
}

const formatRp = (n: number) => 'Rp ' + n.toLocaleString('id-ID');

declare global {
    interface Window {
        snap: {
            pay: (token: string, options: {
                onSuccess: (result: any) => void;
                onPending: (result: any) => void;
                onError:   (result: any) => void;
                onClose:   () => void;
            }) => void;
        };
    }
}

export default function Index({
    items,
    subtotal,
    subtotal_formatted,
    shippingMethods,
    paymentMethods,
}: Props) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const [selectedShipping, setSelectedShipping] = useState<ShippingMethod | null>(
        shippingMethods[0] ?? null
    );
    const [selectedPayment, setSelectedPayment] = useState<PaymentMethod | null>(
        paymentMethods[0] ?? null
    );
    const [address, setAddress] = useState('');
    const [notes, setNotes]     = useState('');
    const [loading, setLoading] = useState(false);
    const [error, setError]     = useState<string | null>(null);
    const [snapReady, setSnapReady] = useState(false);

    const shippingCost = 0; // bisa dikembangkan per metode
    const totalAmount  = subtotal + shippingCost;
    const needsAddress = selectedShipping?.code !== 'pickup';


    useEffect(() => {
        // Kalau sudah ada (misal navigasi balik ke halaman ini), skip
        if (document.getElementById('midtrans-snap-script')) {
            setSnapReady(true);
            return;
        }

        const script = document.createElement('script');
        script.id  = 'midtrans-snap-script';
        script.src = import.meta.env.VITE_MIDTRANS_IS_PRODUCTION === 'true'
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
        script.setAttribute('data-client-key', import.meta.env.VITE_MIDTRANS_CLIENT_KEY ?? '');
        script.onload = () => setSnapReady(true);
        script.onerror = () => console.error('Gagal load Midtrans Snap.js');
        document.body.appendChild(script);

        // Cleanup: hapus script saat komponen unmount
        return () => {
            const existing = document.getElementById('midtrans-snap-script');
            if (existing) existing.remove();
        };
    }, []);

    const handleCheckout = async () => {
        if (!selectedShipping || !selectedPayment) {
            setError('Pilih metode pengiriman dan pembayaran terlebih dahulu.');
            return;
        }
        if (needsAddress && !address.trim()) {
            setError('Alamat pengiriman wajib diisi.');
            return;
        }
        if (!snapReady) {
            setError('Sistem pembayaran belum siap, tunggu sebentar lalu coba lagi.');
            return;
        }

        setError(null);
        setLoading(true);

        try {
            const csrfToken = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content ?? '';

            const res = await fetch(render('checkout.store'), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                },
                body: JSON.stringify({
                    shipping_method_id:   selectedShipping.id,
                    shipping_method_code: selectedShipping.code,
                    payment_method_id:    selectedPayment.id,
                    address:              needsAddress ? address : null,
                    notes:                notes || null,
                }),
            });

            const data = await res.json();

            if (!data.success) {
                setError(data.message ?? 'Terjadi kesalahan.');
                setLoading(false);
                return;
            }
            
            const orderUrl = render('orders.show', data.order_id);

            window.snap.pay(data.snap_token, {
                onSuccess: (_result) => {
                    // Bayar berhasil → ke detail pesanan
                    router.visit(orderUrl);
                },
                onPending: (_result) => {
                    // Menunggu transfer → ke detail pesanan juga
                    router.visit(orderUrl);
                },
                onError: (_result) => {
                    setError('Pembayaran gagal. Silakan coba lagi atau pilih metode lain.');
                    setLoading(false);
                },
                onClose: () => {
                    // User tutup popup tanpa bayar → ke daftar pesanan
                    // Order sudah terbuat, bisa bayar nanti dari halaman pesanan
                    router.visit(render('orders.index'));
                    setLoading(false);
                },
            });

        } catch (e) {
            setError('Terjadi kesalahan jaringan. Silakan coba lagi.');
            setLoading(false);
        }
    };

    return (
        <MainLayout>
            <Head title="Konfirmasi Pesanan — Parigi Market" />

            <link
                href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
                rel="stylesheet"
            />

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                <h5 className="text-xl font-black text-[#1a3a2a] mb-6" style={{ fontFamily: "'Playfair Display', serif" }}>
                    🛒 Konfirmasi Pesanan
                </h5>

                {error && (
                    <div className="mb-4 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">
                        {error}
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {/* ── Kiri: Form ── */}
                    <div className="lg:col-span-2 space-y-5">

                        {/* Daftar Produk */}
                        <div className="bg-white rounded-2xl shadow-[0_2px_10px_rgba(26,58,42,0.07)] overflow-hidden">
                            <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm text-[#1a3a2a]">
                                Produk yang Dipesan
                            </div>
                            <div className="divide-y divide-gray-50">
                                {items.map((item, i) => (
                                    <div key={i} className="flex items-center gap-3 px-5 py-4">
                                        <div className="w-14 h-14 rounded-xl overflow-hidden bg-[#d8f3dc] flex-shrink-0">
                                            {item.image ? (
                                                <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-2xl">📦</div>
                                            )}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="font-semibold text-sm text-[#1a3a2a] truncate">{item.name}</p>
                                            <p className="text-xs text-gray-400">{formatRp(item.price)} × {item.quantity}</p>
                                        </div>
                                        <span className="font-bold text-sm text-[#2d6a4f] flex-shrink-0">
                                            {formatRp(item.subtotal)}
                                        </span>
                                    </div>
                                ))}
                            </div>
                        </div>

                        {/* Metode Pengiriman */}
                        <div className="bg-white rounded-2xl shadow-[0_2px_10px_rgba(26,58,42,0.07)] p-5">
                            <h6 className="font-bold text-sm text-[#1a3a2a] mb-4">🚚 Metode Pengiriman</h6>
                            <div className="space-y-2.5">
                                {shippingMethods.map(method => (
                                    <label
                                        key={method.id}
                                        className={`flex items-start gap-3 p-4 rounded-xl border-2 cursor-pointer transition
                                            ${selectedShipping?.id === method.id
                                                ? 'border-[#40916c] bg-[#d8f3dc]/30'
                                                : 'border-gray-100 hover:border-[#40916c]/40'
                                            }`}
                                    >
                                        <input
                                            type="radio"
                                            name="shipping"
                                            value={method.id}
                                            checked={selectedShipping?.id === method.id}
                                            onChange={() => setSelectedShipping(method)}
                                            className="mt-0.5 accent-[#40916c]"
                                        />
                                        <div>
                                            <p className="font-semibold text-sm text-[#1a3a2a]">
                                                {method.code === 'pickup' ? '🏪' : '🚚'} {method.name}
                                            </p>
                                            {method.description && (
                                                <p className="text-xs text-gray-400 mt-0.5">{method.description}</p>
                                            )}
                                        </div>
                                    </label>
                                ))}
                            </div>

                            {needsAddress && (
                                <div className="mt-4">
                                    <label className="block text-xs font-semibold text-gray-600 mb-1.5">
                                        Alamat Pengiriman <span className="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        value={address}
                                        onChange={e => setAddress(e.target.value)}
                                        rows={3}
                                        placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota"
                                        className="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm resize-none outline-none transition focus:border-[#40916c] focus:ring-2 focus:ring-[#40916c]/15"
                                    />
                                </div>
                            )}
                        </div>

                        {/* Metode Pembayaran */}
                        <div className="bg-white rounded-2xl shadow-[0_2px_10px_rgba(26,58,42,0.07)] p-5">
                            <h6 className="font-bold text-sm text-[#1a3a2a] mb-4">💳 Metode Pembayaran</h6>
                            <div className="space-y-2.5">
                                {paymentMethods.map(method => (
                                    <label
                                        key={method.id}
                                        className={`flex items-start gap-3 p-4 rounded-xl border-2 cursor-pointer transition
                                            ${selectedPayment?.id === method.id
                                                ? 'border-[#40916c] bg-[#d8f3dc]/30'
                                                : 'border-gray-100 hover:border-[#40916c]/40'
                                            }`}
                                    >
                                        <input
                                            type="radio"
                                            name="payment"
                                            value={method.id}
                                            checked={selectedPayment?.id === method.id}
                                            onChange={() => setSelectedPayment(method)}
                                            className="mt-0.5 accent-[#40916c]"
                                        />
                                        <div>
                                            <p className="font-semibold text-sm text-[#1a3a2a]">{method.name}</p>
                                            {method.description && (
                                                <p className="text-xs text-gray-400 mt-0.5">{method.description}</p>
                                            )}
                                        </div>
                                    </label>
                                ))}
                            </div>
                        </div>

                        {/* Catatan */}
                        <div className="bg-white rounded-2xl shadow-[0_2px_10px_rgba(26,58,42,0.07)] p-5">
                            <label className="block font-bold text-sm text-[#1a3a2a] mb-2">📝 Catatan (opsional)</label>
                            <textarea
                                value={notes}
                                onChange={e => setNotes(e.target.value)}
                                rows={2}
                                placeholder="Catatan untuk penjual..."
                                className="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm resize-none outline-none transition focus:border-[#40916c] focus:ring-2 focus:ring-[#40916c]/15"
                            />
                        </div>
                    </div>

                    {/* ── Kanan: Ringkasan ── */}
                    <div className="lg:col-span-1">
                        <div className="bg-white rounded-2xl shadow-[0_4px_18px_rgba(26,58,42,0.09)] p-6 sticky top-20">
                            <h6 className="font-bold text-[#1a3a2a] mb-5">Ringkasan Belanja</h6>

                            <div className="space-y-2.5 text-sm">
                                <div className="flex justify-between text-gray-500">
                                    <span>Subtotal ({items.length} produk)</span>
                                    <span>{subtotal_formatted}</span>
                                </div>
                                <div className="flex justify-between text-gray-500">
                                    <span>Ongkos Kirim</span>
                                    <span className="text-[#40916c] font-semibold">
                                        {shippingCost === 0 ? 'Gratis' : formatRp(shippingCost)}
                                    </span>
                                </div>
                            </div>

                            <div className="flex justify-between items-center font-bold text-[#1a3a2a] text-base pt-4 mt-3 border-t border-gray-100">
                                <span>Total</span>
                                <span className="text-lg text-[#2d6a4f]" style={{ fontFamily: "'Playfair Display', serif" }}>
                                    {formatRp(totalAmount)}
                                </span>
                            </div>

                            <button
                                onClick={handleCheckout}
                                disabled={loading || items.length === 0 || !snapReady}
                                className="mt-5 w-full bg-[#40916c] text-white font-bold py-3 rounded-xl border-none cursor-pointer transition hover:bg-[#2d6a4f] hover:-translate-y-0.5 disabled:opacity-60 disabled:cursor-not-allowed disabled:translate-y-0 text-sm"
                            >
                                {loading ? (
                                    <span className="flex items-center justify-center gap-2">
                                        <svg className="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                            <circle className="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth="4" />
                                            <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z" />
                                        </svg>
                                        Memproses...
                                    </span>
                                ) : !snapReady ? (
                                    'Memuat sistem pembayaran...'
                                ) : (
                                    'Bayar Sekarang →'
                                )}
                            </button>

                            <Link
                                href={render('cart.index')}
                                className="block text-center mt-3 text-sm text-[#40916c] no-underline hover:underline"
                            >
                                ← Kembali ke Keranjang
                            </Link>

                            <div className="mt-4 flex items-center gap-2 text-xs text-gray-400 justify-center">
                                <span>🔒</span>
                                <span>Pembayaran aman diproses oleh Midtrans</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
