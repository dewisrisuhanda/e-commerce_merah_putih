import { Head, Link } from '@inertiajs/react';
import { useState } from 'react';

// ─── Types ────────────────────────────────────────────────
interface productItem {
    id: number;
    nama: string;
    kategori: string;
    harga: string;
    produksi: string;
    foto: string;
    slug_kategori: string;
}

interface Props {
    auth: { user: { name: string } | null };
    bestProducts: productItem[];
    totalProduct: number;
}

// ─── Static Data (tidak perlu dari DB) ───────────────────
const STATS = [
    { n: '100,1', l: 'km² Luas Wilayah' },
    { n: '11', l: 'Desa' },
    { n: '46,5rb', l: 'Penduduk (2025)' },
    { n: '489', l: 'jiwa/km² Kepadatan' },
];

const FACTS = [
    { label: 'Ibukota Kab.', value: 'Pangandaran' },
    { label: 'Provinsi', value: 'Jawa Barat' },
    { label: 'Jumlah RW / RT', value: '123 RW · 404 RT' },
    { label: 'Batas Selatan', value: 'Samudra Hindia' },
];

const DESA = [
    { nama: 'Karangjaladri', luas: '3,549 km²', tipe: '🌊 Pesisir' },
    { nama: 'Ciliang', luas: '9,413 km²', tipe: '🌊 Pesisir' },
    { nama: 'Cibenda', luas: '7,593 km²', tipe: '🌊 Pesisir · Terpadat' },
    { nama: 'Parigi', luas: '3,327 km²', tipe: '🏛️ Ibukota Kec.' },
    { nama: 'Selasari', luas: '22,920 km²', tipe: '🏔️ Terluas' },
    { nama: 'Cintaratu', luas: '10,290 km²', tipe: '🌿 Bukan Pesisir' },
    { nama: 'Cintakarya', luas: '15,470 km²', tipe: '🌿 Bukan Pesisir' },
    { nama: 'Parakanmanggu', luas: '10,574 km²', tipe: '🌿 Bukan Pesisir' },
    { nama: 'Karangbenda', luas: '6,923 km²', tipe: '🌿 Bukan Pesisir' },
    { nama: 'Bojong', luas: '10,090 km²', tipe: '🌿 Bukan Pesisir' },
];

const CIRI = [
    { icon: '🌊', judul: 'Pesisir Samudra Hindia', desc: '3 desa berbatasan langsung dengan Samudra Hindia — Karangjaladri, Ciliang, Cibenda. Potensi wisata pantai dan perikanan tangkap yang besar.', fact: '3 Desa Pesisir' },
    { icon: '🌿', judul: 'Kapulaga & Biofarmaka', desc: 'Kapulaga 94.740 kg, jahe 24.000 kg, kunyit 19.500 kg, kencur 12.000 kg per tahun. Salah satu sentra biofarmaka Jawa Barat.', fact: '94.740 kg/tahun' },
    { icon: '🍌', judul: 'Buah Lokal Unggulan', desc: 'Pisang 2.640 kw, durian 1.083 kw, alpukat 751 kw per tahun. Tanaman buah tahunan jadi andalan warga desa pegunungan.', fact: 'Buah Andalan' },
    { icon: '🌶️', judul: 'Sayuran & Hortikultura', desc: 'Tomat 557 kw, cabai rawit 264 kw, cabai besar 150 kw, bawang merah 106 kw diproduksi tiap tahun.', fact: 'Hortikultura Unggulan' },
    { icon: '🏫', judul: 'Pendidikan Lengkap', desc: '35 SD, 6 SMP, 5 SMK, 1 SMA, 1 MA. Akses pendidikan TK hingga SMA sangat mudah di seluruh 11 desa.', fact: '48+ Sekolah' },
    { icon: '🛒', judul: 'Perdagangan Aktif', desc: '2 pasar permanen, 6 minimarket, 5 rumah makan, 4 bank pemerintah, 4 koperasi simpan pinjam aktif.', fact: '6 Minimarket · 2 Pasar' },
];

