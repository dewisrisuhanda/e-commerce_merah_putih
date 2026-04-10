import { Head, Link, router } from '@inertiajs/react';
import { useState } from 'react';
import MainLayout from '@/Layouts/MainLayout';

// ─── Types ────────────────────────────────────────────────
interface Product {
    id: number;
    name: string;
    category: string;
    price: string;
    quantity: number;
    image: string | null;
    slug: string;
}

interface Category {
    id: number;
    name: string;
    slug: string;
}

interface PaginationLink {
    url: string | null;
    label: string;
    active: boolean;
}

interface Paginator {
    data: Product[];
    links: PaginationLink[];
    total: number;
    current_page: number;
    last_page: number;
}

interface Props {
    products: Paginator;
    categories: Category[];
    filters: {
        search: string;
        category: string;
    };
}

// ─── BPS Komoditas Data ───────────────────────────────────
const KOMODITAS = [
    { icon: '🌿', name: 'Kapulaga', prod: '94.740 kg' },
    { icon: '🫚', name: 'Jahe', prod: '24.000 kg' },
    { icon: '🟡', name: 'Kunyit', prod: '19.500 kg' },
    { icon: '🍌', name: 'Pisang', prod: '2.640 kw' },
    { icon: '🍈', name: 'Durian', prod: '1.083 kw' },
    { icon: '🍅', name: 'Tomat', prod: '557 kw' },
    { icon: '🌶️', name: 'Cabai Rawit', prod: '264 kw' },
    { icon: '🧅', name: 'Bawang Merah', prod: '106 kw' },
    { icon: '🥑', name: 'Alpukat', prod: '751 kw' },
    { icon: '🌶️', name: 'Cabai Besar', prod: '150 kw' },
    { icon: '🌱', name: 'Kencur', prod: '12.000 kg' },
    { icon: '🫚', name: 'Lengkuas', prod: '21.000 kg' },
];

const CATEGORY_ICONS: Record<string, string> = {
    'Semua': '🛒',
    'Hasil Tani': '🌾',
    'Hasil Laut': '🐟',
    'Oleh-oleh': '🎁',
    'Buah-buahan': '🍌',
    'Rempah': '🌿',
    'Biofarmaka': '🌱',
    'Produk Olahan': '🏭',
    'Sayuran': '🌶️',
    'Kerajinan': '🎨',
};

