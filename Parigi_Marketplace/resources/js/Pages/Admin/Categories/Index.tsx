import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface CategoryStat {
    id: number;
    name: string;
    slug: string;
    product_count: number;
}

interface CatProps { categories: CategoryStat[]; }

const CAT_BG: Record<string, string> = {
    'Hasil Tani': '#edfff3', 'Hasil Laut': '#f0fdfa', 'Oleh-oleh': '#fefce8',
    'Buah-buahan': '#fff7ed', 'Rempah': '#fef2f2', 'Produk Olahan': '#f8fafc',
    'Biofarmaka': '#f0fdf4', 'Sayuran': '#f0fdf4', 'Kerajinan': '#faf5ff',
};
const CAT_ICON: Record<string, string> = {
    'Hasil Tani': '🌾', 'Hasil Laut': '🐟', 'Oleh-oleh': '🎁',
    'Buah-buahan': '🍈', 'Rempah': '🌶️', 'Produk Olahan': '🏭',
    'Biofarmaka': '🌱', 'Sayuran': '🥬', 'Kerajinan': '🎨',
};

export default function Index({ categories }: CatProps) {
    return (
        <AdminLayout title="Kelola Kategori" breadcrumb="Admin → Kelola → Kategori" activeMenu="categories">
            <Head title="Kelola Kategori — Admin" />

            <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
                {categories.map(cat => (
                    <div
                        key={cat.id}
                        className="rounded-2xl border border-gray-100 p-6 flex items-center gap-4"
                        style={{ background: CAT_BG[cat.name] ?? '#f9fafb' }}
                    >
                        <span className="text-4xl flex-shrink-0">{CAT_ICON[cat.name] ?? '📦'}</span>
                        <div className="flex-1 min-w-0">
                            <div className="font-bold text-[15px] text-gray-900 truncate" style={{ fontFamily: "'Sora', sans-serif" }}>
                                {cat.name}
                            </div>
                            <div className="text-xs text-gray-500 mt-0.5">{cat.product_count} produk</div>
                        </div>
                        <div className="text-3xl font-black text-[#22a046] flex-shrink-0" style={{ fontFamily: "'Sora', sans-serif" }}>
                            {cat.product_count}
                        </div>
                    </div>
                ))}
            </div>
        </AdminLayout>
    );
}
