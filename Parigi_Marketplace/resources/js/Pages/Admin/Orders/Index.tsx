import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface Order {
    id: number;
    order_number: string;
    buyer_name: string;
    buyer_email: string;
    total_amount: string;
    created_at: string;
    status: string;
}

interface Props { orders: Order[]; }

const STATUS_STYLES: Record<string, { bg: string; text: string; label: string }> = {
    pending_payment: { bg: 'bg-amber-100', text: 'text-amber-700', label: 'Menunggu Bayar' },
    paid:            { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dibayar' },
    processing:      { bg: 'bg-teal-100',  text: 'text-teal-700',  label: 'Diproses' },
    shipped:         { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dikirim' },
    completed:       { bg: 'bg-green-100', text: 'text-green-700', label: 'Selesai' },
    canceled:        { bg: 'bg-red-100',   text: 'text-red-600',   label: 'Dibatalkan' },
};

const ALL_STATUSES = Object.entries(STATUS_STYLES).map(([k, v]) => ({ value: k, label: v.label }));

export default function AdminOrdersIndex({ orders }: Props) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const handleStatusChange = (orderId: number, status: string) => {
        router.patch(render('admin.orders.updateStatus', orderId), { status }, { preserveScroll: true });
    };

    return (
        <AdminLayout title="Kelola Pesanan" breadcrumb="Admin → Pesanan" activeMenu="orders">
            <Head title="Kelola Pesanan" />

            <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>📋 Semua Pesanan</div>
                    <span className="text-xs text-gray-400">{orders.length} total pesanan</span>
                </div>

                {orders.length === 0 ? (
                    <div className="text-center py-16 text-gray-400">
                        <div className="text-5xl mb-3">📭</div>
                        <p>Belum ada pesanan masuk</p>
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead>
                            <tr className="border-b border-gray-100 bg-gray-50">
                                {['ID', 'Pembeli', 'Total', 'Tanggal', 'Status', 'Ubah Status', ''].map((h, i) => (
                                    <th key={i} className="text-left px-4 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
                                ))}
                            </tr>
                            </thead>
                            <tbody>
                            {orders.map(order => {
                                const st = STATUS_STYLES[order.status] ?? { bg: 'bg-gray-100', text: 'text-gray-500', label: order.status };
                                return (
                                    <tr key={order.id} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td className="px-4 py-3 font-mono text-xs font-semibold text-[#1a7c36]">#{order.order_number}</td>
                                        <td className="px-4 py-3">
                                            <div className="font-semibold text-gray-900">{order.buyer_name}</div>
                                            <div className="text-xs text-gray-400">{order.buyer_email}</div>
                                        </td>
                                        <td className="px-4 py-3 font-semibold text-[#1a7c36]">{order.total_amount}</td>
                                        <td className="px-4 py-3 text-xs text-gray-400">{order.created_at}</td>
                                        <td className="px-4 py-3">
                                            <span className={`text-[11px] font-bold px-2.5 py-0.5 rounded-full ${st.bg} ${st.text}`}>{st.label}</span>
                                        </td>
                                        <td className="px-4 py-3">
                                            <div className="flex items-center gap-2">
                                                <select
                                                    defaultValue={order.status}
                                                    onChange={e => handleStatusChange(order.id, e.target.value)}
                                                    className="text-xs px-2 py-1.5 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-1 focus:ring-[#22a046]"
                                                >
                                                    {ALL_STATUSES.map(s => (
                                                        <option key={s.value} value={s.value}>{s.label}</option>
                                                    ))}
                                                </select>
                                            </div>
                                        </td>
                                        <td className="px-4 py-3">
                                            <Link href={render('admin.orders.show', order.id)} className="text-xs font-semibold text-gray-500 border border-gray-200 px-2.5 py-1 rounded-lg no-underline hover:bg-gray-100 transition">
                                                Detail
                                            </Link>
                                        </td>
                                    </tr>
                                );
                            })}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
