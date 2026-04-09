import { Head, Link } from '@inertiajs/react';
import { useEffect, useRef } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';

// ─── Types ────────────────────────────────────────────────
interface StatCard {
    label: string;
    value: string;
    icon: string;
    color: string;
}

interface Product {
    id: number;
    name: string;
    category: string;
    price: string;
    quantity: number;
    slug: string;
}

interface Order {
    id: number;
    order_number: string;
    buyer_name: string;
    buyer_email: string;
    total_amount: string;
    payment_method: string;
    status: string;
    created_at: string;
}

interface CategoryCount {
    name: string;
    count: number;
}

interface Props {
    stats: StatCard[];
    recentProducts: Product[];
    recentOrders: Order[];
    categoryCounts: CategoryCount[];
}

const STATUS_STYLES: Record<string, { bg: string; text: string }> = {
    pending_payment: { bg: 'bg-amber-100', text: 'text-amber-700' },
    paid:            { bg: 'bg-blue-100',  text: 'text-blue-700' },
    processing:      { bg: 'bg-teal-100',  text: 'text-teal-700' },
    shipped:         { bg: 'bg-blue-100',  text: 'text-blue-700' },
    completed:       { bg: 'bg-green-100', text: 'text-green-700' },
    canceled:        { bg: 'bg-red-100',   text: 'text-red-600' },
};

const STATUS_LABELS: Record<string, string> = {
    pending_payment: 'Menunggu Bayar',
    paid:            'Dibayar',
    processing:      'Diproses',
    shipped:         'Dikirim',
    completed:       'Selesai',
    canceled:        'Dibatalkan',
};

const CATEGORY_ICONS: Record<string, string> = {
    'Hasil Tani': '🌾', 'Hasil Laut': '🐟', 'Oleh-oleh': '🎁',
    'Buah-buahan': '🍈', 'Rempah': '🌶️', 'Produk Olahan': '🏭',
    'Biofarmaka': '🌱', 'Sayuran': '🥬', 'Kerajinan': '🎨',
};