const FILTER_TABS = [
    { label: '🛒 Semua', value: 'All' },
    { label: '🌿 Biofarmaka', value: 'biofarmaka' },
    { label: '🫚 Rempah', value: 'rempah' },
    { label: '🍌 Buah-buahan', value: 'buah' },
    { label: '🌶️ Sayuran', value: 'sayuran' },
];

// Fallback produk statis bila DB belum ada data
const PRODUCT_STATIC: productItem[] = [
    { id: 1, slug_kategori: 'biofarmaka', foto: 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400&q=80', kategori: 'Biofarmaka', nama: 'Kapulaga Segar', produksi: 'Prod. 94.740 kg/thn', harga: 'Rp 45.000/kg' },
    { id: 2, slug_kategori: 'rempah', foto: 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&q=80', kategori: 'Rempah', nama: 'Jahe Segar', produksi: 'Prod. 24.000 kg/thn', harga: 'Rp 18.000/kg' },
    { id: 3, slug_kategori: 'rempah', foto: 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&q=80', kategori: 'Rempah', nama: 'Kunyit Segar', produksi: 'Prod. 19.500 kg/thn', harga: 'Rp 12.000/kg' },
    { id: 4, slug_kategori: 'rempah', foto: 'https://images.unsplash.com/photo-1599909313208-3f9c08b11af5?w=400&q=80', kategori: 'Rempah', nama: 'Kencur', produksi: 'Prod. 12.000 kg/thn', harga: 'Rp 20.000/kg' },
    { id: 5, slug_kategori: 'buah', foto: 'https://images.unsplash.com/photo-1602201130723-9f78e41d70c5?w=400&q=80', kategori: 'Buah-buahan', nama: 'Durian Lokal', produksi: 'Prod. 1.083 kw/thn', harga: 'Rp 35.000/buah' },
    { id: 6, slug_kategori: 'buah', foto: 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400&q=80', kategori: 'Buah-buahan', nama: 'Pisang Lokal', produksi: 'Prod. 2.640 kw/thn', harga: 'Rp 8.000/sisir' },
    { id: 7, slug_kategori: 'buah', foto: 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&q=80', kategori: 'Buah-buahan', nama: 'Alpukat', produksi: 'Prod. 751 kw/thn', harga: 'Rp 15.000/buah' },
    { id: 8, slug_kategori: 'sayuran', foto: 'https://images.unsplash.com/photo-1558818498-28c1e002b655?w=400&q=80', kategori: 'Sayuran', nama: 'Tomat Segar', produksi: 'Prod. 557 kw/thn', harga: 'Rp 8.000/kg' },
    { id: 9, slug_kategori: 'sayuran', foto: 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', kategori: 'Sayuran', nama: 'Cabai Rawit', produksi: 'Prod. 264 kw/thn', harga: 'Rp 30.000/kg' },
    { id: 10, slug_kategori: 'sayuran', foto: 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=400&q=80', kategori: 'Sayuran', nama: 'Cabai Besar', produksi: 'Prod. 150 kw/thn', harga: 'Rp 22.000/kg' },
    { id: 11, slug_kategori: 'sayuran', foto: 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400&q=80', kategori: 'Sayuran', nama: 'Bawang Merah', produksi: 'Prod. 106 kw/thn', harga: 'Rp 25.000/kg' },
    { id: 12, slug_kategori: 'buah', foto: 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', kategori: 'Buah-buahan', nama: 'Pepaya', produksi: 'Prod. 14 kw/thn', harga: 'Rp 6.000/kg' },
];

// ─── Component ───────────────────────────────────────────
export default function Welcome({ auth, bestProducts, totalProduct }: Props) {
    const [activeFilter, setActiveFilter] = useState('All');

    // Pakai data dari DB kalau ada, fallback ke static
    const produkList = bestProducts?.length ? bestProducts : PRODUCT_STATIC;
    const filteredProduk = activeFilter === 'All'
        ? produkList
        : produkList.filter(p => p.slug_kategori === activeFilter);

    return (
        <>
            <Head title="Parigi Market — Produk Lokal Parigi, Pangandaran" />

            {/* Font */}
            <link
                href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
                rel="stylesheet"
            />

            <div className="font-[Plus_Jakarta_Sans] bg-[#f8faf8] scroll-smooth">

                {/* ══════════════════════════════════
                    HERO
                ══════════════════════════════════ */}
                <section className="relative flex min-h-screen items-center justify-center overflow-hidden -mt-16">
                    {/* BG */}
                    <div
                        className="absolute inset-0 animate-[slowZoom_18s_ease-in-out_infinite_alternate]"
                        style={{
                            background: "linear-gradient(160deg,rgba(26,58,42,0.78) 0%,rgba(45,106,79,0.5) 50%,rgba(26,58,42,0.72) 100%), url('https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=1600&q=80') center/cover no-repeat",
                        }}
                    />

                    {/* Badge */}
                    <span className="absolute top-[90px] right-[60px] hidden sm:block bg-[#e9c46a] text-[#1a3a2a] text-[0.7rem] font-bold tracking-[0.12em] uppercase px-4 py-1.5 rounded-full animate-[fadeDown_0.8s_0.4s_both]">
                        ✦ Kec. Parigi, Kab. Pangandaran — Jawa Barat
                    </span>

                    {/* Content */}
                    <div className="relative z-10 text-center px-5 max-w-[820px]">
                        <p className="text-xs font-semibold tracking-[0.2em] uppercase text-[#74c69d] mb-4 animate-[fadeUp_0.7s_0.1s_both]">
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
                                href="#tentang"
                                className="bg-[#40916c] text-white px-8 py-3 rounded-full text-[0.92rem] font-semibold shadow-[0_8px_24px_rgba(64,145,108,0.4)] transition hover:bg-[#74c69d] hover:-translate-y-0.5"
                            >
                                Kenali Parigi
                            </a>
                            <Link
                                // href={route('produk.index')}
                                className="border-2 border-white/50 text-white px-8 py-3 rounded-full text-[0.92rem] font-medium transition hover:border-[#74c69d] hover:text-[#74c69d]"
                            >
                                Lihat Produk Lokal
                            </Link>
                        </div>
                    </div>

                    {/* Scroll indicator */}
                    <div className="absolute bottom-7 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 text-white/40 text-[0.7rem] tracking-[0.1em] uppercase">
                        <div className="w-px h-8 bg-gradient-to-b from-white/50 to-transparent animate-[scrollP_2s_infinite]" />
                        Scroll
                    </div>
                </section>

                {/* ══════════════════════════════════
                    STATS
                ══════════════════════════════════ */}
                <div className="bg-[#1a3a2a] grid grid-cols-2 md:grid-cols-4 border-b-[3px] border-[#40916c]">
                    {STATS.map((s, i) => (
                        <div
                            key={i}
                            className="py-6 px-4 text-center border-r border-[#74c69d]/15 last:border-r-0"
                        >
                            <div
                                className="text-[1.9rem] font-black text-[#e9c46a] leading-none"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                {s.n}
                            </div>
                            <div className="text-[0.75rem] text-white/50 mt-1 tracking-[0.05em]">{s.l}</div>
                        </div>
                    ))}
                </div>

                {/* ══════════════════════════════════
                    TENTANG
                ══════════════════════════════════ */}
                <section id="tentang" className="py-20 px-6 md:px-16 bg-[#fefae0]">
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
                                {FACTS.map((f, i) => (
                                    <div
                                        key={i}
                                        className="bg-white rounded-r-xl px-4 py-4 border-l-[3px] border-[#40916c] shadow-[0_3px_12px_rgba(26,58,42,0.07)]"
                                    >
                                        <h4 className="text-[0.68rem] font-bold tracking-[0.08em] uppercase text-[#40916c] mb-1">{f.label}</h4>
                                        <p className="text-[0.9rem] font-semibold text-[#1a3a2a] m-0">{f.value}</p>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>

                {/* ══════════════════════════════════
                    PETA
                ══════════════════════════════════ */}
                <section id="peta" className="py-20 px-6 md:px-16 bg-[#f4faf6]">
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
                            {/* Map */}
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
                            {/* Desa grid */}
                            <div className="grid grid-cols-2 gap-2.5">
                                {DESA.map((d, i) => (
                                    <div
                                        key={i}
                                        className="bg-white rounded-xl px-4 py-3 border-t-2 border-[#40916c] shadow-[0_2px_8px_rgba(26,58,42,0.07)]"
                                    >
                                        <div className="text-[0.9rem] font-bold text-[#1a3a2a] mb-0.5">{d.nama}</div>
                                        <div className="text-[0.75rem] text-[#5a7060]">{d.luas}</div>
                                        <div className="text-[0.68rem] font-bold tracking-[0.06em] uppercase text-[#40916c] mt-1">{d.tipe}</div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </section>

                {/* ══════════════════════════════════
                    CIRI KHAS
                ══════════════════════════════════ */}
                <section id="ciri-khas" className="py-20 px-6 md:px-16 bg-[#1a3a2a]">
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
                        {CIRI.map((c, i) => (
                            <div
                                key={i}
                                className="bg-white/[0.055] border border-[#74c69d]/18 border-t-[3px] border-t-[#40916c] rounded-2xl p-8 transition hover:bg-white/[0.09] hover:-translate-y-1"
                            >
                                <span className="text-[2rem] mb-4 block">{c.icon}</span>
                                <h3
                                    className="text-[1.15rem] text-white mb-2"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    {c.judul}
                                </h3>
                                <p className="text-[0.87rem] leading-[1.7] text-white/55">{c.desc}</p>
                                <span className="inline-block mt-3 bg-[#74c69d]/15 text-[#74c69d] text-[0.7rem] font-bold tracking-[0.08em] px-2.5 py-1 rounded-full">
                                    {c.fact}
                                </span>
                            </div>
                        ))}
                    </div>
                </section>

                {/* ══════════════════════════════════
                    PRODUK UNGGULAN
                ══════════════════════════════════ */}
                <section id="produk" className="py-20 px-6 md:px-16 bg-[#fefae0]">
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
                                <p className="text-[1rem] text-[#4a6258]">Komoditas unggulan dari petani lokal Parigi — data produksi BPS 2024.</p>
                            </div>
                            <Link
                                // href={route('produk.index')}
                                className="bg-[#40916c] text-white px-8 py-3 rounded-full text-[0.92rem] font-semibold shadow-[0_8px_24px_rgba(64,145,108,0.4)] transition hover:bg-[#74c69d] hover:-translate-y-0.5 whitespace-nowrap"
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
                                    className={`text-[0.78rem] font-semibold px-4 py-1.5 rounded-full border-[1.5px] transition
                                        ${activeFilter === tab.value
                                            ? 'bg-[#40916c] text-white border-[#40916c]'
                                            : 'bg-transparent text-[#2d6a4f] border-[#40916c]/30 hover:bg-[#40916c] hover:text-white hover:border-[#40916c]'
                                        }`}
                                >
                                    {tab.label}
                                </button>
                            ))}
                        </div>

                        {/* Produk grid */}
                        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                            {filteredProduk.map((p, i) => (
                                <div
                                    key={i}
                                    className="bg-white rounded-2xl overflow-hidden shadow-[0_4px_16px_rgba(26,58,42,0.08)] transition hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(26,58,42,0.14)]"
                                >
                                    <img
                                        src={p.foto}
                                        alt={p.nama}
                                        className="w-full h-[170px] object-cover"
                                        onError={(e) => {
                                            (e.target as HTMLImageElement).src =
                                                `https://placehold.co/400x300/e8f5e9/2e7d32?text=${encodeURIComponent(p.nama)}`;
                                        }}
                                    />
                                    <div className="p-4">
                                        <div className="text-[0.68rem] font-bold tracking-[0.1em] uppercase text-[#40916c] mb-1">
                                            {p.kategori}
                                        </div>
                                        <div className="text-[0.92rem] font-bold text-[#1a3a2a] mb-1">{p.nama}</div>
                                        <div className="text-[0.75rem] text-[#5a7060] mb-1.5">{p.produksi}</div>
                                        <div
                                            className="text-[1.05rem] font-bold text-[#2d6a4f]"
                                            style={{ fontFamily: "'Playfair Display', serif" }}
                                        >
                                            {p.harga}
                                        </div>
                                        <Link
                                            // href={`${route('produk.index')}?kategori=${encodeURIComponent(p.kategori)}`}
                                            className="block text-center mt-3 bg-[#d8f3dc] text-[#1a3a2a] py-2 rounded-lg text-[0.82rem] font-semibold transition hover:bg-[#40916c] hover:text-white"
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
                    <p className="relative text-[1rem] text-white/55 max-w-[480px] mx-auto mb-9 leading-[1.72]">
                        Bergabunglah dan dukung UMKM serta petani lokal Kecamatan Parigi, Pangandaran.
                    </p>
                    <Link
                        // href={route('produk.index')}
                        className="relative inline-block bg-[#e9c46a] text-[#1a3a2a] px-9 py-3.5 rounded-full text-[0.93rem] font-bold shadow-[0_8px_28px_rgba(233,196,106,0.4)] transition hover:bg-[#f0d080] hover:-translate-y-1"
                    >
                        Mulai Belanja Sekarang →
                    </Link>
                </section>

                {/* ══════════════════════════════════
                    FOOTER
                ══════════════════════════════════ */}
                <footer className="bg-[#0f2318] px-6 md:px-16 pt-14 pb-6">
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-10 border-b border-[#74c69d]/12">
                        <div>
                            <a
                                href="/Parigi_Marketplace/public"
                                className="text-[1.2rem] font-black text-[#d8f3dc]"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                🌿 Parigi<span className="text-[#e9c46a]">Market</span>
                            </a>
                            <p className="text-[0.86rem] leading-[1.7] text-white/55 mt-2.5 max-w-[240px]">
                                Platform marketplace digital produk lokal Kecamatan Parigi, Kabupaten Pangandaran, Jawa Barat.
                            </p>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Navigasi</h4>
                            <ul className="space-y-1.5">
                                {['#tentang', '#peta', '#ciri-khas', '#produk'].map((href, i) => (
                                    <li key={i}>
                                        <a href={href} className="text-[0.84rem] text-white/55 transition hover:text-[#74c69d]">
                                            {['Tentang Parigi', 'Peta Wilayah', 'Ciri Khas', 'Produk Lokal'][i]}
                                        </a>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Marketplace</h4>
                            <ul className="space-y-1.5">
                                <li>
                                    {/*<Link href={route('produk.index')} className="text-[0.84rem] text-white/55 transition hover:text-[#74c69d]">*/}
                                        Semua Produk
                                    {/*</Link>*/}
                                </li>
                                <li>
                                    {/*<Link href={route('register')} className="text-[0.84rem] text-white/55 transition hover:text-[#74c69d]">*/}
                                        Daftar Penjual
                                    {/*</Link>*/}
                                </li>
                                <li>
                                    {/*<Link href={route('login')} className="text-[0.84rem] text-white/55 transition hover:text-[#74c69d]">*/}
                                    {/*    Masuk*/}
                                    {/*</Link>*/}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h4 className="text-[0.72rem] font-bold tracking-[0.12em] uppercase text-[#74c69d] mb-4">Kontak</h4>
                            <ul className="space-y-1.5">
                                <li><span className="text-[0.84rem] text-white/55">Parigi, Pangandaran, Jabar</span></li>
                                <li><a href="mailto:info@parigimarket.id" className="text-[0.84rem] text-white/55 transition hover:text-[#74c69d]">info@parigimarket.id</a></li>
                            </ul>
                        </div>
                    </div>
                    <div className="flex justify-between items-center pt-5 flex-wrap gap-2">
                        <p className="text-[0.78rem] text-white/55">© {new Date().getFullYear()} Parigi Market. Hak cipta dilindungi.</p>
                        <p className="text-[0.78rem] text-white/55">Data: BPS Kecamatan Parigi Dalam Angka 2025</p>
                    </div>
                </footer>
            </div>

            {/* Keyframe animations */}
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
        </>
    );
}
