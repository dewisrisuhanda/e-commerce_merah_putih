import { Link, router, usePage } from '@inertiajs/react';
import { useState, useEffect, ReactNode } from 'react';
import { PageProps } from '@/types';

interface Props {
    children: ReactNode;
    title: string;
    breadcrumb?: string;
    activeMenu?: string;
}

const NAV = [
    {
        section: 'Utama',
        items: [
            { key: 'dashboard',  icon: '📊', label: 'Dashboard',        route: 'admin.dashboard' },
            { key: 'products',   icon: '📦', label: 'Kelola Produk',    route: 'admin.products.index' },
            { key: 'orders',     icon: '🛍️', label: 'Kelola Pesanan',   route: 'admin.orders.index' },
        ],
    },
    {
        section: 'Kelola',
        items: [
            { key: 'users',      icon: '👥', label: 'Pengguna',         route: 'admin.users.index' },
            { key: 'categories', icon: '🏷️', label: 'Kategori',         route: 'admin.categories.index' },
        ],
    },
    {
        section: 'Laporan',
        items: [
            { key: 'sales',    icon: '📈', label: 'Penjualan',   route: 'admin.reports.sales' },
            { key: 'finance',  icon: '💰', label: 'Keuangan',    route: 'admin.reports.finance' },
        ],
    },
    {
        section: 'Sistem',
        items: [
            { key: 'profile',   icon: '👤', label: 'Profil Saya', route: 'profile.edit' },
            { key: 'store',   icon: '🏪', label: 'Lihat Toko', route: 'home' },
            { key: 'logout',  icon: '🚪', label: 'Keluar',     route: 'logout', isPost: true },
        ],
    },
];

