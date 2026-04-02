<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Kategori — Parigi Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-900: #0d4a1e;
            --green-700: #1a7c36;
            --green-600: #22a046;
            --green-500: #2dc653;
            --green-50: #edfff3;
            --green-100: #d4f5de;
            --amber-100: #fef3c7;
            --gray-900: #111827;
            --gray-500: #6b7280;
            --gray-100: #f3f4f6;
            --gray-50: #f9fafb;
            --bg: #f0f7f2;
            --sidebar-w: 240px;
            --font-body: "Plus Jakarta Sans", sans-serif;
            --font-head: "Sora", sans-serif;
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

        .logo-sub {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.45);
            margin-top: 3px;
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
        }

        .kat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .kat-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--gray-100);
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .kat-icon {
            font-size: 36px;
            flex-shrink: 0;
        }

        .kat-name {
            font-family: var(--font-head);
            font-size: 15px;
            font-weight: 700;
        }

        .kat-count {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .kat-num {
            margin-left: auto;
            font-family: var(--font-head);
            font-size: 32px;
            font-weight: 700;
            color: var(--green-600);
        }
    </style>
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">
                <div class="logo-icon">🛒</div>Parigi Market
            </div>
            <div class="logo-sub">ADMIN PANEL</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Utama</div>
            <a href="<?= base_url('admin') ?>" class="nav-item">📊 Dashboard</a>
            <a href="<?= base_url('admin/produk') ?>" class="nav-item">📦 Produk</a>
            <a href="<?= base_url('admin/pesanan') ?>" class="nav-item">🛍️ Pesanan</a>
            <div class="nav-section">Kelola</div>
            <a href="<?= base_url('admin/kelola/pengguna') ?>" class="nav-item">👥 Pengguna</a>
            <a href="<?= base_url('admin/kelola/kategori') ?>" class="nav-item active">🏷️ Kategori</a>
            <div class="nav-section">Laporan</div>
            <a href="<?= base_url('admin/laporan/penjualan') ?>" class="nav-item">📈 Penjualan</a>
            <a href="<?= base_url('admin/laporan/keuangan') ?>" class="nav-item">💰 Keuangan</a>
            <div class="nav-section">Sistem</div>
            <a href="<?= base_url('/') ?>" class="nav-item">🏪 Lihat Toko</a>
            <a href="<?= base_url('logout') ?>" class="nav-item">🚪 Keluar</a>
        </nav>
        <div class="sidebar-user">
            <div class="avatar"><?= strtoupper(substr(session()->get('nama') ?? 'A', 0, 2)) ?></div>
            <div>
                <div style="font-size:13px;font-weight:600;color:#fff"><?= esc(session()->get('nama')) ?></div>
                <div style="font-size:11px;color:rgba(255,255,255,0.45)">Super Admin</div>
            </div>
        </div>
    </aside>
    <div class="main">
        <div class="topbar">
            <div>
                <div class="page-title">Kelola Kategori</div>
                <div class="breadcrumb">Admin → Kelola → Kategori</div>
            </div>
        </div>
        <div class="content">
            <div class="kat-grid">
                <?php
                $daftarKat = [
                    ['nama' => 'Hasil Tani',    'ikon' => '🌾', 'bg' => '#edfff3'],
                    ['nama' => 'Hasil Laut',    'ikon' => '🐟', 'bg' => '#f0fdfa'],
                    ['nama' => 'Oleh-oleh',     'ikon' => '🎁', 'bg' => '#fefce8'],
                    ['nama' => 'Buah-buahan',   'ikon' => '🍈', 'bg' => '#fff7ed'],
                    ['nama' => 'Rempah',        'ikon' => '🌶️', 'bg' => '#fef2f2'],
                    ['nama' => 'Produk Olahan', 'ikon' => '🏭', 'bg' => '#f8fafc'],
                ];
                foreach ($daftarKat as $k):
                    $count = $kat_counts[$k['nama']] ?? 0;
                ?>
                    <div class="kat-card" style="background:<?= $k['bg'] ?>">
                        <div class="kat-icon"><?= $k['ikon'] ?></div>
                        <div>
                            <div class="kat-name"><?= $k['nama'] ?></div>
                            <div class="kat-count"><?= $count ?> produk</div>
                        </div>
                        <div class="kat-num"><?= $count ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>