# 🌿 Parigi Marketplace

Marketplace lokal Kecamatan Parigi, Pangandaran - menghubungkan petani, nelayan, dan pengrajin lokal dengan pembeli.

Built with **Laravel 12 + Inertia.js + React (TypeScript)** + **Midtrans** untuk pembayaran.

---

## Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12, PHP 8.2+ |
| Frontend | React 19 + TypeScript + Inertia.js |
| Styling | Tailwind CSS v4 |
| Database | MySQL 8 |
| Payment | Midtrans Snap |
| Auth | Laravel Breeze (session-based, Inertia) |
| Build tool | Vite |

---

## Fitur Utama

**Publik**
- Beranda dengan data komoditas BPS Kec. Parigi
- Marketplace produk lokal - filter kategori, pencarian, pagination
- Detail produk dengan galeri gambar

**User (Pembeli)**
- Melihat katalog produk
- Keranjang belanja (add, update qty, hapus)
- Checkout dengan pilihan metode pengiriman & pembayaran
- Pembayaran online via Midtrans Snap (VA, QRIS, kartu kredit, dll)
- Pembayaran tunai (cash on delivery / ambil di toko)
- Riwayat & detail pesanan
- Bayar ulang pesanan yang masih `pending_payment`

**Admin**
- Dashboard dengan chart penjualan harian & bulanan (data real dari DB)
- CRUD produk & kategori
- Kelola pesanan + update status
- Kelola pengguna
- Laporan penjualan & keuangan

---

## Requirements

- PHP >= 8.2
- Composer
- Node.js >= 20
- MySQL 8+

---

## Installation

```bash
# 1. Clone
git clone https://github.com/your-username/parigi-marketplace.git
cd parigi-marketplace

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi environment.env
# cek `Environment Variables'`dibawah

# 5. Migrate & seed
php artisan migrate
php artisan db:seed

# 6. Storage link (untuk gambar produk)
php artisan storage:link

# 7. Build assets
npm run dev
# atau untuk production:
npm run build

# 8. Jalankan server
php artisan serve
```

---

## Environment Variables

```env
# App
APP_NAME="Parigi Marketplace"
APP_URL=your_app_url

# Database
DB_CONNECTION=mysql
DB_DATABASE=parigi_marketplace
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Midtrans
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true

# Expose ke Vite (frontend)
VITE_MIDTRANS_CLIENT_KEY="${MIDTRANS_CLIENT_KEY}"
VITE_MIDTRANS_IS_PRODUCTION="${MIDTRANS_IS_PRODUCTION}"
```

> Untuk development lokal dengan Midtrans webhook, gunakan **ngrok**:
> ```bash
> ngrok http your_port
> # Set URL ngrok ke Midtrans Dashboard → Settings → Configuration → Payment Notification URL
> ```

---

## Folder Structure

```
app/
├── Http/Controllers/           # Controller (routing + response)
│   └── Admin/                  # Controller khusus admin
├── Services/                   # Interface service
│   ├── Implements/             # Implementasi service (public)
│   └── Admin/
│       └── Implements/         # Implementasi service (admin)
├── Repositories/               # Query DB (public)
│   └── Admin/                  # Query DB (admin)
└── Models/                     # Eloquent models

resources/js/
├── Layouts/
│   ├── MainLayout.tsx          # Layout publik + navbar
│   └── AdminLayout.tsx         # Layout admin + sidebar collapsible
├── pages/
│   ├── Auth/                   # Login, Register, dll
│   ├── Cart/                   # Keranjang
│   ├── Checkout/               # Checkout + Midtrans
│   ├── Orders/                 # Riwayat & detail pesanan
│   ├── Products/               # Marketplace publik
│   ├── Admin/
│   │   ├── Dashboard.tsx
│   │   ├── Products/
│   │   ├── Orders/
│   │   ├── Users/
│   │   ├── Categories/
│   │   └── Reports/
│   └── Welcome.tsx             # Beranda
```

---

## Seeder

```bash
php artisan db:seed --class=KategoriSeeder
php artisan db:seed --class=MetodePengirimanSeeder
php artisan db:seed --class=MetodePembayaranSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ProdukSeeder
```

---

## Testing Midtrans Sandbox

| Metode | Detail |
|---|---|
| Kartu Kredit | `4811 1111 1111 1114` / CVV: `123` / Exp: `01/25` / OTP: `112233` |
| BCA Virtual Account | Bayar via [simulator](https://simulator.sandbox.midtrans.com/) |
| QRIS | Scan → auto success di sandbox |

---

<!-- ## License

MIT -->
