import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function VerifyEmail({ status }: { status?: string }) {
    const { post, processing } = useForm({});

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('verification.send'));
    };

    return (
        <>
            <Head title="Verifikasi Email" />

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
                            <p className="mt-1 text-sm text-white/50">Verifikasi email kamu</p>
                        </div>

                        {/* Icon */}
                        <div className="mb-5 flex justify-center">
                            <div className="w-16 h-16 rounded-full bg-[#40916c]/30 border border-[#74c69d]/30 flex items-center justify-center text-3xl">
                                📧
                            </div>
                        </div>

                        <p className="mb-5 text-sm text-white/60 leading-relaxed text-center">
                            Terima kasih sudah mendaftar! Sebelum memulai, cek email kamu dan klik link verifikasi yang kami kirim. Tidak menerima email?
                        </p>

                        {/* Status sukses */}
                        {status === 'verification-link-sent' && (
                            <div className="mb-4 rounded-lg bg-[#40916c]/30 border border-[#74c69d]/30 px-4 py-3 text-sm text-[#d8f3dc] text-center">
                                ✅ Link verifikasi baru telah dikirim ke email kamu.
                            </div>
                        )}

                        <form onSubmit={submit} className="space-y-3">
                            <button
                                type="submit"
                                disabled={processing}
                                className="w-full rounded-lg bg-[#e9c46a] px-4 py-2.5 text-sm font-bold text-[#1a3a2a] shadow-lg transition hover:bg-[#f0d080] hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {processing ? 'Mengirim...' : 'Kirim Ulang Email Verifikasi'}
                            </button>
                        </form>

                        <div className="my-5 flex items-center gap-3">
                            <div className="h-px flex-1 bg-white/10" />
                            <span className="text-xs text-white/30">atau</span>
                            <div className="h-px flex-1 bg-white/10" />
                        </div>

                        <p className="text-center text-sm text-white/50">
                            <Link
                                href={route('logout')}
                                method="post"
                                as="button"
                                className="font-semibold text-[#74c69d] hover:text-[#d8f3dc] transition hover:underline bg-transparent border-none cursor-pointer"
                            >
                                Keluar dari akun ini
                            </Link>
                        </p>
                    </div>

                    <p className="mt-4 text-center text-xs text-white">
                        © {new Date().getFullYear()} Parigi Marketplace — Kec. Parigi, Pangandaran
                    </p>
                </div>
            </div>
        </>
    );
}
