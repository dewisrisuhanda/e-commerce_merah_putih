import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface Transaction {
    id: number;
    order_number: string;
    buyer_name: string;
    total_amount: string;
    payment_method: string;
    shipping_method: string;
    status: string;
}

interface FinanceProps {
    totalIncome: string;
    totalPending: number;
    totalCanceled: number;
    transactions: Transaction[];
}

const TXN_STATUS_STYLES: Record<string, { bg: string; text: string; label: string }> = {
    pending_payment: { bg: 'bg-amber-100', text: 'text-amber-700', label: 'Menunggu' },
    paid:            { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dibayar' },
    processing:      { bg: 'bg-teal-100',  text: 'text-teal-700',  label: 'Diproses' },
    shipped:         { bg: 'bg-blue-100',  text: 'text-blue-700',  label: 'Dikirim' },
    completed:       { bg: 'bg-green-100', text: 'text-green-700', label: 'Selesai' },
    canceled:        { bg: 'bg-red-100',   text: 'text-red-600',   label: 'Batal' },
};

export default function Finance({ totalIncome, totalPending, totalCanceled, transactions }: FinanceProps) {
    return (
        <AdminLayout title="Laporan Keuangan" breadcrumb="Admin → Laporan → Keuangan" activeMenu="finance">
            <Head title="Laporan Keuangan" />

            <div className="space-y-5">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {[
                        { icon: '💰', label: 'Total Pemasukan', value: totalIncome,        color: 'bg-green-50' },
                        { icon: '⏳', label: 'Pesanan Pending', value: String(totalPending), color: 'bg-amber-50' },
                        { icon: '❌', label: 'Pesanan Dibatalkan', value: String(totalCanceled), color: 'bg-red-50' },
                    ].map((s, i) => (
                        <div key={i} className="bg-white rounded-2xl p-5 border border-gray-100">
                            <div className={`w-11 h-11 rounded-xl flex items-center justify-center text-xl mb-3 ${s.color}`}>{s.icon}</div>
                            <div className="text-2xl font-bold text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>{s.value}</div>
                            <div className="text-xs text-gray-400 mt-1">{s.label}</div>
                        </div>
                    ))}
                </div>

                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div className="px-5 py-4 border-b border-gray-100 font-bold text-sm" style={{ fontFamily: "'Sora', sans-serif" }}>💳 Riwayat Transaksi</div>
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead>
                            <tr className="border-b border-gray-100 bg-gray-50">
                                {['ID', 'Pembeli', 'Total', 'Metode Bayar', 'Metode Kirim', 'Status'].map((h, i) => (
                                    <th key={i} className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
                                ))}
                            </tr>
                            </thead>
                            <tbody>
                            {transactions.length === 0 ? (
                                <tr><td colSpan={6} className="text-center py-10 text-gray-400">Belum ada transaksi</td></tr>
                            ) : transactions.map(txn => {
                                const st = TXN_STATUS_STYLES[txn.status] ?? { bg: 'bg-gray-100', text: 'text-gray-500', label: txn.status };
                                return (
                                    <tr key={txn.id} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                        <td className="px-5 py-3 font-mono text-xs font-semibold text-[#1a7c36]">#{txn.order_number}</td>
                                        <td className="px-5 py-3 font-semibold text-gray-900">{txn.buyer_name}</td>
                                        <td className="px-5 py-3 font-semibold text-[#1a7c36]">{txn.total_amount}</td>
                                        <td className="px-5 py-3 text-gray-400 capitalize">{txn.payment_method}</td>
                                        <td className="px-5 py-3 text-gray-400">{txn.shipping_method === 'pickup' ? '🏪 Ambil' : '🚚 Antar'}</td>
                                        <td className="px-5 py-3">
                                            <span className={`text-[11px] font-bold px-2.5 py-0.5 rounded-full ${st.bg} ${st.text}`}>{st.label}</span>
                                        </td>
                                    </tr>
                                );
                            })}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AdminLayout>
    );
}
