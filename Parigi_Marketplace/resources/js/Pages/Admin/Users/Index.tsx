import { Head } from '@inertiajs/react';
import AdminLayout from '@/Layouts/AdminLayout';

interface User {
    id: number;
    name: string;
    email: string;
    address: string | null;
    role: string;
    created_at: string;
}

interface UsersProps { users: User[]; }

const ROLE_STYLES: Record<string, { bg: string; text: string }> = {
    admin:    { bg: 'bg-red-100',   text: 'text-red-600' },
    user:     { bg: 'bg-green-100', text: 'text-green-700' },
    seller:   { bg: 'bg-amber-100', text: 'text-amber-700' },
};

export default function Index({ users }: UsersProps) {
    return (
        <AdminLayout title="Kelola Pengguna" breadcrumb="Admin → Kelola → Pengguna" activeMenu="users">
            <Head title="Kelola Pengguna — Admin" />

            <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div className="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>👥 Semua Pengguna</div>
                    <span className="text-xs text-gray-400">{users.length} pengguna terdaftar</span>
                </div>

                <div className="overflow-x-auto">
                    <table className="w-full text-sm">
                        <thead>
                        <tr className="border-b border-gray-100 bg-gray-50">
                            {['Pengguna', 'Email', 'Alamat', 'Role', 'Bergabung'].map((h, i) => (
                                <th key={i} className="text-left px-5 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">{h}</th>
                            ))}
                        </tr>
                        </thead>
                        <tbody>
                        {users.length === 0 ? (
                            <tr><td colSpan={5} className="text-center py-12 text-gray-400">Belum ada pengguna</td></tr>
                        ) : users.map(u => {
                            const rs = ROLE_STYLES[u.role] ?? { bg: 'bg-gray-100', text: 'text-gray-500' };
                            return (
                                <tr key={u.id} className="border-b border-gray-50 hover:bg-gray-50 transition">
                                    <td className="px-5 py-3">
                                        <div className="flex items-center gap-2.5">
                                            <div className="w-8 h-8 rounded-full bg-green-100 text-green-700 text-xs font-bold flex items-center justify-center flex-shrink-0">
                                                {u.name.slice(0, 2).toUpperCase()}
                                            </div>
                                            <span className="font-semibold text-gray-900">{u.name}</span>
                                        </div>
                                    </td>
                                    <td className="px-5 py-3 text-gray-500">{u.email}</td>
                                    <td className="px-5 py-3 text-gray-400 text-xs max-w-[160px] truncate">{u.address ?? '-'}</td>
                                    <td className="px-5 py-3">
                                            <span className={`text-[11px] font-bold px-2.5 py-0.5 rounded-full ${rs.bg} ${rs.text}`}>
                                                {u.role.charAt(0).toUpperCase() + u.role.slice(1)}
                                            </span>
                                    </td>
                                    <td className="px-5 py-3 text-xs text-gray-400">{u.created_at}</td>
                                </tr>
                            );
                        })}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