// ─── Component ────────────────────────────────────────────
export default function Index({ products, categories, filters }: Props) {
    const [search, setSearch] = useState(filters.search ?? '');

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        router.get(route().has('products.index') ? route('products.index') : '#', {
            search,
            category: filters.category,
        }, { preserveState: true, preserveScroll: true });
    };

    const handleCategoryFilter = (categoryName: string) => {
        router.get(route().has('products.index') ? route('products.index') : '#', {
            search: filters.search,
            category: categoryName === 'Semua' ? '' : categoryName,
        }, { preserveState: true, preserveScroll: true });
    };

    const activeCategory = filters.category || 'Semua';

    return (
        <MainLayout keyword={filters.search}>
            <Head title="Produk" />

            <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />

            <div className="min-h-screen bg-[#f8faf8] px-4 md:px-8 py-6" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* ── Header Banner ── */}
                <div
                    className="rounded-2xl p-6 md:p-8 mb-6 text-white"
                    style={{ background: 'linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%)' }}
                >
                    <div className="flex items-start justify-between flex-wrap gap-3">
                        <div>
                            <p className="text-[0.7rem] font-bold tracking-[0.14em] uppercase text-white/55 mb-1.5">
                                🌿 Marketplace Lokal
                            </p>
                            <h4
                                className="text-2xl font-black mb-1"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                {filters.search ? (
                                    <>Hasil: <em className="not-italic text-[#e9c46a]">"{filters.search}"</em></>
                                ) : filters.category ? (
                                    <>Kategori: <em className="not-italic text-[#e9c46a]">{filters.category}</em></>
                                ) : (
                                    'Semua Produk Parigi'
                                )}
                            </h4>
                            <p className="text-white/70 text-[0.9rem] m-0">
                                {products.total} produk dari petani & pengrajin lokal Kec. Parigi, Pangandaran
                            </p>
                        </div>
                        <Link
                            href="/"
                            className="text-white/80 text-sm border border-white/25 px-4 py-1.5 rounded-full no-underline transition hover:border-white/60 hover:text-white whitespace-nowrap self-start"
                        >
                            ← Beranda
                        </Link>
                    </div>
                </div>

                {/* ── BPS Komoditas Strip ── */}
                <div className="bg-[#1a3a2a] rounded-xl p-4 md:p-5 mb-5">
                    <p className="text-[0.68rem] font-bold tracking-[0.1em] uppercase text-white/50 mb-3">
                        📊 Data Produksi BPS Kec. Parigi 2024
                    </p>
                    <div className="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2">
                        {KOMODITAS.map((k, i) => (
                            <div key={i} className="bg-white/7 rounded-lg p-2.5 text-center" style={{ background: 'rgba(255,255,255,0.07)' }}>
                                <div className="text-lg mb-1">{k.icon}</div>
                                <div className="text-[0.75rem] font-bold text-white mb-0.5">{k.name}</div>
                                <div className="text-[0.65rem] text-white/55">{k.prod}/thn</div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* ── Search + Filter ── */}
                <div className="flex flex-col md:flex-row gap-3 mb-6 items-start md:items-center">
                    {/* Search */}
                    <form onSubmit={handleSearch} className="relative w-full md:max-w-sm">
                        <span className="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                        <input
                            type="text"
                            value={search}
                            onChange={e => setSearch(e.target.value)}
                            placeholder="Cari produk Parigi..."
                            className="w-full pl-10 pr-4 py-2.5 rounded-full border border-[#40916c]/35 bg-white text-sm outline-none transition focus:border-[#40916c] focus:ring-2 focus:ring-[#40916c]/15"
                        />
                    </form>

                    {/* Category Tabs */}
                    <div className="flex gap-2 flex-wrap">
                        <button
                            onClick={() => handleCategoryFilter('Semua')}
                            className={`text-[0.8rem] font-semibold px-4 py-1.5 rounded-full border-[1.5px] transition cursor-pointer ${activeCategory === 'Semua' ? 'bg-[#40916c] text-white border-[#40916c]' : 'bg-white text-[#2d6a4f] border-[#40916c]/30 hover:bg-[#40916c] hover:text-white hover:border-[#40916c]'}`}
                        >
                            🛒 Semua
                        </button>
                        {categories.map(cat => (
                            <button
                                key={cat.id}
                                onClick={() => handleCategoryFilter(cat.name)}
                                className={`text-[0.8rem] font-semibold px-4 py-1.5 rounded-full border-[1.5px] transition cursor-pointer ${activeCategory === cat.name ? 'bg-[#40916c] text-white border-[#40916c]' : 'bg-white text-[#2d6a4f] border-[#40916c]/30 hover:bg-[#40916c] hover:text-white hover:border-[#40916c]'}`}
                            >
                                {CATEGORY_ICONS[cat.name] ?? '📦'} {cat.name}
                            </button>
                        ))}
                    </div>
                </div>

                {/* ── Product Grid ── */}
                {products.data.length === 0 ? (
                    <div className="text-center py-20 text-gray-400">
                        <div className="text-5xl mb-4">📭</div>
                        <h6 className="font-semibold text-gray-600 mb-1">Produk tidak ditemukan</h6>
                        <p className="text-sm mb-4">Coba kategori lain atau hapus kata kunci pencarian.</p>
                        <button
                            onClick={() => handleCategoryFilter('Semua')}
                            className="bg-white border border-[#40916c]/40 text-[#40916c] text-sm font-semibold px-5 py-2 rounded-full transition hover:bg-[#40916c] hover:text-white cursor-pointer"
                        >
                            Lihat Semua Produk
                        </button>
                    </div>
                ) : (
                    <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                        {products.data.map(product => (
                            <div
                                key={product.id}
                                className="bg-white rounded-2xl overflow-hidden shadow-[0_4px_16px_rgba(26,58,42,0.08)] transition hover:-translate-y-1 hover:shadow-[0_12px_32px_rgba(26,58,42,0.15)]"
                            >
                                {/* Image */}
                                <div className="relative h-44 bg-[#f4faf6] overflow-hidden">
                                    {product.image ? (
                                        <img
                                            src={product.image}
                                            alt={product.name}
                                            className="w-full h-full object-cover"
                                            onError={(e) => {
                                                (e.target as HTMLImageElement).src =
                                                    `https://placehold.co/400x300/e8f5e9/2e7d32?text=${encodeURIComponent(product.name)}`;
                                            }}
                                        />
                                    ) : (
                                        <div className="w-full h-full flex items-center justify-center text-gray-300 text-4xl">🖼️</div>
                                    )}
                                </div>

                                {/* Body */}
                                <div className="p-3">
                                    {product.category && (
                                        <span className="inline-block text-[0.65rem] font-bold tracking-[0.08em] uppercase text-[#40916c] bg-[#40916c]/10 px-2 py-0.5 rounded-full mb-1.5">
                                            {product.category}
                                        </span>
                                    )}
                                    <p className="font-semibold text-[#1a3a2a] text-[0.9rem] mb-1 leading-snug line-clamp-2">{product.name}</p>
                                    <p
                                        className="font-bold text-[#2d6a4f] text-[1rem] mb-1"
                                        style={{ fontFamily: "'Playfair Display', serif" }}
                                    >
                                        {product.price}
                                    </p>
                                    <p className="text-gray-400 text-[0.75rem] mb-3">Stok: {product.quantity}</p>
                                    <Link
                                        href={route().has('products.show') ? route('products.show', product.slug) : '#'}
                                        className="block text-center bg-[#d8f3dc] text-[#1a3a2a] text-[0.8rem] font-semibold py-2 rounded-lg no-underline transition hover:bg-[#40916c] hover:text-white"
                                    >
                                        Lihat Detail
                                    </Link>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                {/* ── Pagination ── */}
                {products.last_page > 1 && (
                    <div className="flex justify-center gap-2 mt-8 flex-wrap">
                        {products.links.map((link, i) => (
                            link.url ? (
                                <Link
                                    key={i}
                                    href={link.url}
                                    preserveState
                                    preserveScroll
                                    className={`px-3.5 py-1.5 rounded-lg text-sm font-medium transition border
                                                ${link.active ? 'bg-[#40916c] text-white border-[#40916c]'
                                                : 'bg-white text-[#2d6a4f] border-[#40916c]/30 hover:bg-[#40916c]/10'}`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ) : (
                                <span
                                    key={i}
                                    className="px-3.5 py-1.5 rounded-lg text-sm font-medium border bg-gray-50 text-gray-300 border-gray-100"
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            )
                        ))}
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
