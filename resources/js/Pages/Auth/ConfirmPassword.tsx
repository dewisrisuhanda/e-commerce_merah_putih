import { Head, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({ password: '' });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('password.confirm'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <>
            <Head title="Konfirmasi Password" />

            <div
                className="relative flex min-h-screen w-full items-center justify-center overflow-hidden"
                style={{
                    backgroundImage: "url('/storage/images/login-register-bg.avif')",
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                }}
            >
                <div className="absolute inset-0 bg-[#1a3a2a]/60" />
                <div
                    className="absolute inset-0 opacity-[0.04]"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`,
                    }}
                />

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
                            <h1 className="text-3xl font-black text-[#d8f3dc]" style={{ fontFamily: "'Playfair Display', serif" }}>
                                Parigi<span className="text-[#e9c46a]">Market</span>
                            </h1>
                            <p className="mt-1 text-sm text-white/50">Area aman — konfirmasi identitasmu</p>
                        </div>

                        <p className="mb-5 text-sm text-white/60 leading-relaxed text-center">
                            Halaman ini memerlukan verifikasi password sebelum melanjutkan.
                        </p>

                        <form onSubmit={submit} className="space-y-4">
                            <div>
                                <label htmlFor="password" className="mb-1.5 block text-sm font-medium text-[#d8f3dc]">
                                    Password
                                </label>
                                <input
                                    id="password"
                                    type="password"
                                    value={data.password}
                                    autoFocus
                                    autoComplete="current-password"
                                    onChange={e => setData('password', e.target.value)}
                                    placeholder="••••••••"
                                    className={`w-full rounded-lg border px-4 py-2.5 text-sm text-white placeholder-white/30 outline-none transition focus:ring-2 focus:ring-[#74c69d]/40
                                        ${errors.password ? 'border-red-400/60 bg-red-900/20' : 'border-white/10 bg-white/10 focus:border-[#74c69d]/60'}`}
                                />
                                {errors.password && <p className="mt-1 text-xs text-red-300">{errors.password}</p>}
                            </div>

                            <button
                                type="submit"
                                disabled={processing}
                                className="mt-2 w-full rounded-lg bg-[#e9c46a] px-4 py-2.5 text-sm font-bold text-[#1a3a2a] shadow-lg transition hover:bg-[#f0d080] hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {processing ? 'Memverifikasi...' : 'Konfirmasi'}
                            </button>
                        </form>
                    </div>

                    <p className="mt-4 text-center text-xs text-white">
                        © {new Date().getFullYear()} Parigi Marketplace — Kec. Parigi, Pangandaran
                    </p>
                </div>
            </div>
        </>
    );
}
