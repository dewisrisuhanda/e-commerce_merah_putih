import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface OrderItem {
    id: number;
    product_name: string;
    product_price: string;
    quantity: number;
    subtotal: string;
    image: string | null;
}

interface OrderDetail {
    id: number;
    order_number: string;
    buyer_name: string;
    buyer_email: string;
    created_at: string;
    status: string;
    payment_method: string;
    shipping_method: string;
    address: string | null;
    subtotal: string;
    shipping_cost: string;
    total_amount: string;
    items: OrderItem[];
}

interface ShowProps { order: OrderDetail; }

const STATUS_STYLES: Record<string, { bg: string; text: string; label: string }> = {
    pending_payment: { bg: 'bg-amber-100', text: 'text-amber-700', label: 'Menunggu Bayar' },
    paid:            { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dibayar' },
    processing:      { bg: 'bg-teal-100',  text: 'text-teal-700',  label: 'Diproses' },
    shipped:         { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dikirim' },
    completed:       { bg: 'bg-green-100', text: 'text-green-700', label: 'Selesai' },
    canceled:        { bg: 'bg-red-100',   text: 'text-red-600',   label: 'Dibatalkan' },
};

const ALL_STATUSES = Object.entries(STATUS_STYLES).map(([k, v]) => ({ value: k, label: v.label }));

export default function Show({ order }: ShowProps) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';
    const st = STATUS_STYLES[order.status] ?? { bg: 'bg-gray-100', text: 'text-gray-500', label: order.status };

    const handleStatusChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        router.patch(render('admin.orders.updateStatus', order.id), { status: e.target.value });
    };

    return (
        <AdminLayout title={`Detail Pesanan #${order.order_number}`} breadcrumb="Admin → Pesanan → Detail" activeMenu="orders">
            <Head title={`Pesanan #${order.order_number}`} />

            <div className="max-w-3xl space-y-5">
                {/* Info + Status */}
                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>📋 Informasi Pesanan</div>
                        <div className="flex items-center gap-3">
                            <span className={`text-[11px] font-bold px-3 py-1 rounded-full ${st.bg} ${st.text}`}>{st.label}</span>
                            <Link href={render('admin.orders.index')} className="text-xs text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg no-underline hover:bg-gray-50 transition">← Kembali</Link>
                        </div>
                    </div>
                    <div className="p-5 grid grid-cols-2 gap-4">
                        {[
                            { label: 'ID Pesanan', value: `#${order.order_number}`, mono: true },
                            { label: 'Tanggal', value: order.created_at },
                            { label: 'Pembeli', value: order.buyer_name },
                            { label: 'Email', value: order.buyer_email },
                            { label: 'Metode Bayar', value: order.payment_method },
                            { label: 'Metode Kirim', value: order.shipping_method === 'pickup' ? '🏪 Ambil di Toko' : '🚚 Antar ke Rumah' },
                        ].map((row, i) => (
                            <div key={i}>
                                <div className="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">{row.label}</div>
                                <div className={`text-sm font-medium text-gray-900 ${row.mono ? 'font-mono text-[#1a7c36]' : ''}`}>{row.value}</div>
                            </div>
                        ))}
                    </div>
                    {order.address && (
                        <div className="px-5 pb-5">
                            <div className="text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">Alamat Kirim</div>
                            <p className="text-sm text-gray-600 whitespace-pre-line">{order.address}</p>
                        </div>
                    )}
                </div>

                {/* Ubah Status */}
                <div className="bg-white rounded-2xl border border-gray-100 p-5">
                    <div className="font-bold text-sm text-gray-900 mb-3" style={{ fontFamily: "'Sora', sans-serif" }}>🔄 Ubah Status Pesanan</div>
                    <div className="flex items-center gap-3">
                        <select defaultValue={order.status} onChange={handleStatusChange} className="text-sm px-3 py-2 border border-gray-300 rounded-lg bg-white cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#22a046]/20 focus:border-[#22a046]">
                            {ALL_STATUSES.map(s => <option key={s.value} value={s.value}>{s.label}</option>)}
                        </select>
                    </div>
                </div>

                {/* Items */}
                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>🛒 Produk Dipesan</div>
                    <table className="w-full text-sm">
                        <thead>
                        <tr className="border-b border-gray-100 bg-gray-50">
                            <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Produk</th>
                            <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                            <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Qty</th>
                            <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        {order.items.map(item => (
                            <tr key={item.id} className="border-b border-gray-50">
                                <td className="px-5 py-3">
                                    <div className="flex items-center gap-3">
                                        {item.image ? (
                                            <img src={item.image} alt={item.product_name} className="w-10 h-10 rounded-lg object-cover border border-gray-100" />
                                        ) : (
                                            <div className="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-lg">📦</div>
                                        )}
                                        <span className="font-semibold text-gray-900">{item.product_name}</span>
                                    </div>
                                </td>
                                <td className="px-5 py-3 text-gray-500">{item.product_price}</td>
                                <td className="px-5 py-3 text-gray-600">{item.quantity}</td>
                                <td className="px-5 py-3 font-semibold text-[#1a7c36]">{item.subtotal}</td>
                            </tr>
                        ))}
                        <tr className="bg-gray-50 font-bold">
                            <td colSpan={3} className="px-5 py-3 text-right text-sm text-gray-700">Total</td>
                            <td className="px-5 py-3 text-[#1a7c36]">{order.total_amount}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