export default function Dashboard({ stats, recentProducts, recentOrders, categoryCounts }: Props) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';
    const chartRef = useRef<HTMLCanvasElement>(null);
    const donutRef = useRef<HTMLCanvasElement>(null);

    useEffect(() => {
        if (!chartRef.current || !donutRef.current) return;

        import('chart.js/auto').then((ChartModule) => {
            const Chart = ChartModule.default;

            new Chart(chartRef.current!, {
                type: 'bar',
                data: {
                    labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                    datasets: [{
                        data: [520000, 740000, 960000, 680000, 1100000, 800000, 890000],
                        backgroundColor: ['#d4f5de','#d4f5de','#22a046','#22a046','#22a046','#d4f5de','#22a046'],
                        borderRadius: 6, borderSkipped: false,
                    }],
                },
                options: {
                    plugins: { legend: { display: false }, tooltip: { callbacks: { label: (ctx: any) => 'Rp ' + ctx.raw.toLocaleString('id-ID') } } },
                    scales: { y: { display: false }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } },
                    responsive: true, maintainAspectRatio: true,
                },
            });

            const catData = categoryCounts.slice(0, 4);
            new Chart(donutRef.current!, {
                type: 'doughnut',
                data: {
                    labels: catData.map(c => c.name),
                    datasets: [{ data: catData.map(c => c.count), backgroundColor: ['#22a046','#2dc653','#d4f5de','#6b7280'], borderWidth: 0 }],
                },
                options: { cutout: '68%', plugins: { legend: { display: false } }, responsive: false },
            });
        });
    }, []);

    return (
        <AdminLayout title="Dashboard" breadcrumb="Admin → Dashboard" activeMenu="dashboard">
            <Head title="Dashboard — Admin Parigi" />

            <div className="space-y-6">

                {/* ── Stat Cards ── */}
                <div className="grid grid-cols-2 lg:grid-cols-4 gap-4">
                    {stats.map((stat, i) => (
                        <div key={i} className="bg-white rounded-2xl p-5 border border-gray-100">
                            <div className={`w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 ${stat.color}`}>
                                {stat.icon}
                            </div>
                            <div className="text-2xl font-bold text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                                {stat.value}
                            </div>
                            <div className="text-xs text-gray-500 mt-1">{stat.label}</div>
                        </div>
                    ))}
                </div>

                {/* ── Charts ── */}
                <div className="grid lg:grid-cols-3 gap-5">
                    <div className="lg:col-span-2 bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <div className="px-5 py-4 border-b border-gray-100">
                            <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>📈 Penjualan Minggu Ini</div>
                            <div className="text-xs text-gray-400 mt-0.5">Pendapatan harian</div>
                        </div>
                        <div className="p-5"><canvas ref={chartRef} height={80} /></div>
                    </div>
                    <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <div className="px-5 py-4 border-b border-gray-100">
                            <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>🏷️ Kategori</div>
                            <div className="text-xs text-gray-400 mt-0.5">Distribusi produk</div>
                        </div>
                        <div className="p-5 flex flex-col items-center gap-4">
                            <canvas ref={donutRef} width={140} height={140} />
                            <div className="w-full space-y-2">
                                {categoryCounts.slice(0, 4).map((cat, i) => (
                                    <div key={i} className="flex items-center justify-between text-xs">
                                        <div className="flex items-center gap-1.5">
                                            <span>{CATEGORY_ICONS[cat.name] ?? '📦'}</span>
                                            <span className="text-gray-600">{cat.name}</span>
                                        </div>
                                        <span className="font-semibold text-[#22a046]">{cat.count}</span>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>

                {/* ── Recent Products + Orders ── */}
                <div className="grid lg:grid-cols-2 gap-5">
                    {/* Products */}
                    <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>📦 Produk Terbaru</div>
                                <div className="text-xs text-gray-400 mt-0.5">Ditambahkan terakhir</div>
                            </div>
                        </div>
                        <table className="w-full text-xs">
                            <thead>
                                <tr className="border-b border-gray-50">
                                    <th className="text-left px-5 py-3 text-gray-400 font-semibold uppercase tracking-wider">Produk</th>
                                    <th className="text-left px-5 py-3 text-gray-400 font-semibold uppercase tracking-wider">Harga</th>
                                    <th className="text-left px-5 py-3 text-gray-400 font-semibold uppercase tracking-wider">Stok</th>
                                    <th className="px-5 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                {recentProducts.length === 0 ? (
                                    <tr><td colSpan={4} className="text-center py-8 text-gray-400">Belum ada produk</td></tr>
                                ) : recentProducts.map(p => (
                                    <tr key={p.id} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td className="px-5 py-3">
                                            <div className="flex items-center gap-2">
                                                <span className="text-base">{CATEGORY_ICONS[p.category] ?? '📦'}</span>
                                                <div>
                                                    <div className="font-semibold text-gray-900">{p.name}</div>
                                                    <div className="text-gray-400">{p.category}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-5 py-3 font-semibold text-[#1a7c36]">{p.price}</td>
                                        <td className={`px-5 py-3 font-semibold ${p.quantity < 20 ? 'text-red-500' : 'text-gray-600'}`}>{p.quantity}</td>
                                        <td className="px-5 py-3">
                                            <Link href={render('admin.products.edit', p.slug)} className="text-[11px] font-semibold text-gray-500 border border-gray-200 px-2.5 py-1 rounded-lg no-underline hover:bg-gray-100 transition">Edit</Link>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                        <div className="px-5 py-3 border-t border-gray-50">
                            <Link href={render('admin.products.index')} className="text-xs text-[#22a046] no-underline hover:underline font-semibold">Lihat Semua Produk →</Link>
                        </div>
                    </div>

                    {/* Orders */}
                    <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                        <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <div>
                                <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>🛍️ Pesanan Terbaru</div>
                                <div className="text-xs text-gray-400 mt-0.5">Update terkini</div>
                            </div>
                        </div>
                        <div className="divide-y divide-gray-50">
                            {recentOrders.length === 0 ? (
                                <div className="text-center py-8 text-gray-400 text-xs">Belum ada pesanan</div>
                            ) : recentOrders.slice(0, 6).map(order => {
                                const st = STATUS_STYLES[order.status] ?? { bg: 'bg-gray-100', text: 'text-gray-500' };
                                return (
                                    <div key={order.id} className="flex items-center gap-3 px-5 py-3.5">
                                        <div className="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-base flex-shrink-0">🛍️</div>
                                        <div className="flex-1 min-w-0">
                                            <div className="font-semibold text-[13px] text-gray-900 truncate">{order.buyer_name}</div>
                                            <div className="text-xs text-gray-400">{order.total_amount}</div>
                                            <div className="mt-1 flex items-center gap-1.5">
                                                <span className={`text-[10px] font-bold px-2 py-0.5 rounded-full ${st.bg} ${st.text}`}>
                                                    {STATUS_LABELS[order.status] ?? order.status}
                                                </span>
                                                <span className="text-[10px] text-gray-400">{order.created_at}</span>
                                            </div>
                                        </div>
                                        <Link href={render('admin.orders.show', order.id)} className="text-[11px] font-semibold text-gray-500 border border-gray-200 px-2.5 py-1 rounded-lg no-underline hover:bg-gray-100 transition flex-shrink-0">Detail</Link>
                                    </div>
                                );
                            })}
                        </div>
                        <div className="px-5 py-3 border-t border-gray-50">
                            <Link href={render('admin.orders.index')} className="text-xs text-[#22a046] no-underline hover:underline font-semibold">Lihat Semua Pesanan →</Link>
                        </div>
                    </div>
                </div>

            </div>
        </AdminLayout>
    );
}
