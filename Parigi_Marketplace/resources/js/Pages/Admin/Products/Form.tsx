import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import AdminLayout from '@/Layouts/AdminLayout';

interface Category { id: number; name: string; slug: string; }

interface ProductData {
    id?: number;
    slug?: string;
    name: string;
    category_id: number | '';
    price: number | '';
    quantity: number | '';
    description: string;
    status: string;
    image_url: string;
}

interface FormProps {
    product?: ProductData;
    categories: Category[];
}

export default function Form({ product, categories }: FormProps) {
    const isEdit = !!product?.id;
    const render = (name: string, params?: any) => route().has(name) ? route(name, params) : '#';

    const { data, setData, post, put, processing, errors } = useForm({
        name:        product?.name        ?? '',
        category_id: product?.category_id ?? '' as number | '',
        price:       product?.price       ?? '' as number | '',
        quantity:    product?.quantity    ?? '' as number | '',
        description: product?.description ?? '',
        status:      product?.status      ?? 'ready',
        image_url:   product?.image_url   ?? '',
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        if (isEdit) {
            put(render('admin.products.update', product!.slug));
        } else {
            post(render('admin.products.store'));
        }
    };

    const inputCls = (field: string) =>
        `w-full px-3.5 py-2.5 border rounded-lg text-sm text-gray-900 transition focus:outline-none focus:ring-2 focus:ring-[#2dc653]/20 focus:border-[#2dc653] ${(errors as any)[field] ? 'border-red-400 bg-red-50' : 'border-gray-300 bg-white'}`;

    return (
        <AdminLayout
            title={isEdit ? 'Edit Produk' : 'Tambah Produk'}
    breadcrumb={`Admin → Produk → ${isEdit ? 'Edit' : 'Tambah'}`}
    activeMenu="products"
    >
    <Head title={`${isEdit ? 'Edit' : 'Tambah'} Produk`} />

    <div className="max-w-2xl">
    <div className="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div className="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
    <div className="font-bold text-sm text-gray-900" style={{ fontFamily: "'Sora', sans-serif" }}>
    {isEdit ? '✏️ Edit Data Produk' : '➕ Tambah Produk Baru'}
    </div>
    <Link href={render('admin.products.index')} className="text-xs text-gray-500 border border-gray-200 px-3 py-1.5 rounded-lg no-underline hover:bg-gray-50 transition">
                            ← Kembali
    </Link>
    </div>

    <form onSubmit={submit} className="p-6 space-y-5">
    {/* Name */}
    <div>
    <label className="block text-xs font-semibold text-gray-600 mb-1.5">Nama Produk <span className="text-red-500">*</span></label>
    <input type="text" value={data.name} onChange={e => setData('name', e.target.value)} className={inputCls('name')} placeholder="Contoh: Kapulaga Segar" required />
    {errors.name && <p className="mt-1 text-xs text-red-500">{errors.name}</p>}
            </div>

    {/* Category */}
    <div>
        <label className="block text-xs font-semibold text-gray-600 mb-1.5">Kategori <span className="text-red-500">*</span></label>
    <select value={data.category_id} onChange={e => setData('category_id', Number(e.target.value))} className={inputCls('category_id')} required>
    <option value="">-- Pilih Kategori --</option>
    {categories.map(cat => (
        <option key={cat.id} value={cat.id}>{cat.name}</option>
    ))}
    </select>
    {errors.category_id && <p className="mt-1 text-xs text-red-500">{errors.category_id}</p>}
        </div>

        {/* Price + Quantity */}
        <div className="grid grid-cols-2 gap-4">
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1.5">Harga (Rp) <span className="text-red-500">*</span></label>
    <input type="number" value={data.price} onChange={e => setData('price', Number(e.target.value))} className={inputCls('price')} placeholder="35000" min={0} required />
    {errors.price && <p className="mt-1 text-xs text-red-500">{errors.price}</p>}
        </div>
        <div>
        <label className="block text-xs font-semibold text-gray-600 mb-1.5">Stok <span className="text-red-500">*</span></label>
    <input type="number" value={data.quantity} onChange={e => setData('quantity', Number(e.target.value))} className={inputCls('quantity')} placeholder="100" min={0} required />
    {errors.quantity && <p className="mt-1 text-xs text-red-500">{errors.quantity}</p>}
            </div>
            </div>

        {/* Status */}
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1.5">Status</label>
            <select value={data.status} onChange={e => setData('status', e.target.value)} className={inputCls('status')}>
        <option value="ready">Aktif (Ready)</option>
            <option value="out_of_stock">Stok Habis</option>
    <option value="discontinued">Dihentikan</option>
        </select>
        </div>

        {/* Description */}
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1.5">Deskripsi</label>
            <textarea value={data.description} onChange={e => setData('description', e.target.value)} className={`${inputCls('description')} resize-y min-h-[100px]`} placeholder="Deskripsikan produk..." />
        </div>

        {/* Image URL */}
        <div>
            <label className="block text-xs font-semibold text-gray-600 mb-1.5">URL Foto Produk</label>
    <input type="text" value={data.image_url} onChange={e => setData('image_url', e.target.value)} className={inputCls('image_url')} placeholder="https://..." />
    <p className="mt-1 text-xs text-gray-400">Masukkan URL gambar dari internet, atau kosongkan jika tidak ada.</p>
        {data.image_url && (
            <img src={data.image_url} alt="Preview" className="mt-2 w-24 h-24 rounded-xl object-cover border border-gray-100" onError={e => { (e.target as HTMLImageElement).style.display = 'none'; }} />
        )}
        </div>

        {/* Buttons */}
        <div className="flex gap-3 pt-2">
        <button type="submit" disabled={processing} className="bg-[#22a046] text-white text-sm font-semibold px-5 py-2.5 rounded-lg border-none cursor-pointer hover:bg-[#1a7c36] transition disabled:opacity-60">
        {processing ? 'Menyimpan...' : isEdit ? '💾 Simpan Perubahan' : '➕ Tambah Produk'}
        </button>
        <Link href={render('admin.products.index')} className="bg-gray-100 text-gray-600 text-sm font-semibold px-5 py-2.5 rounded-lg no-underline hover:bg-gray-200 transition">
        Batal
        </Link>
        </div>
        </form>
        </div>
        </div>
        </AdminLayout>
    );
    }
