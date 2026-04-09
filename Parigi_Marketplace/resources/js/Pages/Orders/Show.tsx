import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface OrderItem {
    id: number;
    product_id: number;
    product_name: string;
    product_price: string;
    quantity: number;
    subtotal: string;
    image: string | null;
}

interface Order {
    id: number;
    order_number: string;
    created_at: string;
    status: string;
    payment_method: string;
    shipping_method: string;
    address: string | null;
    subtotal: string;
    shipping_cost: string;
    total_amount: string;
    notes: string | null;
    items: OrderItem[];
}

interface Props {
    order: Order;
}

// ─── Status config ────────────────────────────────────────
const STATUS_STYLES: Record<string, { bg: string; text: string; label: string }> = {
    pending_payment: { bg: 'bg-yellow-100', text: 'text-yellow-700', label: 'Menunggu Pembayaran' },
    paid:            { bg: 'bg-blue-100',   text: 'text-blue-700',   label: 'Dibayar' },
    processing:      { bg: 'bg-cyan-100',   text: 'text-cyan-700',   label: 'Diproses' },
    shipped:         { bg: 'bg-purple-100', text: 'text-purple-700', label: 'Dikirim' },
    completed:       { bg: 'bg-green-100',  text: 'text-green-700',  label: 'Selesai' },
    canceled:        { bg: 'bg-red-100',    text: 'text-red-600',    label: 'Dibatalkan' },
};

// ─── Component ────────────────────────────────────────────
export default function Show({ order }: Props) {
    const render = (name: string) => route().has(name) ? route(name) : '#';
    const status = STATUS_STYLES[order.status] ?? { bg: 'bg-gray-100', text: 'text-gray-600', label: order.status };

    return (
        <MainLayout>
            <Head title={`Pesanan ${order.order_number}`} />

            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* Breadcrumb */}
                <div className="flex items-center gap-3 mb-6">
                    <Link
                        href={render('orders.index')}
                        className="text-sm text-[#40916c] border border-[#40916c]/30 px-3 py-1.5 rounded-lg no-underline transition hover:bg-[#40916c] hover:text-white"
                    >
                        ← Kembali
                    </Link>
                    <h5
                        className="text-xl font-black text-[#1a3a2a] m-0"
                        style={{ fontFamily: "'Playfair Display', serif" }}
                    >
                        Detail Pesanan #{order.order_number}
                    </h5>
                </div>

                <div className="grid md:grid-cols-2 gap-5">

                    {/* ── Info Pesanan ── */}
                    <div className="bg-white rounded-2xl p-5 shadow-[0_2px_10px_rgba(26,58,42,0.07)]">
                        <h6 className="font-bold text-[#1a3a2a] mb-4">Info Pesanan</h6>
                        <table className="w-full text-sm">
                            <tbody className="divide-y divide-gray-50">
                                {[
                                    { label: 'Nomor Pesanan', value: order.order_number },
                                    { label: 'Tanggal', value: order.created_at },
                                    {
                                        label: 'Status',
                                        value: (
                                            <span className={`inline-block text-[0.72rem] font-bold px-2.5 py-0.5 rounded-full ${status.bg} ${status.text}`}>
                                                {status.label}
                                            </span>
                                        ),
                                    },
                                    { label: 'Metode Bayar', value: order.payment_method },
                                    { label: 'Metode Kirim', value: order.shipping_method === 'antar' ? '🚚 Antar ke Rumah' : '🏪 Ambil di Toko' },
                                ].map((row, i) => (
                                    <tr key={i}>
                                        <td className="py-2.5 pr-4 text-gray-400 w-[40%]">{row.label}</td>
                                        <td className="py-2.5 font-medium text-[#1a3a2a]">{row.value}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* ── Alamat Pengiriman ── */}
                    <div className="bg-white rounded-2xl p-5 shadow-[0_2px_10px_rgba(26,58,42,0.07)]">
                        <h6 className="font-bold text-[#1a3a2a] mb-3">Alamat Pengiriman</h6>
                        <p className="text-sm text-gray-500 leading-relaxed whitespace-pre-line">
                            {order.address ?? 'Ambil di Toko — Jl. Trans Sulawesi, Parigi'}
                        </p>
                        {order.notes && (
                            <div className="mt-3 pt-3 border-t border-gray-100">
                                <p className="text-[0.75rem] font-bold uppercase tracking-wider text-gray-400 mb-1">Catatan</p>
                                <p className="text-sm text-gray-500">{order.notes}</p>
                            </div>
                        )}
                    </div>

                    {/* ── Produk Dipesan ── */}
                    <div className="md:col-span-2 bg-white rounded-2xl p-5 shadow-[0_2px_10px_rgba(26,58,42,0.07)]">
                        <h6 className="font-bold text-[#1a3a2a] mb-4">Produk yang Dipesan</h6>

                        <div className="flex flex-col divide-y divide-gray-50">
                            {order.items.map(item => (
                                <div key={item.id} className="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                                    {/* Image */}
                                    <div className="w-16 h-16 rounded-xl overflow-hidden flex-shrink-0 bg-[#d8f3dc]">
                                        {item.image ? (
                                            <img
                                                src={item.image}
                                                alt={item.product_name}
                                                className="w-full h-full object-cover"
                                                onError={(e) => { (e.target as HTMLImageElement).style.display = 'none'; }}
                                            />
                                        ) : (
                                            <div className="w-full h-full flex items-center justify-center text-[#40916c] text-2xl">📦</div>
                                        )}
                                    </div>

                                    {/* Info */}
                                    <div className="flex-1 min-w-0">
                                        <p className="font-semibold text-[#1a3a2a] text-sm mb-0.5 truncate">{item.product_name}</p>
                                        <p className="text-gray-400 text-xs">
                                            {item.product_price} × {item.quantity}
                                        </p>
                                    </div>

                                    {/* Subtotal */}
                                    <span className="font-bold text-[#2d6a4f] text-sm flex-shrink-0">{item.subtotal}</span>
                                </div>
                            ))}
                        </div>

                        {/* Total Summary */}
                        <div className="mt-4 pt-4 border-t border-gray-100 space-y-2">
                            <div className="flex justify-between text-sm text-gray-500">
                                <span>Subtotal</span>
                                <span>{order.subtotal}</span>
                            </div>
                            <div className="flex justify-between text-sm text-gray-500">
                                <span>Ongkos kirim</span>
                                <span className={order.shipping_cost === 'Rp 0' ? 'text-[#40916c] font-semibold' : ''}>
                                    {order.shipping_cost === 'Rp 0' ? 'Gratis' : order.shipping_cost}
                                </span>
                            </div>
                            <div className="flex justify-between font-bold text-[#1a3a2a] text-base pt-2 border-t border-gray-100">
                                <span>Total</span>
                                <span
                                    className="text-[#2d6a4f]"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    {order.total_amount}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
