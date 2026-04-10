import MainLayout from '@/Layouts/MainLayout';
import { PageProps } from '@/types';
import { Head } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';

export default function Edit({
    mustVerifyEmail,
    status,
}: PageProps<{ mustVerifyEmail: boolean; status?: string }>) {
    return (
        <MainLayout>
            <Head title="Profil Saya" />

            <link
                href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
                rel="stylesheet"
            />

            <div style={{ fontFamily: "'Plus Jakarta Sans', sans-serif" }}>

                {/* ── Page Header ─────────────────────────────── */}
                <div
                    className="relative py-14 px-6 md:px-16 overflow-hidden"
                    style={{ background: 'linear-gradient(135deg,#1a3a2a 0%,#2d6a4f 60%,#40916c 100%)' }}
                >
                    <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_70%_50%,rgba(233,196,106,0.10),transparent_60%)]" />
                    <div className="relative max-w-[860px] mx-auto">
                        <span className="inline-block text-[0.7rem] font-bold tracking-[0.16em] uppercase text-[#74c69d] bg-[#74c69d]/15 px-3.5 py-1 rounded-full mb-3">
                            Akun Saya
                        </span>
                        <h1
                            className="text-[clamp(1.8rem,4vw,2.8rem)] font-black text-white leading-[1.1]"
                            style={{ fontFamily: "'Playfair Display', serif" }}
                        >
                            Pengaturan <em className="not-italic text-[#e9c46a]">Profil</em>
                        </h1>
                        <p className="text-white/55 text-[0.92rem] mt-2">
                            Kelola informasi akun dan keamanan akunmu di sini.
                        </p>
                    </div>
                </div>

                {/* ── Cards ───────────────────────────────────── */}
                <div className="bg-[#f4faf6] min-h-screen py-12 px-6 md:px-16">
                    <div className="max-w-[860px] mx-auto space-y-6">

                        {/* Card: Update Profile */}
                        <div className="bg-white rounded-2xl shadow-[0_4px_24px_rgba(26,58,42,0.08)] overflow-hidden">
                            <div className="px-7 py-4 border-b border-[#e8f5e9] flex items-center gap-3">
                                <span className="text-xl">👤</span>
                                <h2
                                    className="text-[1rem] font-bold text-[#1a3a2a]"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    Informasi Profil
                                </h2>
                            </div>
                            <div className="p-7">
                                <UpdateProfileInformationForm
                                    mustVerifyEmail={mustVerifyEmail}
                                    status={status}
                                    className="max-w-xl"
                                />
                            </div>
                        </div>

                        {/* Card: Update Password */}
                        <div className="bg-white rounded-2xl shadow-[0_4px_24px_rgba(26,58,42,0.08)] overflow-hidden">
                            <div className="px-7 py-4 border-b border-[#e8f5e9] flex items-center gap-3">
                                <span className="text-xl">🔐</span>
                                <h2
                                    className="text-[1rem] font-bold text-[#1a3a2a]"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    Ubah Password
                                </h2>
                            </div>
                            <div className="p-7">
                                <UpdatePasswordForm className="max-w-xl" />
                            </div>
                        </div>

                        {/* Card: Delete Account */}
                        <div className="bg-white rounded-2xl shadow-[0_4px_24px_rgba(26,58,42,0.08)] overflow-hidden border border-red-100">
                            <div className="px-7 py-4 border-b border-red-50 flex items-center gap-3">
                                <span className="text-xl">⚠️</span>
                                <h2
                                    className="text-[1rem] font-bold text-red-600"
                                    style={{ fontFamily: "'Playfair Display', serif" }}
                                >
                                    Hapus Akun
                                </h2>
                            </div>
                            <div className="p-7">
                                <DeleteUserForm className="max-w-xl" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
