import { Link, router, usePage } from '@inertiajs/react';
import { useState, useEffect, ReactNode } from 'react';
import { PageProps } from '@/types';

interface Props {
    children: ReactNode;
    keyword?: string;
}

export default function MainLayout({ children, keyword = '' }: Props) {
    const { auth } = usePage<PageProps>().props;
    const user = auth?.user ?? null;

    const [searchQuery, setSearchQuery] = useState(keyword);
    const [dropdownOpen, setDropdownOpen] = useState(false);
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    // Bug fix #2: auto-close mobile menu saat resize ke desktop (lg = 1024px)
    useEffect(() => {
        const handleResize = () => {
            if (window.innerWidth >= 1024) setMobileMenuOpen(false);
        };
        window.addEventListener('resize', handleResize);
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    // ── Helpers ──────────────────────────────────────────────
    const render = (name: string) => route().has(name) ? route(name) : '#';

    const handleSearch = (e: React.FormEvent) => {
        e.preventDefault();
        if (!searchQuery.trim()) return;
        router.get(render('products.index'), { search: searchQuery });
    };

    const handleLogout = () => {
        router.post(render('logout'));
        setDropdownOpen(false);
    };

    const initials = user?.name ? user.name.slice(0, 2).toUpperCase() : '';

    const NAV_LINKS = [
        { href: '/#about',    label: 'Tentang Parigi' },
        { href: '/#map',      label: 'Peta Wilayah' },
        { href: '/#features', label: 'Ciri Khas' },
        { href: '/#products', label: 'Produk Lokal' },
        { href: render('products.index'), label: 'Marketplace' },
    ];

    return (
        <div className="min-h-screen bg-[#f8faf8]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

            {/* ══════════════════════════════════
                NAVBAR
            ══════════════════════════════════ */}
            <nav
                className="fixed top-0 left-0 right-0 z-[999] flex items-center justify-between gap-4 px-5 md:px-10 h-16 border-b border-[#74c69d]/18"
                style={{ background: 'rgba(26,58,42,0.96)', backdropFilter: 'blur(16px)', WebkitBackdropFilter: 'blur(16px)' }}
            >
                {/* Brand */}
                <Link href={render('home')} className="flex-shrink-0 no-underline" style={{ fontFamily: "'Playfair Display', serif" }}>
                    <span className="text-[1.2rem] font-bold text-[#d8f3dc]">
                        🌿 Parigi<span className="text-[#e9c46a]">Market</span>
                    </span>
                </Link>

                {/* Desktop Nav Links */}
                <ul className="hidden lg:flex items-center gap-1 list-none m-0 p-0 flex-shrink-0">
                    {NAV_LINKS.map((item, i) => (
                        <li key={i}>
                            <Link href={item.href} className="text-white/70 text-[0.82rem] font-medium px-3 py-1.5 rounded-full transition hover:text-[#74c69d] hover:bg-[#74c69d]/10 no-underline">
                                {item.label}
                            </Link>
                        </li>
                    ))}
                </ul>

                {/* Search Bar
                    Fix: pakai onSubmit di form, bukan onclick di button
                    Fix: hilangkan outline biru dengan className yg tepat */}
                <form
                    onSubmit={handleSearch}
                    className="hidden sm:flex items-center flex-1 max-w-[240px] border border-[#74c69d]/25 rounded-full px-2 py-1.5 gap-0"
                    style={{ background: 'rgba(255,255,255,0.09)' }}
                >
                    <span className="text-white/35 text-sm flex-shrink-0 px-1">🔍</span>
                    <input
                        type="text"
                        value={searchQuery}
                        onChange={e => setSearchQuery(e.target.value)}
                        placeholder="Cari produk..."
                        className="flex-1 bg-transparent border-none text-white text-[0.82rem] placeholder:text-white/35"
                        style={{ outline: 'none', boxShadow: 'none', padding: 0 }}
                    />
                    <button
                        type="submit"
                        className="flex-shrink-0 bg-[#40916c] text-white text-[0.78rem] font-semibold rounded-full px-3 border-none cursor-pointer transition hover:bg-[#74c69d] whitespace-nowrap self-stretch flex items-center"
                    >
                        Cari
                    </button>
                </form>

                {/* Right Side */}
                <div className="flex items-center gap-2 flex-shrink-0">
                    {user ? (
                        <>
                            <Link href={render('cart.index')} className="hidden sm:inline-flex text-white/70 text-lg px-2 py-1 rounded-full transition hover:text-[#74c69d] hover:bg-[#74c69d]/10 no-underline">🛒</Link>
                            <Link href={render('orders.index')} className="hidden sm:inline-flex text-white/70 text-lg px-2 py-1 rounded-full transition hover:text-[#74c69d] hover:bg-[#74c69d]/10 no-underline">🛍️</Link>
                            {user.role === 'admin' && (
                                <Link href={render('admin.dashboard')} className="hidden sm:inline-flex text-[0.7rem] font-bold tracking-wider uppercase px-2.5 py-1 rounded-full no-underline transition" style={{ background: 'rgba(233,196,106,0.18)', color: '#e9c46a' }}>
                                    🛡 Admin
                                </Link>
                            )}
                            {/* User Dropdown */}
                            <div className="relative">
                                <button
                                    onClick={() => setDropdownOpen(!dropdownOpen)}
                                    className="flex items-center gap-1.5 border border-[#74c69d]/20 rounded-full pl-1.5 pr-3 py-1 text-white/85 text-[0.82rem] font-medium cursor-pointer"
                                    style={{ background: 'rgba(255,255,255,0.08)' }}
                                >
                                    <div className="w-6 h-6 rounded-full bg-[#40916c] text-white text-[0.68rem] font-bold flex items-center justify-center">{initials}</div>
                                    <span className="hidden md:inline max-w-[100px] truncate">{user.name}</span>
                                    <span className="text-[0.6rem] text-white/40">▾</span>
                                </button>
                                {dropdownOpen && (
                                    <>
                                        <div className="fixed inset-0 z-10" onClick={() => setDropdownOpen(false)} />
                                        <div className="absolute right-0 top-full mt-2 z-20 min-w-[180px] rounded-xl overflow-hidden py-1.5 bg-white shadow-[0_8px_32px_rgba(26,58,42,0.18)]">
                                            <Link href={render('orders.index')} className="flex items-center gap-2 px-3 py-2 text-[0.84rem] text-gray-700 hover:bg-[#f4faf6] no-underline" onClick={() => setDropdownOpen(false)}>🛍️ Pesanan Saya</Link>
                                            <Link href={render('profile.edit')} className="flex items-center gap-2 px-3 py-2 text-[0.84rem] text-gray-700 hover:bg-[#f4faf6] no-underline" onClick={() => setDropdownOpen(false)}>👤 Profil</Link>
                                            <hr className="my-1 border-gray-100" />
                                            <button onClick={handleLogout} className="w-full flex items-center gap-2 px-3 py-2 text-[0.84rem] text-red-500 hover:bg-red-50 bg-transparent border-none cursor-pointer text-left">🚪 Logout</button>
                                        </div>
                                    </>
                                )}
                            </div>
                        </>
                    ) : (
                        <>
                            <Link href={render('login')} className="text-white/75 text-[0.82rem] font-medium px-3.5 py-1.5 rounded-full border border-white/20 transition hover:text-white hover:border-white/50 no-underline whitespace-nowrap">Masuk</Link>
                            <Link href={render('register')} className="text-[#1a3a2a] text-[0.82rem] font-bold px-3.5 py-1.5 rounded-full transition hover:opacity-90 no-underline whitespace-nowrap" style={{ background: '#e9c46a' }}>Daftar</Link>
                        </>
                    )}

                    {/* Mobile Hamburger */}
                    <button
                        className="lg:hidden flex flex-col gap-1 p-2 cursor-pointer bg-transparent border-none"
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        aria-label="Menu"
                    >
                        <span className={`block w-5 h-0.5 bg-white/75 transition-all ${mobileMenuOpen ? 'rotate-45 translate-y-1.5' : ''}`} />
                        <span className={`block w-5 h-0.5 bg-white/75 transition-all ${mobileMenuOpen ? 'opacity-0' : ''}`} />
                        <span className={`block w-5 h-0.5 bg-white/75 transition-all ${mobileMenuOpen ? '-rotate-45 -translate-y-1.5' : ''}`} />
                    </button>
                </div>
            </nav>

            {/* ══════════════════════════════════
                MOBILE MENU DROPDOWN
            ══════════════════════════════════ */}
            {mobileMenuOpen && (
                <>
                    <div className="fixed inset-0 z-[998]" onClick={() => setMobileMenuOpen(false)} />
                    <div
                        className="fixed top-16 left-0 right-0 z-[999] py-3 px-4 shadow-xl"
                        style={{ background: 'rgba(26,58,42,0.98)', backdropFilter: 'blur(16px)' }}
                    >
                        {/* Mobile Search */}
                        <form onSubmit={handleSearch} className="flex items-center border border-[#74c69d]/25 rounded-full overflow-hidden px-3 gap-1 mb-3" style={{ background: 'rgba(255,255,255,0.09)' }}>
                            <span className="text-white/35 text-sm">🔍</span>
                            <input
                                type="text"
                                value={searchQuery}
                                onChange={e => setSearchQuery(e.target.value)}
                                placeholder="Cari produk..."
                                className="flex-1 bg-transparent border-none text-white text-sm py-2 placeholder:text-white/35"
                                style={{ outline: 'none', boxShadow: 'none' }}
                            />
                            <button type="submit" className="bg-[#40916c] text-white text-xs font-semibold rounded-full px-3 py-1 border-none cursor-pointer">Cari</button>
                        </form>

                        {/* Mobile Nav Links */}
                        {NAV_LINKS.map((item, i) => (
                            <Link key={i} href={item.href} onClick={() => setMobileMenuOpen(false)} className="block py-2.5 px-3 text-white/75 text-sm font-medium border-b border-[#74c69d]/10 last:border-0 no-underline hover:text-[#74c69d]">
                                {item.label}
                            </Link>
                        ))}

                        {/* Mobile Auth/User Links */}
                        {user ? (
                            <div className="mt-2 pt-2 border-t border-[#74c69d]/15 flex flex-col gap-1">
                                <Link href={render('cart.index')} onClick={() => setMobileMenuOpen(false)} className="flex items-center gap-2 py-2 px-3 text-white/75 text-sm no-underline hover:text-[#74c69d]">🛒 Keranjang</Link>
                                <Link href={render('orders.index')} onClick={() => setMobileMenuOpen(false)} className="flex items-center gap-2 py-2 px-3 text-white/75 text-sm no-underline hover:text-[#74c69d]">🛍️ Pesanan Saya</Link>
                                <button onClick={handleLogout} className="flex items-center gap-2 py-2 px-3 text-red-400 text-sm bg-transparent border-none cursor-pointer text-left">🚪 Logout</button>
                            </div>
                        ) : (
                            <div className="mt-2 pt-2 border-t border-[#74c69d]/15 flex gap-2">
                                <Link href={render('login')} onClick={() => setMobileMenuOpen(false)} className="flex-1 text-center py-2 text-white/75 text-sm border border-white/20 rounded-full no-underline hover:text-white">Masuk</Link>
                                <Link href={render('register')} onClick={() => setMobileMenuOpen(false)} className="flex-1 text-center py-2 text-[#1a3a2a] text-sm font-bold rounded-full no-underline" style={{ background: '#e9c46a' }}>Daftar</Link>
                            </div>
                        )}
                    </div>
                </>
            )}

            {/* ══════════════════════════════════
                PAGE CONTENT
            ══════════════════════════════════ */}
            <div className="pt-16">
                {children}
            </div>

            {/* ══════════════════════════════════
                FOOTER
            ══════════════════════════════════ */}
            <footer className="bg-[#0f2318] border-t border-[#74c69d]/10 py-5 text-center text-white/30 text-sm">
                © {new Date().getFullYear()} Parigi Marketplace - Hasil Tani &amp; Nelayan Parigi
            </footer>
        </div>
    );
}
