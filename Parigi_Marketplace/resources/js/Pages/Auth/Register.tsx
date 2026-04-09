import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        address: '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <>
            <Head title="Daftar" />

            <div
                className="relative flex min-h-screen w-full items-center justify-center overflow-hidden py-10"
                style={{
                    backgroundImage: "url('/storage/images/login-register-bg.avif')", // ← GANTI DENGAN GAMBARMU
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                }}
            >
                {/* Overlay gelap kehijauan */}
                <div className="absolute inset-0 bg-[#1a3a2a]/60" />

                {/* Noise texture subtle */}
                <div
                    className="absolute inset-0 opacity-[0.04]"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`,
                    }}
                />

                {/* CARD FORM — Glassmorphism */}
                <div className="relative z-10 w-full max-w-md px-4 py-4">
                    <div
                        className="rounded-2xl border border-white/10 p-8 shadow-2xl"
                        style={{
                            background: 'rgba(26, 58, 42, 0.72)',
                            backdropFilter: 'blur(20px)',
                            WebkitBackdropFilter: 'blur(20px)',
                        }}
                    >
                        {/* Branding */}
                        <div className="mb-7 text-center">
                            <p className="mb-1 text-xs font-bold uppercase tracking-[0.14em] text-[#74c69d]/70">
                                🌿 Marketplace Lokal
                            </p>
                            <h1
                                className="text-3xl font-black text-[#d8f3dc]"
                                style={{ fontFamily: "'Playfair Display', serif" }}
                            >
                                Parigi<span className="text-[#e9c46a]">Market</span>
                            </h1>
                            <p className="mt-1 text-sm text-white/50">
                                Buat akun untuk mulai belanja
                            </p>
                        </div>

                        <form onSubmit={submit} className="space-y-4">

                            {/* Nama Lengkap */}
                            <div>
                                <label
                                    htmlFor="name"
                                    className="mb-1.5 block text-sm font-medium text-[#d8f3dc]"
                                >
                                    Nama Lengkap
                                </label>
                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value={data.name}
                                    autoFocus
                                    autoComplete="name"
                                    onChange={(e) => setData('name', e.target.value)}
                                    placeholder="Nama lengkap kamu"
                                    className={`w-full rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition
                                        focus:ring-2 focus:ring-[#74c69d]/40
                                        ${errors.name
                                            ? 'border-red-400/60 bg-red-900/20'
                                            : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'
                                        }`}
                                />
                                {errors.name && (
                                    <p className="mt-1 text-xs text-red-300">{errors.name}</p>
                                )}
                            </div>

                            {/* Email */}
                            <div>
                                <label
                                    htmlFor="email"
                                    className="mb-1.5 block text-sm font-medium text-[#d8f3dc]"
                                >
                                    Email
                                </label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    autoComplete="username"
                                    onChange={(e) => setData('email', e.target.value)}
                                    placeholder="email@contoh.com"
                                    className={`w-full rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition
                                        focus:ring-2 focus:ring-[#74c69d]/40
                                        ${errors.email
                                            ? 'border-red-400/60 bg-red-900/20'
                                            : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'
                                        }`}
                                />
                                {errors.email && (
                                    <p className="mt-1 text-xs text-red-300">{errors.email}</p>
                                )}
                            </div>

                            {/* Password & Konfirmasi — 2 kolom */}
                            <div className="grid grid-cols-2 gap-3">
                                <div>
                                    <label
                                        htmlFor="password"
                                        className="mb-1.5 block text-sm font-medium text-[#d8f3dc]"
                                    >
                                        Password
                                    </label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        value={data.password}
                                        autoComplete="new-password"
                                        onChange={(e) => setData('password', e.target.value)}
                                        placeholder="Min. 8 karakter"
                                        className={`w-full rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition
                                            focus:ring-2 focus:ring-[#74c69d]/40
                                            ${errors.password
                                                ? 'border-red-400/60 bg-red-900/20'
                                                : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'
                                            }`}
                                    />
                                    {errors.password && (
                                        <p className="mt-1 text-xs text-red-300">{errors.password}</p>
                                    )}
                                </div>

                                <div>
                                    <label
                                        htmlFor="password_confirmation"
                                        className="mb-1.5 block text-sm font-medium text-[#d8f3dc]"
                                    >
                                        Konfirmasi
                                    </label>
                                    <input
                                        id="password_confirmation"
                                        type="password"
                                        name="password_confirmation"
                                        value={data.password_confirmation}
                                        autoComplete="new-password"
                                        onChange={(e) => setData('password_confirmation', e.target.value)}
                                        placeholder="Ulangi password"
                                        className={`w-full rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition
                                            focus:ring-2 focus:ring-[#74c69d]/40
                                            ${errors.password_confirmation
                                                ? 'border-red-400/60 bg-red-900/20'
                                                : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'
                                            }`}
                                    />
                                    {errors.password_confirmation && (
                                        <p className="mt-1 text-xs text-red-300">{errors.password_confirmation}</p>
                                    )}
                                </div>
                            </div>

                            {/* Alamat Pengiriman */}
                            <div>
                                <label
                                    htmlFor="address"
                                    className="mb-1.5 block text-sm font-medium text-[#d8f3dc]"
                                >
                                    Alamat Pengiriman
                                </label>
                                <textarea
                                    id="address"
                                    name="address"
                                    value={data.address}
                                    rows={3}
                                    onChange={(e) => setData('address', e.target.value)}
                                    placeholder="Jl. Contoh No. 1, Kelurahan, Kecamatan, Kota"
                                    className={`w-full resize-none rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition
                                        focus:ring-2 focus:ring-[#74c69d]/40
                                        ${errors.address
                                            ? 'border-red-400/60 bg-red-900/20'
                                            : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'
                                        }`}
                                />
                                {errors.address && (
                                    <p className="mt-1 text-xs text-red-300">{errors.address}</p>
                                )}
                            </div>

                            {/* Submit */}
                            <button
                                type="submit"
                                disabled={processing}
                                className="mt-2 w-full rounded-lg bg-[#e9c46a] px-4 py-2.5 text-sm font-bold text-[#1a3a2a] shadow-lg transition hover:bg-[#f0d080] hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {processing ? 'Memproses...' : 'Daftar Sekarang'}
                            </button>
                        </form>

                        {/* Divider */}
                        <div className="my-5 flex items-center gap-3">
                            <div className="h-px flex-1 bg-white/10" />
                            <span className="text-xs text-white/30">atau</span>
                            <div className="h-px flex-1 bg-white/10" />
                        </div>

                        {/* Link login */}
                        <p className="text-center text-sm text-white/50">
                            Sudah punya akun?{' '}
                            <Link
                                href={route('login')}
                                className="font-semibold text-[#74c69d] hover:text-[#d8f3dc] transition hover:underline"
                            >
                                Masuk di sini
                            </Link>
                        </p>
                    </div>

                    {/* Footer kecil */}
                    <p className="mt-4 text-center text-xs text-white">
                        © {new Date().getFullYear()} Parigi Marketplace — Kec. Parigi, Pangandaran
                    </p>
                </div>
            </div>
        </>
    );
}
