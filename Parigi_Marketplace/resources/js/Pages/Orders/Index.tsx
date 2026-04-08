import { Head, Link } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface Order {
    id: number;
    order_number: string;
    created_at: string;
    total_amount: string;
    status: string;
    status_label: string;
    items_count: number;
}

interface Props {
    orders: Order[];
}

// ─── Status badge config ──────────────────────────────────
const STATUS_STYLES: Record<string, { bg: string; text: string; label: string }> = {
    pending_payment: { bg: 'bg-yellow-100', text: 'text-yellow-700', label: 'Menunggu Pembayaran' },
    paid:            { bg: 'bg-blue-100',   text: 'text-blue-700',   label: 'Dibayar' },
    processing:      { bg: 'bg-cyan-100',   text: 'text-cyan-700',   label: 'Diproses' },
    shipped:         { bg: 'bg-purple-100', text: 'text-purple-700', label: 'Dikirim' },
    completed:       { bg: 'bg-green-100',  text: 'text-green-700',  label: 'Selesai' },
    canceled:        { bg: 'bg-red-100',    text: 'text-red-600',    label: 'Dibatalkan' },
};

function StatusBadge({ status }: { status: string }) {
    const style = STATUS_STYLES[status] ?? { bg: 'bg-gray-100', text: 'text-gray-600', label: status };
    return (
        <span className={`inline-block text-[0.72rem] font-bold px-2.5 py-0.5 rounded-full ${style.bg} ${style.text}`}>
            {style.label}
        </span>
    );
}

// ─── Component ────────────────────────────────────────────
export default function Index({ orders }: Props) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    return (
        <MainLayout>
            <Head title="Riwayat Pesanan — Parigi Market" />

            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                <h5
                    className="text-xl font-black text-[#1a3a2a] mb-6"
                    style={{ fontFamily: "'Playfair Display', serif" }}
                >
                    🛍️ Riwayat Pesanan
                </h5>

                {orders.length === 0 ? (
                    <div className="text-center py-20">
                        <div className="text-6xl mb-4">📦</div>
                        <p className="text-gray-400 mb-5">Belum ada pesanan.</p>
                        <Link
                            href={render('products.index')}
                            className="inline-block bg-[#40916c] text-white font-semibold px-6 py-2.5 rounded-full no-underline transition hover:bg-[#2d6a4f]"
                        >
                            Mulai Belanja
                        </Link>
                    </div>
                ) : (
                    <div className="overflow-x-auto bg-white rounded-2xl shadow-[0_2px_12px_rgba(26,58,42,0.07)]">
                        <table className="w-full text-sm">
                            <thead>
                                <tr className="border-b border-gray-100">
                                    <th className="text-left px-5 py-3.5 text-[0.75rem] font-bold tracking-wider uppercase text-gray-400">#</th>
                                    <th className="text-left px-5 py-3.5 text-[0.75rem] font-bold tracking-wider uppercase text-gray-400">Tanggal</th>
                                    <th className="text-left px-5 py-3.5 text-[0.75rem] font-bold tracking-wider uppercase text-gray-400">Total</th>
                                    <th className="text-left px-5 py-3.5 text-[0.75rem] font-bold tracking-wider uppercase text-gray-400">Status</th>
                                    <th className="px-5 py-3.5"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {orders.map(order => (
                                    <tr key={order.id} className="border-b border-gray-50 hover:bg-[#f8faf8] transition">
                                        <td className="px-5 py-4 font-semibold text-[#1a3a2a]">
                                            {order.order_number}
                                        </td>
                                        <td className="px-5 py-4 text-gray-500">{order.created_at}</td>
                                        <td className="px-5 py-4 font-bold text-[#2d6a4f]">{order.total_amount}</td>
                                        <td className="px-5 py-4">
                                            <StatusBadge status={order.status} />
                                        </td>
                                        <td className="px-5 py-4 text-right">
                                            <Link
                                                href={render('orders.show', order.id)}
                                                className="text-[0.8rem] font-semibold text-[#40916c] border border-[#40916c]/30 px-3 py-1.5 rounded-lg no-underline transition hover:bg-[#40916c] hover:text-white hover:border-[#40916c]"
                                            >
                                                Detail
                                            </Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
