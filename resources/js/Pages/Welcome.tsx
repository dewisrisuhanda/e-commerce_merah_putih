import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';
import MainLayout from "@/Layouts/MainLayout";

// ─── Types ────────────────────────────────────────────────
interface Product {
    id: number;
    name: string;
    category: string;
    category_slug: string;
    price: string;
    production: string;
    image: string;
}

interface Props {
    auth: { user: { name: string; role: string } | null };
    bestProducts: Product[];
    totalProducts: number;
}

// ─── Static Data ──────────────────────────────────────────
const STATS = [
    { value: '100,1', label: 'km² Luas Wilayah' },
    { value: '11', label: 'Desa' },
    { value: '46,5rb', label: 'Penduduk (2025)' },
    { value: '489', label: 'jiwa/km² Kepadatan' },
];

const FACTS = [
    { label: 'Ibukota Kab.', value: 'Pangandaran' },
    { label: 'Provinsi', value: 'Jawa Barat' },
    { label: 'Jumlah RW / RT', value: '123 RW · 404 RT' },
    { label: 'Batas Selatan', value: 'Samudra Hindia' },
];

const VILLAGES = [
    { name: 'Karangjaladri', area: '3,549 km²', type: '🌊 Pesisir' },
    { name: 'Ciliang', area: '9,413 km²', type: '🌊 Pesisir' },
    { name: 'Cibenda', area: '7,593 km²', type: '🌊 Pesisir · Terpadat' },
    { name: 'Parigi', area: '3,327 km²', type: '🏛️ Ibukota Kec.' },
    { name: 'Selasari', area: '22,920 km²', type: '🏔️ Terluas' },
    { name: 'Cintaratu', area: '10,290 km²', type: '🌿 Bukan Pesisir' },
    { name: 'Cintakarya', area: '15,470 km²', type: '🌿 Bukan Pesisir' },
    { name: 'Parakanmanggu', area: '10,574 km²', type: '🌿 Bukan Pesisir' },
    { name: 'Karangbenda', area: '6,923 km²', type: '🌿 Bukan Pesisir' },
    { name: 'Bojong', area: '10,090 km²', type: '🌿 Bukan Pesisir' },
];

const FEATURES = [
    { icon: '🌊', title: 'Pesisir Samudra Hindia', desc: '3 desa berbatasan langsung dengan Samudra Hindia — Karangjaladri, Ciliang, Cibenda. Potensi wisata pantai dan perikanan tangkap yang besar.', badge: '3 Desa Pesisir' },
    { icon: '🌿', title: 'Kapulaga & Biofarmaka', desc: 'Kapulaga 94.740 kg, jahe 24.000 kg, kunyit 19.500 kg, kencur 12.000 kg per tahun. Salah satu sentra biofarmaka Jawa Barat.', badge: '94.740 kg/tahun' },
    { icon: '🍌', title: 'Buah Lokal Unggulan', desc: 'Pisang 2.640 kw, durian 1.083 kw, alpukat 751 kw per tahun. Tanaman buah tahunan jadi andalan warga desa pegunungan.', badge: 'Buah Andalan' },
    { icon: '🌶️', title: 'Sayuran & Hortikultura', desc: 'Tomat 557 kw, cabai rawit 264 kw, cabai besar 150 kw, bawang merah 106 kw diproduksi tiap tahun.', badge: 'Hortikultura Unggulan' },
    { icon: '🏫', title: 'Pendidikan Lengkap', desc: '35 SD, 6 SMP, 5 SMK, 1 SMA, 1 MA. Akses pendidikan TK hingga SMA sangat mudah di seluruh 11 desa.', badge: '48+ Sekolah' },
    { icon: '🛒', title: 'Perdagangan Aktif', desc: '2 pasar permanen, 6 minimarket, 5 rumah makan, 4 bank pemerintah, 4 koperasi simpan pinjam aktif.', badge: '6 Minimarket · 2 Pasar' },
];

const FILTER_TABS = [
    { label: '🛒 Semua', value: 'all' },
    { label: '🌿 Biofarmaka', value: 'biofarmaka' },
    { label: '🫚 Rempah', value: 'rempah' },
    { label: '🍌 Buah-buahan', value: 'buah-buahan' },
    { label: '🌶️ Sayuran', value: 'sayuran' },
];

