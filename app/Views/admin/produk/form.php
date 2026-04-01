<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $produk ? 'Edit Produk' : 'Tambah Produk' ?> — Parigi Market</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-900: #0d4a1e;
            --green-700: #1a7c36;
            --green-600: #22a046;
            --green-500: #2dc653;
            --green-50: #edfff3;
            --green-100: #d4f5de;
            --red-600: #dc2626;
            --red-100: #fee2e2;
            --gray-900: #111827;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-300: #d1d5db;
            --gray-100: #f3f4f6;
            --gray-50: #f9fafb;
            --bg: #f0f7f2;
            --sidebar-w: 240px;
            --font-body: 'Plus Jakarta Sans', sans-serif;
            --font-head: 'Sora', sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            background: var(--bg);
            color: var(--gray-900);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
        }

        .sidebar {
            width: var(--sidebar-w);
            background: var(--green-900);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-text {
            font-family: var(--font-head);
            font-size: 18px;
            font-weight: 700;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background: var(--green-500);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
        }

        .sidebar-nav {
            padding: 16px 0;
            flex: 1;
        }

        .nav-section {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 0.1em;
            padding: 12px 20px 6px;
            text-transform: uppercase;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.65);
            font-size: 13.5px;
            font-weight: 500;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(45, 198, 83, 0.15);
            color: var(--green-500);
            border-left-color: var(--green-500);
        }

        .sidebar-user {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--green-600);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
        }

        .topbar {
            background: #fff;
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-100);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-title {
            font-family: var(--font-head);
            font-size: 16px;
            font-weight: 700;
        }

        .breadcrumb {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 1px;
        }

        .content {
            padding: 28px;
            max-width: 760px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--gray-100);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--gray-100);
        }

        .card-title {
            font-family: var(--font-head);
            font-size: 15px;
            font-weight: 700;
        }

        .card-body {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 6px;
        }

        .form-label span {
            color: var(--red-600);
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 14px;
            font-family: var(--font-body);
            color: var(--gray-900);
            transition: border-color 0.15s;
            background: #fff;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--green-500);
            box-shadow: 0 0 0 3px rgba(45, 198, 83, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        select.form-control {
            cursor: pointer;
        }

        .form-hint {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .foto-preview {
            margin-top: 10px;
        }

        .foto-preview img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid var(--gray-100);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-family: var(--font-body);
            transition: all 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-primary {
            background: var(--green-600);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--green-700);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
        }

        .alert-error {
            background: var(--red-100);
            color: var(--red-600);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: var(--green-50);
            color: var(--green-700);
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">
                <div class="logo-icon">🛒</div>Parigi Market
            </div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Utama</div>
            <a href="<?= base_url('admin') ?>" class="nav-item">📊 Dashboard</a>
            <a href="<?= base_url('admin/produk') ?>" class="nav-item active">📦 Produk</a>
            <a href="<?= base_url('admin/pesanan') ?>" class="nav-item">🛍️ Pesanan</a>
            <div class="nav-section">Sistem</div>
            <a href="<?= base_url('/') ?>" class="nav-item">🏪 Lihat Toko</a>
            <a href="<?= base_url('logout') ?>" class="nav-item">🚪 Keluar</a>
        </nav>
        <div class="sidebar-user">
            <div class="avatar"><?= strtoupper(substr(session()->get('nama') ?? 'A', 0, 2)) ?></div>
            <div>
                <div style="font-size:13px;font-weight:600;color:#fff"><?= esc(session()->get('nama')) ?></div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45)">Admin</div>
            </div>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <div>
                <div class="page-title"><?= $produk ? 'Edit Produk' : 'Tambah Produk' ?></div>
                <div class="breadcrumb">Admin → Produk → <?= $produk ? 'Edit' : 'Tambah' ?></div>
            </div>
            <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">← Kembali</a>
        </div>

        <div class="content">

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (isset($errors)): ?>
                <div class="alert-error">
                    <?php foreach ($errors as $e): ?><div>• <?= esc($e) ?></div><?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <div class="card-title"><?= $produk ? '✏️ Edit Data Produk' : '➕ Tambah Produk Baru' ?></div>
                </div>
                <div class="card-body">

                    <?php
                    $action = $produk
                        ? base_url('admin/produk/update/' . $produk['id_produk'])
                        : base_url('admin/produk/simpan');
                    ?>

                    <form action="<?= $action ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <!-- NAMA PRODUK -->
                        <div class="form-group">
                            <label class="form-label">Nama Produk <span>*</span></label>
                            <input type="text" name="nama_produk" class="form-control"
                                placeholder="Contoh: Ikan Tongkol Segar"
                                value="<?= esc($produk['nama_produk'] ?? old('nama_produk')) ?>" required>
                        </div>

                        <!-- KATEGORI -->
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <select name="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php
                                $kategoriList = ['Hasil Tani', 'Hasil Laut', 'Oleh-oleh', 'Buah-buahan', 'Rempah', 'Produk Olahan'];
                                foreach ($kategoriList as $kat):
                                    $sel = (($produk['kategori'] ?? old('kategori')) === $kat) ? 'selected' : '';
                                ?>
                                    <option value="<?= $kat ?>" <?= $sel ?>><?= $kat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- HARGA & STOK -->
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Harga (Rp) <span>*</span></label>
                                <input type="number" name="harga" class="form-control"
                                    placeholder="Contoh: 35000"
                                    value="<?= esc($produk['harga'] ?? old('harga')) ?>" required min="0">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stok <span>*</span></label>
                                <input type="number" name="stok" class="form-control"
                                    placeholder="Contoh: 100"
                                    value="<?= esc($produk['stok'] ?? old('stok')) ?>" required min="0">
                            </div>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="form-group">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control"
                                placeholder="Deskripsikan produk kamu..."><?= esc($produk['deskripsi'] ?? old('deskripsi')) ?></textarea>
                        </div>

                        <!-- FOTO -->
                        <div class="form-group">
                            <label class="form-label">Foto Produk</label>
                            <input type="text" name="foto" class="form-control"
                                placeholder="URL gambar (https://...) atau kosongkan"
                                value="<?= esc($produk['foto'] ?? old('foto')) ?>">
                            <div class="form-hint">Masukkan URL gambar dari internet, atau kosongkan jika tidak ada foto.</div>
                            <?php if (!empty($produk['foto'])): ?>
                                <div class="foto-preview">
                                    <img src="<?= substr($produk['foto'], 0, 4) === 'http' ? esc($produk['foto']) : base_url('uploads/produk/' . esc($produk['foto'])) ?>"
                                        onerror="this.style.display='none'">
                                    <div class="form-hint" style="margin-top:4px">Foto saat ini</div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TOMBOL -->
                        <div style="display:flex;gap:12px;margin-top:8px">
                            <button type="submit" class="btn btn-primary">
                                💾 <?= $produk ? 'Simpan Perubahan' : 'Tambah Produk' ?>
                            </button>
                            <a href="<?= base_url('admin/produk') ?>" class="btn btn-secondary">Batal</a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

</body>

</html>