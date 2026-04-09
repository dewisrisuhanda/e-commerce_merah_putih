import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

interface Props {
    status?: string;
    canResetPassword: boolean;
}

export default function Login({ status, canResetPassword }: Props) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <>
            <Head title="Masuk" />

            {/*
            =============================================
            ROOT — Full screen, background image
            Letakkan gambarmu di: public/images/login-bg.jpg
            Ganti path di bawah sesuai gambarmu.
            =============================================
            */}
            <div
                className="relative flex min-h-screen w-full items-center justify-center overflow-hidden"
                style={{
                    backgroundImage: "url('/storage/images/login-register-bg.avif')", // ← GANTI DENGAN GAMBARMU
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                }}
            >
                {/* Overlay gelap kehijauan di atas gambar */}
                <div className="absolute inset-0 bg-[#1a3a2a]/60" />

                {/* Noise/grain texture subtle supaya tidak flat */}
                <div
                    className="absolute inset-0 opacity-[0.04]"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`,
                    }}
                />

                {/* =============================================
                    CARD FORM — Glassmorphism
                    ============================================= */}
                <div className="relative z-10 w-full max-w-md px-4 py-8">
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
                                Masuk ke akun kamu
                            </p>
                        </div>

                        {/* Flash status */}
                        {status && (
                            <div className="mb-4 rounded-lg bg-[#40916c]/30 border border-[#74c69d]/30 px-4 py-3 text-sm text-[#d8f3dc]">
                                {status}
                            </div>
                        )}

                        <form onSubmit={submit} className="space-y-4">

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
                                    autoFocus
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

                            {/* Password */}
                            <div>
                                <div className="mb-1.5 flex items-center justify-between">
                                    <label
                                        htmlFor="password"
                                        className="text-sm font-medium text-[#d8f3dc]"
                                    >
                                        Password
                                    </label>
                                    {canResetPassword && (
                                        <Link
                                            href={route('password.request')}
                                            className="text-xs text-[#e9c46a] hover:text-[#f0d080] hover:underline transition"
                                        >
                                            Lupa password?
                                        </Link>
                                    )}
                                </div>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    autoComplete="current-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                    placeholder="••••••••"
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

                            {/* Remember Me */}
                            <div className="flex items-center gap-2">
                                <input
                                    id="remember"
                                    type="checkbox"
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                    className="h-4 w-4 rounded border-white/20 bg-white/10 text-[#40916c] focus:ring-[#74c69d]"
                                />
                                <label htmlFor="remember" className="text-sm text-white/60">
                                    Ingat saya
                                </label>
                            </div>

                            {/* Submit */}
                            <button
                                type="submit"
                                disabled={processing}
                                className="mt-2 w-full rounded-lg bg-[#e9c46a] px-4 py-2.5 text-sm font-bold text-[#1a3a2a] shadow-lg transition hover:bg-[#f0d080] hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {processing ? 'Memproses...' : 'Masuk'}
                            </button>
                        </form>

                        {/* Divider */}
                        <div className="my-5 flex items-center gap-3">
                            <div className="h-px flex-1 bg-white/10" />
                            <span className="text-xs text-white/30">atau</span>
                            <div className="h-px flex-1 bg-white/10" />
                        </div>

                        {/* Link register */}
                        <p className="text-center text-sm text-white/50">
                            Belum punya akun?{' '}
                            <Link
                                href={route('register')}
                                className="font-semibold text-[#74c69d] hover:text-[#d8f3dc] transition hover:underline"
                            >
                                Daftar di sini
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