export default function AdminLayout({ children, title, breadcrumb, activeMenu }: Props) {
    const { auth } = usePage<PageProps>().props;
    const user = auth?.user;

    // collapsed: sidebar diperkecil (ikon saja), mobile: hamburger overlay
    const [collapsed, setCollapsed] = useState(false);
    const [mobileOpen, setMobileOpen] = useState(false);

    const render = (name: string) => route().has(name) ? route(name) : '#';
    const initials = user?.name ? user.name.slice(0, 2).toUpperCase() : 'AD';

    useEffect(() => {
        const onResize = () => { if (window.innerWidth >= 1024) setMobileOpen(false); };
        window.addEventListener('resize', onResize);
        return () => window.removeEventListener('resize', onResize);
    }, []);

    const handleLogout = () => router.post(render('logout'));

    const SidebarContent = ({ onClose }: { onClose?: () => void }) => (
        <div className="flex flex-col h-full">
            {/* Logo */}
            <div className={`border-b border-white/10 ${collapsed ? 'px-3 py-5' : 'px-5 py-6'}`}>
                <div className="flex items-center gap-2.5">
                    <div className="w-8 h-8 bg-[#2dc653] rounded-lg flex items-center justify-center text-base flex-shrink-0">🛒</div>
                    {!collapsed && (
                        <div>
                            <div className="text-white font-bold text-[15px]" style={{ fontFamily: "'Sora', sans-serif" }}>
                                Parigi Market
                            </div>
                            <div className="text-white/40 text-[10px] mt-0.5">ADMIN PANEL</div>
                        </div>
                    )}
                </div>
            </div>

            {/* Nav */}
            <nav className="flex-1 overflow-y-auto py-3 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                {NAV.map(group => (
                    <div key={group.section}>
                        {!collapsed && (
                            <div className="text-[10px] font-semibold text-white/35 tracking-widest uppercase px-5 pt-3 pb-1.5">
                                {group.section}
                            </div>
                        )}
                        {group.items.map(item => {
                            const isActive = activeMenu === item.key;
                            const href = render(item.route);

                            if (item.isPost) {
                                return (
                                    <button
                                        key={item.key}
                                        onClick={handleLogout}
                                        className={`w-full flex items-center gap-2.5 border-none bg-transparent cursor-pointer transition-all duration-150 border-l-[3px] text-left
                                            ${collapsed ? 'px-3 py-2.5 justify-center' : 'px-5 py-2.5'}
                                            text-white/60 border-transparent hover:bg-white/7 hover:text-white`}
                                        title={collapsed ? item.label : undefined}
                                    >
                                        <span className="text-base flex-shrink-0">{item.icon}</span>
                                        {!collapsed && <span className="text-[13px] font-medium">{item.label}</span>}
                                    </button>
                                );
                            }

                            return (
                                <Link
                                    key={item.key}
                                    href={href}
                                    onClick={onClose}
                                    className={`flex items-center gap-2.5 no-underline transition-all duration-150 border-l-[3px]
                                        ${collapsed ? 'px-3 py-2.5 justify-center' : 'px-5 py-2.5'}
                                        ${isActive
                                            ? 'bg-[#2dc653]/15 text-[#2dc653] border-[#2dc653]'
                                            : 'text-white/60 border-transparent hover:bg-white/7 hover:text-white'
                                        }`}
                                    title={collapsed ? item.label : undefined}
                                >
                                    <span className="text-base flex-shrink-0">{item.icon}</span>
                                    {!collapsed && <span className="text-[13px] font-medium">{item.label}</span>}
                                </Link>
                            );
                        })}
                    </div>
                ))}
            </nav>

            {/* User */}
            <div className={`border-t border-white/10 ${collapsed ? 'px-3 py-4' : 'px-5 py-4'} flex items-center gap-2.5`}>
                <div className="w-8 h-8 rounded-full bg-[#22a046] text-white text-[12px] font-bold flex items-center justify-center flex-shrink-0">
                    {initials}
                </div>
                {!collapsed && (
                    <div className="min-w-0">
                        <div className="text-white text-[13px] font-semibold truncate">{user?.name ?? 'Admin'}</div>
                        <div className="text-white/40 text-[11px]">Admin</div>
                    </div>
                )}
            </div>
        </div>
    );

    return (
        <div className="flex min-h-screen bg-[#f0f7f2]" style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

            {/* ══════════════════════════════════
                DESKTOP SIDEBAR
            ══════════════════════════════════ */}
            <aside
                className={`hidden lg:flex flex-col fixed top-0 left-0 h-screen z-50 transition-all duration-300 bg-[#0d4a1e]
                    ${collapsed ? 'w-[60px]' : 'w-[240px]'}`}
            >
                <SidebarContent />
            </aside>

            {/* ══════════════════════════════════
                MOBILE SIDEBAR OVERLAY
            ══════════════════════════════════ */}
            {mobileOpen && (
                <>
                    <div className="fixed inset-0 z-40 bg-black/50" onClick={() => setMobileOpen(false)} />
                    <aside className="fixed top-0 left-0 h-screen w-[240px] z-50 bg-[#0d4a1e] flex flex-col lg:hidden">
                        <SidebarContent onClose={() => setMobileOpen(false)} />
                    </aside>
                </>
            )}

            {/* ══════════════════════════════════
                MAIN CONTENT
            ══════════════════════════════════ */}
            <div className={`flex-1 flex flex-col min-w-0 transition-all duration-300 ${collapsed ? 'lg:ml-[60px]' : 'lg:ml-[240px]'}`}>

                {/* Topbar */}
                <div className="bg-white border-b border-gray-100 sticky top-0 z-30 h-[60px] flex items-center justify-between px-6 gap-4">
                    <div className="flex items-center gap-3">
                        {/* Mobile hamburger */}
                        <button
                            onClick={() => setMobileOpen(true)}
                            className="lg:hidden w-8 h-8 flex flex-col gap-1 items-center justify-center bg-transparent border-none cursor-pointer"
                        >
                            <span className="block w-5 h-0.5 bg-gray-500" />
                            <span className="block w-5 h-0.5 bg-gray-500" />
                            <span className="block w-5 h-0.5 bg-gray-500" />
                        </button>

                        {/* Desktop collapse toggle */}
                        <button
                            onClick={() => setCollapsed(!collapsed)}
                            className="hidden lg:flex w-8 h-8 items-center justify-center bg-gray-50 border border-gray-100 rounded-lg cursor-pointer text-gray-500 hover:bg-gray-100 transition"
                            title={collapsed ? 'Perlebar sidebar' : 'Perkecil sidebar'}
                        >
                            {collapsed ? '→' : '←'}
                        </button>

                        <div>
                            <div className="font-bold text-[15px] text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
                                {title}
                            </div>
                            {breadcrumb && (
                                <div className="text-[11px] text-gray-400 mt-0.5">{breadcrumb}</div>
                            )}
                        </div>
                    </div>

                    <Link
                        href={render('home')}
                        className="hidden sm:flex items-center gap-1.5 text-[12px] text-gray-500 border border-gray-200 rounded-lg px-3 py-1.5 no-underline transition hover:bg-gray-50"
                    >
                        🏪 Lihat Toko
                    </Link>
                </div>

                {/* Page Content */}
                <main className="flex-1 p-6 md:p-7">
                    {children}
                </main>
            </div>
        </div>
    );
}
