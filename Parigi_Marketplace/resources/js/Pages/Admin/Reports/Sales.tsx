import { Head } from '@inertiajs/react';
import { useEffect, useRef } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';

interface SalesProps {
    totalSold: number;
    totalOrders: number;
    totalRevenue: string;
    products: { name: string; category: string; price: string; quantity: number }[];
}

export default function Sales({ totalSold, totalOrders, totalRevenue, products }: SalesProps) {
    const chartRef = useRef<HTMLCanvasElement>(null);

    useEffect(() => {
        if (!chartRef.current) return;

        import('chart.js/auto').then((ChartModule) => {
            const Chart = ChartModule.default;

            new Chart(chartRef.current!, {
                type: 'line',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agt','Sep','Okt','Nov','Des'],
                    datasets: [{ label: 'Pendapatan', data: [2100000,3400000,4200000,3800000,5100000,4600000,6200000,5800000,7100000,6500000,8200000,9100000], borderColor: '#22a046', backgroundColor: 'rgba(34,160,70,0.08)', tension: 0.4, fill: true, pointBackgroundColor: '#22a046' }],
                },
                options: { plugins: { legend: { display: false } }, scales: { y: { ticks: { callback: (v: any) => 'Rp ' + v.toLocaleString('id-ID') }, grid: { color: '#f3f4f6' } }, x: { grid: { display: false } } }, responsive: true },
            });
        });
    }, []);

    return (
        <AdminLayout title="Laporan Penjualan" breadcrumb="Admin → Laporan → Penjualan" activeMenu="sales">
            <Head title="Laporan Penjualan — Admin" />

            <div className="space-y-5">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {[
                        { icon: '📦', label: 'Total Item Terjual', value: String(totalSold), color: 'bg-green-50' },
                        { icon: '🛍️', label: 'Pesanan Selesai', value: String(totalOrders), color: 'bg-green-50' },
                        { icon: '💰', label: 'Total Pendapatan', value: totalRevenue, color: 'bg-amber-50' },
                    ].map((s, i) => (
                        <div key={i} className="bg-white rounded-2xl p-5 border border-gray-100">
                            <div className={`w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 ${s.color}`}>{s.icon}</div>
                            <div className="text-2xl font-bold text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>{s.value}</div>
                            <div className="text-xs text-gray-400 mt-1">{s.label}</div>
                        </div>
                    ))}
                </div>

                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm" style={{ fontFamily: "'Sora', sans-serif" }}>📈 Grafik Penjualan Bulanan</div>
                    <div className="p-5"><canvas ref={chartRef} height={80} /></div>
                </div>

                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm" style={{ fontFamily: "'Sora', sans-serif" }}>📦 Daftar Produk</div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead>
                            <tr className="border-b border-gray-100 bg-gray-50">
                                {['Produk', 'Kategori', 'Harga', 'Stok Sisa'].map((h, i) => (
                                    <th key={i} className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
                                ))}
                            </tr>
                            </thead>
                            <tbody>
                            {products.map((p, i) => (
                                <tr key={i} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td className="px-5 py-3 font-semibold text-gray-900">{p.name}</td>
                                    <td className="px-5 py-3 text-gray-400">{p.category}</td>
                                    <td className="px-5 py-3 font-semibold text-[#1a7c36]">{p.price}</td>
                                    <td className={`px-5 py-3 font-semibold ${p.quantity < 20 ? 'text-red-500' : 'text-gray-600'}`}>{p.quantity}</td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
