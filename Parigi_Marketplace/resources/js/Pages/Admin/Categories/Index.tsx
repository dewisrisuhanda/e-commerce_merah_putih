import { Head, Link, router } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface CategoryStat {
    id: number;
    name: string;
    slug: string;
    product_count: number;
}

interface Props {
    categories: CategoryStat[];
}

const CAT_BG: Record<string, string> = {
    'Hasil Tani':    '#edfff3',
    'Hasil Laut':    '#f0fdfa',
    'Oleh-oleh':     '#fefce8',
    'Buah-buahan':   '#fff7ed',
    'Rempah':        '#fef2f2',
    'Produk Olahan': '#f8fafc',
    'Biofarmaka':    '#f0fdf4',
    'Sayuran':       '#f0fdf4',
    'Kerajinan':     '#faf5ff',
};

const CAT_ICON: Record<string, string> = {
    'Hasil Tani':    '🌾',
    'Hasil Laut':    '🐟',
    'Oleh-oleh':     '🎁',
    'Buah-buahan':   '🍈',
    'Rempah':        '🌶️',
    'Produk Olahan': '🏭',
    'Biofarmaka':    '🌱',
    'Sayuran':       '🥬',
    'Kerajinan':     '🎨',
};

export default function Index({ categories }: Props) {
    const r = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const handleDelete = (id: number, name: string) => {
        if (!confirm(`Hapus kategori "${name}"? Produk di kategori ini tidak akan terhapus.`)) return;
        router.delete(r('admin.categories.destroy', id));
    };

    return (
        <AdminLayout title="Kelola Kategori" breadcrumb="Admin → Kelola → Kategori" activeMenu="categories">
            <Head title="Kelola Kategori" />

            {/* Header */}
            <div className="flex items-center justify-between mb-5">
                <div>
                    <h2 className="font-bold text-base text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                        🏷️ Semua Kategori
                    </h2>
                    <p className="text-xs text-gray-400 mt-0.5">{categories.length} kategori tersedia</p>
                </div>
                <Link
                    href={r('admin.categories.create')}
                    className="flex items-center gap-1.5 bg-[#22a046] text-white text-xs font-semibold px-3.5 py-2 rounded-lg no-underline transition hover:bg-[#1a7c36]"
                >
                    + Tambah Kategori
                </Link>
            </div>

            {/* Grid */}
            {categories.length === 0 ? (
                <div className="text-center py-16 text-gray-400 bg-white rounded-2xl border border-gray-100">
                    <div className="text-5xl mb-3">🏷️</div>
                    <p>Belum ada kategori</p>
                    <Link href={r('admin.categories.create')} className="inline-block mt-4 text-xs text-[#22a046] border border-[#22a046]/30 px-4 py-2 rounded-lg no-underline hover:bg-[#22a046] hover:text-white transition">
                        + Tambah Kategori Pertama
                    </Link>
                </div>
            ) : (
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    {categories.map(cat => (
                        <div
                            key={cat.id}
                            className="rounded-2xl border border-gray-100 p-5 flex items-center gap-4 group relative"
                            style={{ background: CAT_BG[cat.name] ?? '#f9fafb' }}
                        >
                            {/* Icon */}
                            <span className="text-4xl flex-shrink-0">
                                {CAT_ICON[cat.name] ?? '📦'}
                            </span>

                            {/* Info */}
                            <div className="flex-1 min-w-0">
                                <div
                                    className="font-bold text-[15px] text-gray-900 truncate"
                                    style={{ fontFamily: "'Sora', sans-serif" }}
                                >
                                    {cat.name}
                                </div>
                                <div className="text-xs text-gray-500 mt-0.5">
                                    {cat.product_count} produk
                                </div>
                                <div className="text-[10px] text-gray-400 mt-0.5 font-mono">
                                    /{cat.slug}
                                </div>
                            </div>

                            {/* Count */}
                            <div
                                className="text-3xl font-black text-[#22a046] flex-shrink-0"
                                style={{ fontFamily: "'Sora', sans-serif" }}
                            >
                                {cat.product_count}
                            </div>

                            {/* Actions — muncul saat hover */}
                            <div className="absolute top-3 right-3 flex gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                <Link
                                    href={r('admin.categories.edit', cat.id)}
                                    className="w-7 h-7 flex items-center justify-center bg-white/80 rounded-lg text-blue-600 border border-blue-100 no-underline hover:bg-blue-50 transition text-xs"
                                    title="Edit"
                                >
                                    ✏️
                                </Link>
                                <button
                                    onClick={() => handleDelete(cat.id, cat.name)}
                                    className="w-7 h-7 flex items-center justify-center bg-white/80 rounded-lg text-red-500 border border-red-100 cursor-pointer hover:bg-red-50 transition text-xs"
                                    title="Hapus"
                                >
                                    🗑️
                                </button>
                            </div>
                        </div>
                    ))}
                </div>
            )}
        </AdminLayout>
    );
}