// Fallback static products bila DB belum ada data
const STATIC_PRODUCTS: Product[] = [
    { id: 1, category_slug: 'biofarmaka', image: 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400&q=80', category: 'Biofarmaka', name: 'Kapulaga Segar', production: 'Prod. 94.740 kg/thn', price: 'Rp 45.000/kg' },
    { id: 2, category_slug: 'rempah', image: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&q=80', category: 'Rempah', name: 'Jahe Segar', production: 'Prod. 24.000 kg/thn', price: 'Rp 18.000/kg' },
    { id: 3, category_slug: 'rempah', image: 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&q=80', category: 'Rempah', name: 'Kunyit Segar', production: 'Prod. 19.500 kg/thn', price: 'Rp 12.000/kg' },
    { id: 4, category_slug: 'rempah', image: 'https://images.unsplash.com/photo-1599909313208-3f9c08b11af5?w=400&q=80', category: 'Rempah', name: 'Kencur', production: 'Prod. 12.000 kg/thn', price: 'Rp 20.000/kg' },
    { id: 5, category_slug: 'buah-buahan', image: 'https://images.unsplash.com/photo-1602201130723-9f78e41d70c5?w=400&q=80', category: 'Buah-buahan', name: 'Durian Lokal', production: 'Prod. 1.083 kw/thn', price: 'Rp 35.000/buah' },
    { id: 6, category_slug: 'buah-buahan', image: 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400&q=80', category: 'Buah-buahan', name: 'Pisang Lokal', production: 'Prod. 2.640 kw/thn', price: 'Rp 8.000/sisir' },
    { id: 7, category_slug: 'buah-buahan', image: 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&q=80', category: 'Buah-buahan', name: 'Alpukat', production: 'Prod. 751 kw/thn', price: 'Rp 15.000/buah' },
    { id: 8, category_slug: 'sayuran', image: 'https://images.unsplash.com/photo-1558818498-28c1e002b655?w=400&q=80', category: 'Sayuran', name: 'Tomat Segar', production: 'Prod. 557 kw/thn', price: 'Rp 8.000/kg' },
    { id: 9, category_slug: 'sayuran', image: 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', category: 'Sayuran', name: 'Cabai Rawit', production: 'Prod. 264 kw/thn', price: 'Rp 30.000/kg' },
    { id: 10, category_slug: 'sayuran', image: 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=400&q=80', category: 'Sayuran', name: 'Cabai Besar', production: 'Prod. 150 kw/thn', price: 'Rp 22.000/kg' },
    { id: 11, category_slug: 'sayuran', image: 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400&q=80', category: 'Sayuran', name: 'Bawang Merah', production: 'Prod. 106 kw/thn', price: 'Rp 25.000/kg' },
    { id: 12, category_slug: 'buah-buahan', image: 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', category: 'Buah-buahan', name: 'Pepaya', production: 'Prod. 14 kw/thn', price: 'Rp 6.000/kg' },
];

// ─── Component ────────────────────────────────────────────
export default function Welcome({ auth, bestProducts, totalProducts }: Props) {
    const [activeFilter, setActiveFilter] = useState('all');

    const productList = bestProducts?.length ? bestProducts : STATIC_PRODUCTS;
    const filteredProducts = activeFilter === 'all'
        ? productList
        : productList.filter(p => p.category_slug === activeFilter);

    return (
        <MainLayout>
            <Head title="Home" />

            <link
                href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
                rel="stylesheet"
            />

            <div style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* ══════════════════════════════════
                    HERO
                ══════════════════════════════════ */}
                <section className="relative flex min-h-screen items-center justify-center overflow-hidden -mt-16">
                    <div
                        className="absolute inset-0 animate-[slowZoom_18s_ease-in-out_infinite_alternate]"
                        style={{
                            background: "linear-gradient(160deg,rgba(26,58,42,0.78) 0%,rgba(45,106,79,0.5) 50%,rgba(26,58,42,0.72) 100%), url('https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=1600&q=80') center/cover no-repeat",
                        }}
                    />
                    <span className="absolute top-[90px] right-[60px] hidden sm:block bg-[#e9c46a] text-[#1a3a2a] text-[0.7rem] font-bold tracking-[0.12em] uppercase px-4 py-1.5 rounded-full animate-[fadeDown_0.8s_0.4s_both]">
                        ✦ Kec. Parigi, Kab. Pangandaran — Jawa Barat
                    </span>
                    <div className="relative z-10 text-center px-5 max-w-[820px]">
                        <p className="text-lg lg:mt-20 font-semibold tracking-[0.2em] uppercase text-[#74c69d] mb-4 animate-[fadeUp_0.7s_0.1s_both]">
                            Selamat Datang di
                        </p>
                        <h1
                            className="text-[clamp(2.6rem,7vw,5rem)] font-black leading-[1.08] text-white mb-5 animate-[fadeUp_0.7s_0.25s_both]"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Pesona <em className="not-italic text-[#e9c46a]">Alam & Produk</em>
                            <br />Kecamatan Parigi
                        </h1>
                        <p className="text-[1.02rem] leading-[1.72] text-white/80 max-w-[560px] mx-auto mb-9 animate-[fadeUp_0.7s_0.4s_both]">
                            Kecamatan di ujung selatan Kabupaten Pangandaran, berbatasan langsung dengan Samudra Hindia. Rumah bagi 46.500 jiwa dengan kekayaan alam, pertanian, dan budaya lokal yang khas.
                        </p>
                        <div className="flex gap-3.5 justify-center flex-wrap animate-[fadeUp_0.7s_0.55s_both]">
                            <a
                                href="#about"
                                className="bg-[#40916c] text-white px-8 py-3 rounded-full text-[0.92rem] font-semibold shadow-[0_8px_24px_rgba(64,145,108,0.4)] transition hover:bg-[#74c69d] hover:-translate-y-0.5 no-underline"
                            >
                                Kenali Parigi
                            </a>
                            <Link
                                href={route().has('products.index') ? route('products.index') : '#'}
                                className="border-2 border-white/50 text-white px-8 py-3 rounded-full text-[0.92rem] font-medium transition hover:border-[#74c69d] hover:text-[#74c69d] no-underline"
                            >
                                Lihat Produk Lokal
                            </Link>
                        </div>
                    </div>
                    <div className="absolute bottom-7 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-white/40 text-[0.7rem] tracking-[0.1em] uppercase">
                        <div className="w-px h-8 bg-gradient-to-b from-white/50 to-transparent animate-[scrollP_2s_infinite]" />
                        Scroll
                    </div>
                </section>

                {/* ══════════════════════════════════
                    STATS
                ══════════════════════════════════ */}
                <div className="bg-[#1a3a2a] grid grid-cols-2 md:grid-cols-4 border-b-[3px] border-[#40916c]">
                    {STATS.map((stat, i) => (
                        <div key={i} className="py-6 px-4 text-center border-r border-[#74c69d]/15 last:border-r-0">
                            <div
                                className="text-[1.9rem] font-black text-[#e9c46a] leading-none"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                {stat.value}
                            </div>
                            <div className="text-[0.75rem] text-white/50 mt-1 tracking-[0.05em]">{stat.label}</div>
                        </div>
                    ))}
                </div>

                {/* ══════════════════════════════════
                    ABOUT
                ══════════════════════════════════ */}
                <section id="about" className="py-20 px-6 md:px-16 bg-[#fefae0]">
                    <div className="max-w-[1200px] mx-auto grid md:grid-cols-2 gap-16 items-start">
                        <div>
                            <img
                                src="https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=800&q=80"
                                alt="Parigi"
                                className="w-full h-[360px] object-cover rounded-2xl shadow-[0_20px_56px_rgba(26,58,42,0.18)]"
                            />
                        </div>
                        <div>
                            <span className="inline-block text-[0.7rem] font-bold tracking-[0.16em] uppercase text-[#40916c] bg-[#40916c]/10 px-3.5 py-1 rounded-full mb-3">
                                Mengenal Daerah
                            </span>
                            <h2
                                className="text-[clamp(1.8rem,3.5vw,2.7rem)] font-black leading-[1.15] text-[#1a3a2a] mb-3"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                Kecamatan Parigi,<br />Gerbang Selatan Pangandaran
                            </h2>
                            <p className="text-[1rem] leading-[1.75] text-[#4a6258] max-w-[520px] mb-6">
                                Secara astronomis terletak antara 7°38'31.2" LS dan 108°30'39.6" BT. Berbatasan dengan Kec. Langkaplancar (Utara), Kec. Cijulang (Barat), Samudra Hindia (Selatan), dan Kec. Sidamulih (Timur). Jarak ke ibukota kabupaten hanya 0,2 km.
                            </p>
                            <div className="grid grid-cols-2 gap-3">
                                {FACTS.map((fact, i) => (
                                    <div key={i} className="bg-white rounded-r-xl px-4 py-4 border-l-[3px] border-[#40916c] shadow-[0_3px_12px_rgba(26,58,42,0.07)]">
                                        <h4 className="text-[0.68rem] font-bold tracking-[0.08em] uppercase text-[#40916c] mb-1">{fact.label}</h4>
                                        <p className="text-[0.9rem] font-semibold text-[#1a3a2a] m-0">{fact.value}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>

                {/* ══════════════════════════════════
                    MAP
                ══════════════════════════════════ */}
                <section id="map" className="py-20 px-6 md:px-16 bg-[#f4faf6]">
                    <div className="max-w-[1200px] mx-auto">
                        <div className="text-center mb-11">
                            <span className="inline-block text-[0.7rem] font-bold tracking-[0.16em] uppercase text-[#40916c] bg-[#40916c]/10 px-3.5 py-1 rounded-full mb-3">
                                Peta Wilayah
                            </span>
                            <h2
                                className="text-[clamp(1.8rem,3.5vw,2.7rem)] font-black leading-[1.15] text-[#1a3a2a] mb-3"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                11 Desa di Kecamatan Parigi
                            </h2>
                            <p className="text-[1rem] text-[#4a6258] max-w-[520px] mx-auto">
                                Total luas 100,149 km². Desa Selasari terluas (22,92 km²), Desa Cibenda terpadat.
                            </p>
                        </div>
                        <div className="grid md:grid-cols-2 gap-11 items-start">
                            <div className="relative rounded-2xl overflow-hidden shadow-[0_16px_48px_rgba(26,58,42,0.15)]">
                                <span className="absolute top-3.5 left-3.5 z-10 bg-[#1a3a2a]/90 text-[#74c69d] text-[0.68rem] font-bold tracking-[0.1em] uppercase px-3 py-1 rounded-full">
                                    📍 Kec. Parigi, Pangandaran
                                </span>
                                <iframe
                                    src="https://www.openstreetmap.org/export/embed.html?bbox=108.4200%2C-7.7200%2C108.6000%2C-7.5800&layer=mapnik&marker=-7.6500%2C108.4900"
                                    className="w-full h-[400px] border-0 block"
                                    allowFullScreen
                                    loading="lazy"
                                />
                            </div>
                            <div className="grid grid-cols-2 gap-2.5">
                                {VILLAGES.map((village, i) => (
                                    <div key={i} className="bg-white rounded-xl px-4 py-3 border-t-2 border-[#40916c] shadow-[0_2px_8px_rgba(26,58,42,0.07)]">
                                        <div className="text-[0.9rem] font-bold text-[#1a3a2a] mb-0.5">{village.name}</div>
                                        <div className="text-[0.75rem] text-[#5a7060]">{village.area}</div>
                                        <div className="text-[0.68rem] font-bold tracking-[0.06em] uppercase text-[#40916c] mt-1">{village.type}</div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>

                {/* ══════════════════════════════════
                    FEATURES
                ══════════════════════════════════ */}
                <section id="features" className="py-20 px-6 md:px-16 bg-[#1a3a2a]">
                    <div className="text-center max-w-[580px] mx-auto mb-14">
                        <span className="inline-block text-[0.7rem] font-bold tracking-[0.16em] uppercase text-[#74c69d] bg-[#74c69d]/15 px-3.5 py-1 rounded-full mb-3">
                            Ciri Khas Daerah
                        </span>
                        <h2
                            className="text-[clamp(1.8rem,3.5vw,2.7rem)] font-black leading-[1.15] text-white mb-3"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Yang Membuat Parigi Unik
                        </h2>
                        <p className="text-[1rem] text-white/55">Sumber: BPS Kecamatan Parigi Dalam Angka 2025</p>
                    </div>
                    <div className="grid md:grid-cols-3 gap-5 max-w-[1200px] mx-auto">
                        {FEATURES.map((feature, i) => (
                            <div
                                key={i}
                                className="bg-white/[0.055] border border-[#74c69d]/18 border-t-[3px] border-t-[#40916c] rounded-2xl p-8 transition hover:bg-white/[0.09] hover:-translate-y-1"
                            >
                                <span className="text-[2rem] mb-4 block">{feature.icon}</span>
                                <h3
                                    className="text-[1.15rem] text-white mb-2"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    {feature.title}
                                </h3>
                                <p className="text-[0.87rem] leading-[1.7] text-white/55">{feature.desc}</p>
                                <span className="inline-block mt-3 bg-[#74c69d]/15 text-[#74c69d] text-[0.7rem] font-bold tracking-[0.08em] px-2.5 py-1 rounded-full">
                                    {feature.badge}
                                </span>
                            </div>
                        ))}
                    </div>
                </section>

                {/* ══════════════════════════════════
                    PRODUCTS
                ══════════════════════════════════ */}
                <section id="products" className="py-20 px-6 md:px-16 bg-[#fefae0]">
                    <div className="max-w-[1200px] mx-auto">
                        <div className="flex items-end justify-between flex-wrap gap-4 mb-8">
                            <div>
                                <span className="inline-block text-[0.7rem] font-bold tracking-[0.16em] uppercase text-[#40916c] bg-[#40916c]/10 px-3.5 py-1 rounded-full mb-3">
                                    Marketplace Lokal
                                </span>
                                <h2
                                    className="text-[clamp(1.8rem,3.5vw,2.7rem)] font-black leading-[1.15] text-[#1a3a2a] mb-2"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    Produk Unggulan Parigi
                                </h2>
                                <p className="text-[1rem] text-[#4a6258]">
                                    Komoditas unggulan dari petani lokal Parigi - data produksi BPS 2024.
                                </p>
                            </div>
                            <Link
                                href={route().has('products.index') ? route('products.index') : '#'}
                                className="bg-[#40916c] text-white px-8 py-3 rounded-full text-[0.92rem] font-semibold shadow-[0_8px_24px_rgba(64,145,108,0.4)] transition hover:bg-[#74c69d] hover:-translate-y-0.5 whitespace-nowrap no-underline"
                            >
                                Semua Produk →
                            </Link>
                        </div>

                        {/* Filter tabs */}
                        <div className="flex gap-2 flex-wrap mb-9">
                            {FILTER_TABS.map(tab => (
                                <button
                                    key={tab.value}
                                    onClick={() => setActiveFilter(tab.value)}
                                    className={`text-[0.78rem] font-semibold px-4 py-1.5 rounded-full border-[1.5px] transition cursor-pointer
                                        ${activeFilter === tab.value
                                            ? 'bg-[#40916c] text-white border-[#40916c]'
                                            : 'bg-transparent text-[#2d6a4f] border-[#40916c]/30 hover:bg-[#40916c] hover:text-white hover:border-[#40916c]'
                                        }`}
                                >
                                    {tab.label}
                                </button>
                            ))}
                        </div>

                        {/* Product grid */}
                        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                            {filteredProducts.map((product, i) => (
                                <div
                                    key={i}
                                    className="bg-white rounded-2xl overflow-hidden shadow-[0_4px_16px_rgba(26,58,42,0.08)] transition hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(26,58,42,0.14)]"
                                >
                                    <img
                                        src={product.image}
                                        alt={product.name}
                                        className="w-full h-[170px] object-cover"
                                        onError={(e) => {
                                            (e.target as HTMLImageElement).src =
                                                `https://placehold.co/400x300/e8f5e9/2e7d32?text=${encodeURIComponent(product.name)}`;
                                        }}
                                    />
                                    <div className="p-4">
                                        <div className="text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#40916c] mb-1">
                                            {product.category}
                                        </div>
                                        <div className="text-[0.92rem] font-bold text-[#1a3a2a] mb-1">{product.name}</div>
                                        {product.production && (
                                            <div className="text-[0.75rem] text-[#5a7060] mb-1.5">{product.production}</div>
                                        )}
                                        <div
                                            className="text-[1.05rem] font-bold text-[#2d6a4f]"
                                            style={{ fontFamily: "'Playfair Display', serif" }}
                                        >
                                            {product.price}
                                        </div>
                                        <Link
                                            href={route().has('products.index') ? `${route('products.index')}?category=${encodeURIComponent(product.category)}` : '#'}
                                            className="block text-center mt-3 bg-[#d8f3dc] text-[#1a3a2a] py-2 rounded-lg text-[0.82rem] font-semibold transition hover:bg-[#40916c] hover:text-white no-underline"
                                        >
                                            Cari di Marketplace
                                        </Link>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* ══════════════════════════════════
                    CTA
                ══════════════════════════════════ */}
                <section
                    className="relative py-20 px-6 md:px-16 text-center overflow-hidden"
                    style={{ background: 'linear-gradient(135deg,#1a3a2a 0%,#2d6a4f 60%,#40916c 100%)' }}
                >
                    <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_70%_50%,rgba(233,196,106,0.12),transparent_60%)]" />
                    <h2
                        className="relative text-[clamp(1.9rem,5vw,3.2rem)] font-black text-white mb-3"
                        style={{ fontFamily: "'Playfair Display', serif" }}
                    >
                        Dukung Produk Lokal Parigi,<br />Bangkitkan Ekonomi Daerah
                    </h2>
                    <p className="relative text-[1rem] text-white/70 max-w-[480px] mx-auto mb-9 leading-[1.72]">
                        Bergabunglah dan dukung UMKM serta petani lokal Kecamatan Parigi, Pangandaran.
                    </p>
                    <Link
                        href={route().has('products.index') ? route('products.index') : '#'}
                        className="relative inline-block bg-[#e9c46a] text-[#1a3a2a] px-9 py-3.5 rounded-full text-[0.93rem] font-bold shadow-[0_8px_28px_rgba(233,196,106,0.4)] transition hover:bg-[#f0d080] hover:-translate-y-1 no-underline"
                    >
                        Mulai Belanja Sekarang →
                    </Link>
                </section>

                {/* ══════════════════════════════════
                    SITE FOOTER (bukan MainLayout footer)
                ══════════════════════════════════ */}
                <footer className="bg-[#0f2318] px-6 md:px-16 pt-14 pb-6">
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-[#74c69d]/12">
                        <div>
                            <span
                                className="text-[1.2rem] font-black text-[#d8f3dc]"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                🌿 Parigi<span className="text-[#e9c46a]">Market</span>
                            </span>
                            <p className="text-[0.86rem] leading-[1.7] text-white/40 mt-2.5 max-w-[240px]">
                                Platform marketplace digital produk lokal Kecamatan Parigi, Kabupaten Pangandaran, Jawa Barat.
                            </p>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Navigasi</h4>
                            <ul className="space-y-1.5 list-none p-0 m-0">
                                {[
                                    { href: '#about', label: 'Tentang Parigi' },
                                    { href: '#map', label: 'Peta Wilayah' },
                                    { href: '#features', label: 'Ciri Khas' },
                                    { href: '#products', label: 'Produk Lokal' },
                                ].map((item, i) => (
                                    <li key={i}>
                                        <a href={item.href} className="text-[0.84rem] text-white/40 transition hover:text-[#74c69d] no-underline">
                                            {item.label}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Marketplace</h4>
                            <ul className="space-y-1.5 list-none p-0 m-0">
                                <li><Link href={route().has('products.index') ? route('products.index') : '#'} className="text-[0.84rem] text-white/40 transition hover:text-[#74c69d] no-underline">Semua Produk</Link></li>
                                <li><Link href={route().has('register') ? route('register') : '#'} className="text-[0.84rem] text-white/40 transition hover:text-[#74c69d] no-underline">Daftar Penjual</Link></li>
                                <li><Link href={route().has('login') ? route('login') : '#'} className="text-[0.84rem] text-white/40 transition hover:text-[#74c69d] no-underline">Masuk</Link></li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Kontak</h4>
                            <ul className="space-y-1.5 list-none p-0 m-0">
                                <li><span className="text-[0.84rem] text-white/40">Parigi, Pangandaran — Jabar</span></li>
                                <li><a href="mailto:info@parigimarket.id" className="text-[0.84rem] text-white/40 transition hover:text-[#74c69d] no-underline">info@parigimarket.id</a></li>
                            </ul>
                        </div>
                    </div>
                    <div className="flex justify-between items-center pt-5 flex-wrap gap-2">
                        <p className="text-[0.78rem] text-white/25 m-0">© {new Date().getFullYear()} Parigi Market. Hak cipta dilindungi.</p>
                        <p className="text-[0.78rem] text-white/25 m-0">Data: BPS Kecamatan Parigi Dalam Angka 2025</p>
                    </div>
                </footer>
            </div>

            <style>{`
                @keyframes slowZoom {
                    from { transform: scale(1.04); }
                    to   { transform: scale(1.12); }
                }
                @keyframes fadeUp {
                    from { opacity: 0; transform: translateY(24px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                @keyframes fadeDown {
                    from { opacity: 0; transform: translateY(-14px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                @keyframes scrollP {
                    0%, 100% { opacity: .4; }
                    50%      { opacity: 1; }
                }
            `}</style>
        </MainLayout>
    );
}
