import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';

interface Category {
    id?: number;
    name?: string;
    slug?: string;
}

interface Props {
    category?: Category;
}

const CAT_ICON: Record<string, string> = {
    'Hasil Tani':    '🌾',
    'Hasil Laut':    '🐟',
    'Oleh-oleh':     '🎁',
    'Buah-buahan':   '🍈',
    'Rempah':        '🌶️',
    'Produk Olahan': '🏭',
    'Biofarmaka':    '🌱',
    'Sayuran':       '🥬',
    'Kerajinan':     '🎨',
};

export default function Form({ category }: Props) {
    const isEdit = !!category?.id;
    const r = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const { data, setData, post, put, processing, errors } = useForm({
        name: category?.name ?? '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(r('admin.categories.update', category!.id));
        } else {
            post(r('admin.categories.store'));
        }
    };

    // Preview icon berdasarkan nama yang diketik
    const previewIcon = CAT_ICON[data.name] ?? '📦';
    const hasMatch = !!CAT_ICON[data.name];

    return (
        <AdminLayout
            title={isEdit ? 'Edit Kategori' : 'Tambah Kategori'}
            breadcrumb={`Admin → Kategori → ${isEdit ? 'Edit' : 'Tambah'}`}
            activeMenu="categories"
        >
            <Head title={`${isEdit ? 'Edit' : 'Tambah'} Kategori`} />

            <div className="max-w-lg">
                <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">

                    {/* Header */}
                    <div className="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div
                            className="font-bold text-sm text-gray-900"
                            style={{ fontFamily: "'Sora', sans-serif" }}
                        >
                            {isEdit ? '✏️ Edit Kategori' : '🏷️ Tambah Kategori Baru'}
                        </div>
                        <Link
                            href={r('admin.categories.index')}
                            className="text-xs text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg no-underline hover:bg-gray-50 transition"
                        >
                            ← Kembali
                        </Link>
                    </div>

                    <form onSubmit={submit} className="p-6 space-y-5">

                        {/* Preview */}
                        <div className="flex items-center gap-4 p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <span className="text-4xl">{previewIcon}</span>
                            <div>
                                <div
                                    className="font-bold text-[15px] text-gray-900"
                                    style={{ fontFamily: "'Sora', sans-serif" }}
                                >
                                    {data.name || <span className="text-gray-400 font-normal text-sm">Nama kategori...</span>}
                                </div>
                                {data.name && (
                                    <div className="text-[10px] text-gray-400 font-mono mt-0.5">
                                        /{data.name.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '')}
                                    </div>
                                )}
                                {!hasMatch && data.name && (
                                    <div className="text-[10px] text-amber-500 mt-0.5">
                                        ⚠️ Ikon default — tambahkan ke CAT_ICON jika perlu ikon khusus
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Name */}
                        <div>
                            <label className="block text-xs font-semibold text-gray-600 mb-1.5">
                                Nama Kategori <span className="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                value={data.name}
                                onChange={e => setData('name', e.target.value)}
                                autoFocus
                                placeholder="Contoh: Hasil Tani"
                                className={`w-full px-3.5 py-2.5 border rounded-lg text-sm text-gray-900 transition focus:outline-none focus:ring-2 focus:ring-[#2dc653]/20 focus:border-[#2dc653]
                                    ${errors.name ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'}`}
                                required
                            />
                            {errors.name && (
                                <p className="mt-1 text-xs text-red-500">{errors.name}</p>
                            )}
                            <p className="mt-1.5 text-xs text-gray-400">
                                Slug akan digenerate otomatis dari nama.
                                {isEdit && category?.slug && (
                                    <> Slug saat ini: <span className="font-mono text-gray-500">/{category.slug}</span></>
                                )}
                            </p>
                        </div>

                        {/* Buttons */}
                        <div className="flex gap-3 pt-1">
                            <button
                                type="submit"
                                disabled={processing}
                                className="bg-[#22a046] text-white text-sm font-semibold px-5 py-2.5 rounded-lg border-none cursor-pointer hover:bg-[#1a7c36] transition disabled:opacity-60 disabled:cursor-not-allowed"
                            >
                                {processing
                                    ? 'Menyimpan...'
                                    : isEdit
                                        ? '💾 Simpan Perubahan'
                                        : '🏷️ Tambah Kategori'
                                }
                            </button>
                            <Link
                                href={r('admin.categories.index')}
                                className="bg-gray-100 text-gray-600 text-sm font-semibold px-5 py-2.5 rounded-lg no-underline hover:bg-gray-200 transition"
                            >
                                Batal
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </AdminLayout>
    );
}
