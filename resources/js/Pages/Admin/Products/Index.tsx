import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface Product {
    id: number;
    slug: string;
    name: string;
    category: string;
    price: string;
    quantity: number;
    image: string | null;
    status: string;
}

interface Props {
    products: Product[];
}

export default function Index({ products }: Props) {
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const handleDelete = (slug: string, name: string) => {
        if (!confirm(`Hapus produk "${name}"?`)) return;
        router.delete(render('admin.products.destroy', slug));
    };

    return (
        <AdminLayout title="Kelola Produk" breadcrumb="Admin → Produk" activeMenu="products">
            <Head title="Kelola Produk" />
            <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                        📦 Daftar Produk
                    </div>
                    <Link
                        href={render('admin.products.create')}
                        className="flex items-center gap-1.5 bg-[#22a046] text-white text-xs font-semibold px-3.5 py-2 rounded-lg no-underline transition hover:bg-[#1a7c36]"
                    >
                        + Tambah Produk
                    </Link>
                </div>

                {products.length === 0 ? (
                    <div className="text-center py-16 text-gray-400">
                        <div className="text-5xl mb-3">📭</div>
                        <p>Belum ada produk</p>
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="w-full text-sm">
                            <thead>
                            <tr className="border-b border-gray-100 bg-gray-50">
                                <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Foto</th>
                                <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Produk</th>
                                <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Harga</th>
                                <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Stok</th>
                                <th className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                                <th className="px-5 py-3"></th>
                            </tr>
                            </thead>
                            <tbody>
                            {products.map(p => (
                                <tr key={p.id} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td className="px-5 py-3">
                                        {p.image ? (
                                            <img src={p.image} alt={p.name} className="w-12 h-12 rounded-lg object-cover" />
                                        ) : (
                                            <div className="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-xl">📦</div>
                                        )}
                                    </td>
                                    <td className="px-5 py-3">
                                        <div className="font-semibold text-gray-900">{p.name}</div>
                                        <div className="text-xs text-gray-400">{p.category}</div>
                                    </td>
                                    <td className="px-5 py-3 font-semibold text-[#1a7c36]">{p.price}</td>
                                    <td className={`px-5 py-3 font-semibold ${p.quantity < 20 ? 'text-red-500' : 'text-gray-600'}`}>{p.quantity}</td>
                                    <td className="px-5 py-3">
                                            <span className={`text-[11px] font-bold px-2.5 py-0.5 rounded-full ${p.status === 'ready' ? 'bg-green-100 text-green-700' : p.status === 'out_of_stock' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-500'}`}>
                                                {p.status === 'ready' ? 'Aktif' : p.status === 'out_of_stock' ? 'Habis' : 'Nonaktif'}
                                            </span>
                                    </td>
                                    <td className="px-5 py-3">
                                        <div className="flex gap-2">
                                            <Link href={render('admin.products.edit', p.slug)} className="text-xs font-semibold text-blue-600 border border-blue-200 px-2.5 py-1 rounded-lg no-underline hover:bg-blue-50 transition">Edit</Link>
                                            <button onClick={() => handleDelete(p.slug, p.name)} className="text-xs font-semibold text-red-500 border border-red-200 px-2.5 py-1 rounded-lg bg-transparent cursor-pointer hover:bg-red-50 transition">Hapus</button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </AdminLayout>
    );
}
