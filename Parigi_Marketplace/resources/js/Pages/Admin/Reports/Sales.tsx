import { Head } from '@inertiajs/react';
import { useEffect, useRef } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';

// Data chart dari DB — dikirim dari ReportController via getSalesData()
interface ChartData {
    labels: string[]; // ['Jan', 'Feb', ..., 'Des']
    data: number[];   // [2100000, 3400000, ...]
}

interface SalesProps {
    totalSold: number;
    totalOrders: number;
    totalRevenue: string;
    products: {
        name: string;
        category: string;
        price: string;
        quantity: number;
    }[];
    chartData: ChartData;
}

export default function Sales({
    totalSold,
    totalOrders,
    totalRevenue,
    products,
    chartData,
}: SalesProps) {
    const chartRef = useRef<HTMLCanvasElement>(null);

    useEffect(() => {
        if (!chartRef.current) return;

        import('chart.js/auto').then(({ default: Chart }) => {
            new Chart(chartRef.current!, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Pendapatan',
                        data: chartData.data,
                        borderColor: '#22a046',
                        backgroundColor: 'rgba(34,160,70,0.08)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#22a046',
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }],
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx: any) =>
                                    'Rp ' + (ctx.raw as number).toLocaleString('id-ID'),
                            },
                        },
                    },
                    scales: {
                        y: {
                            ticks: {
                                callback: (v: any) => 'Rp ' + Number(v).toLocaleString('id-ID'),
                                font: { size: 11 },
                            },
                            grid: { color: '#f3f4f6' },
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } },
                        },
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                },
            });
        });
    }, [chartData]);

    const hasData = chartData.data.some(v => v > 0);

    return (
        <AdminLayout title="Laporan Penjualan" breadcrumb="Admin → Laporan → Penjualan" activeMenu="sales">
            <Head title="Laporan Penjualan" />

            <div className="space-y-5">

                {/* ── Stat Cards ── */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {[
                        { icon: '📦', label: 'Total Item Terjual', value: String(totalSold),   color: 'bg-green-50' },
                        { icon: '🛍️', label: 'Pesanan Selesai',    value: String(totalOrders), color: 'bg-green-50' },
                        { icon: '💰', label: 'Total Pendapatan',    value: totalRevenue,        color: 'bg-amber-50' },
                    ].map((s, i) => (
                        <div key={i} className="bg-white rounded-2xl p-5 border border-gray-100">
                            <div className={`w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 ${s.color}`}>
                                {s.icon}
                            </div>
                            <div className="text-2xl font-bold text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                                {s.value}
                            </div>
                            <div className="text-xs text-gray-400 mt-1">{s.label}</div>
                        </div>
                    ))}
                </div>

                {/* ── Line Chart — pendapatan bulanan dari DB ── */}
                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                                📈 Grafik Penjualan Bulanan
                            </div>
                            <div className="text-xs text-gray-400 mt-0.5">
                                Pendapatan per bulan tahun {new Date().getFullYear()} (pesanan selesai)
                            </div>
                        </div>
                    </div>
                    <div className="p-5">
                        {hasData ? (
                            <canvas ref={chartRef} height={80} />
                        ) : (
                            <div className="flex items-center justify-center h-24 text-gray-300 text-sm">
                                Belum ada data penjualan tahun ini
                            </div>
                        )}
                    </div>
                </div>

                {/* ── Product Table ── */}
                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                        📦 Daftar Produk
                    </div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead>
                                <tr className="border-b border-gray-100 bg-gray-50">
                                    {['Produk', 'Kategori', 'Harga', 'Stok Sisa'].map((h, i) => (
                                        <th key={i} className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                                            {h}
                                        </th>
                                    ))}
                                </tr>
                            </thead>
                            <tbody>
                                {products.length === 0 ? (
                                    <tr>
                                        <td colSpan={4} className="text-center py-10 text-gray-400">Belum ada produk</td>
                                    </tr>
                                ) : products.map((p, i) => (
                                    <tr key={i} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td className="px-5 py-3 font-semibold text-gray-900">{p.name}</td>
                                        <td className="px-5 py-3 text-gray-400">{p.category}</td>
                                        <td className="px-5 py-3 font-semibold text-[#1a7c36]">{p.price}</td>
                                        <td className={`px-5 py-3 font-semibold ${p.quantity < 20 ? 'text-red-500' : 'text-gray-600'}`}>
                                            {p.quantity}
                                        </td>
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
