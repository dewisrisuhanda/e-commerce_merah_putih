<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Parigi Market Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        :root {
            --green-900: #0d4a1e;
            --green-700: #1a7c36;
            --green-600: #22a046;
            --green-500: #2dc653;
            --green-50: #edfff3;
            --green-100: #d4f5de;
            --teal-100: #ccf0eb;
            --teal-600: #0f7a6e;
            --amber-100: #fef3c7;
            --amber-600: #b45309;
            --red-600: #dc2626;
            --red-100: #fee2e2;
            --blue-100: #dbeafe;
            --blue-600: #1d4ed8;
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

        /* SIDEBAR */
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
            overflow-y: auto;
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

        /* MAIN */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            min-width: 0;
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

        .topbar-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--gray-50);
            border: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            text-decoration: none;
        }

        .content {
            padding: 28px;
        }

        /* STAT CARDS */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid var(--gray-100);
        }

        .sc-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .sc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .sc-icon.green {
            background: var(--green-50);
        }

        .sc-icon.teal {
            background: var(--teal-100);
        }

        .sc-icon.amber {
            background: var(--amber-100);
        }

        .sc-icon.blue {
            background: var(--blue-100);
        }

        .sc-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 6px;
            background: var(--green-50);
            color: var(--green-700);
        }

        .sc-val {
            font-family: var(--font-head);
            font-size: 24px;
            font-weight: 700;
            line-height: 1;
        }

        .sc-label {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .sc-trend {
            font-size: 11px;
            margin-top: 8px;
            color: var(--green-600);
        }

        /* ROW LAYOUTS */
        .row-half {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .row-main {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        /* CARDS */
        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--gray-100);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 18px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--gray-100);
        }

        .card-title {
            font-family: var(--font-head);
            font-size: 14px;
            font-weight: 700;
        }

        .card-subtitle {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 2px;
        }

        .card-body {
            padding: 20px;
        }

        .btn-sm {
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            background: var(--gray-50);
            color: var(--gray-700);
            text-decoration: none;
            display: inline-block;
        }

        .btn-add {
            background: var(--green-600);
            color: #fff;
            border-color: var(--green-600);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
        }

        /* TABLE */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 16px;
            border-bottom: 1px solid var(--gray-100);
            text-align: left;
            background: var(--gray-50);
        }

        .data-table td {
            padding: 11px 16px;
            border-bottom: 1px solid var(--gray-50);
            font-size: 13px;
            vertical-align: middle;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-table tr:hover td {
            background: var(--gray-50);
        }

        .prod-thumb {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--green-50);
            border: 1px solid var(--green-100);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* STATUS PILLS */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .pill-green {
            background: var(--green-50);
            color: var(--green-700);
        }

        .pill-red {
            background: var(--red-100);
            color: var(--red-600);
        }

        .pill-amber {
            background: var(--amber-100);
            color: var(--amber-600);
        }

        .pill-blue {
            background: var(--blue-100);
            color: var(--blue-600);
        }

        .pill-teal {
            background: var(--teal-100);
            color: var(--teal-600);
        }

        .dot-s {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* AKTIVITAS */
        .act-item {
            display: flex;
            gap: 12px;
            padding: 11px 0;
            border-bottom: 1px solid var(--gray-50);
        }

        .act-item:last-child {
            border-bottom: none;
        }

        .act-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        /* DONUT LEGEND */
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* KATEGORI MINI CARDS */
        .kat-mini-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 12px;
        }

        .kat-mini {
            padding: 10px 12px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--gray-100);
        }

        .kat-mini-num {
            margin-left: auto;
            font-family: var(--font-head);
            font-size: 18px;
            font-weight: 700;
            color: var(--green-600);
        }

        /* ORDER TABLE */
        .order-id {
            font-family: monospace;
            font-size: 12px;
            font-weight: 600;
            color: var(--green-700);
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-text">
                <div class="logo-icon">🛒</div>Parigi Market
            </div>
            <div class="logo-sub">ADMIN PANEL</div>
        </div>
        <nav class="sidebar-nav">
            <div class="nav-section">Utama</div>
            <a href="<?= base_url('admin') ?>" class="nav-item active">📊 Dashboard</a>
            <a href="<?= base_url('admin/produk') ?>" class="nav-item">📦 Produk</a>
            <a href="<?= base_url('admin/pesanan') ?>" class="nav-item">🛍️ Pesanan</a>
            <div class="nav-section">Kelola</div>
            <a href="<?= base_url('admin/kelola/pengguna') ?>" class="nav-item">👥 Pengguna</a>
            <a href="<?= base_url('admin/kelola/kategori') ?>" class="nav-item">🏷️ Kategori</a>
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

    <!-- MAIN -->
    <div class="main">
        <div class="topbar">
            <div>
                <div class="page-title">Dashboard</div>
                <div class="breadcrumb">Parigi Market → Admin → Dashboard</div>
            </div>
            <div style="display:flex;align-items:center;gap:12px">
                <span style="font-size:12px;color:var(--gray-500)"><?= date('l, d F Y') ?></span>
                <a href="<?= base_url('/') ?>" class="topbar-btn" title="Lihat Toko">🏪</a>
                <a href="<?= base_url('logout') ?>" class="topbar-btn" title="Keluar">🚪</a>
            </div>
        </div>

        <div class="content">

            <!-- STAT CARDS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="sc-top">
                        <div class="sc-icon green">💰</div>
                        <div class="sc-badge">Bulan ini</div>
                    </div>
                    <div class="sc-val">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></div>
                    <div class="sc-label">Total Pendapatan</div>
                    <div class="sc-trend">↑ Dari pesanan selesai</div>
                </div>
                <div class="stat-card">
                    <div class="sc-top">
                        <div class="sc-icon teal">🛍️</div>
                        <div class="sc-badge">Total</div>
                    </div>
                    <div class="sc-val"><?= $total_pesanan ?? 0 ?></div>
                    <div class="sc-label">Total Pesanan</div>
                    <div class="sc-trend">↑ Semua waktu</div>
                </div>
                <div class="stat-card">
                    <div class="sc-top">
                        <div class="sc-icon green">📦</div>
                        <div class="sc-badge">Aktif</div>
                    </div>
                    <div class="sc-val"><?= $total_produk ?? 0 ?></div>
                    <div class="sc-label">Total Produk</div>
                    <div class="sc-trend">↑ Di semua kategori</div>
                </div>
                <div class="stat-card">
                    <div class="sc-top">
                        <div class="sc-icon amber">👥</div>
                        <div class="sc-badge">Terdaftar</div>
                    </div>
                    <div class="sc-val"><?= $total_user ?? 0 ?></div>
                    <div class="sc-label">Total Pembeli</div>
                    <div class="sc-trend">↑ Pengguna aktif</div>
                </div>
            </div>

            <!-- GRAFIK + DONUT -->
            <div class="row-half">
                <div class="card" style="margin-bottom:0">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Grafik Penjualan Harian</div>
                            <div class="card-subtitle">7 hari terakhir (Rp)</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="chartPenjualan" height="140"></canvas>
                    </div>
                </div>

                <div class="card" style="margin-bottom:0">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Penjualan per Kategori</div>
                            <div class="card-subtitle">Berdasarkan produk</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div style="display:flex;align-items:center;gap:20px">
                            <canvas id="chartKategori" width="110" height="110" style="flex-shrink:0;width:110px;height:110px"></canvas>
                            <div style="flex:1">
                                <?php
                                $warna = ['Hasil Laut' => '#22a046', 'Hasil Tani' => '#2dc653', 'Oleh-oleh' => '#d4f5de', 'Buah-buahan' => '#fef3c7', 'Rempah' => '#fee2e2', 'Produk Olahan' => '#6b7280'];
                                foreach ($kat_counts ?? [] as $nama => $jml):
                                    $w = $warna[$nama] ?? '#ccc';
                                ?>
                                    <div class="legend-item">
                                        <div class="legend-dot" style="background:<?= $w ?>"></div>
                                        <span style="font-size:12px;color:var(--gray-700)"><?= esc($nama) ?></span>
                                        <span style="margin-left:auto;font-size:12px;font-weight:600"><?= $jml ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="kat-mini-grid">
                            <div class="kat-mini" style="background:var(--green-50)"><span style="font-size:18px">🌾</span>
                                <div>
                                    <div style="font-size:11px;font-weight:600">Hasil Tani</div>
                                    <div style="font-size:10px;color:var(--gray-500)"><?= ($kat_counts['Hasil Tani'] ?? 0) ?> produk</div>
                                </div>
                                <div class="kat-mini-num"><?= $kat_counts['Hasil Tani'] ?? 0 ?></div>
                            </div>
                            <div class="kat-mini" style="background:#f0fdfa"><span style="font-size:18px">🐟</span>
                                <div>
                                    <div style="font-size:11px;font-weight:600">Hasil Laut</div>
                                    <div style="font-size:10px;color:var(--gray-500)"><?= ($kat_counts['Hasil Laut'] ?? 0) ?> produk</div>
                                </div>
                                <div class="kat-mini-num"><?= $kat_counts['Hasil Laut'] ?? 0 ?></div>
                            </div>
                            <div class="kat-mini" style="background:#fefce8"><span style="font-size:18px">🎁</span>
                                <div>
                                    <div style="font-size:11px;font-weight:600">Oleh-oleh</div>
                                    <div style="font-size:10px;color:var(--gray-500)"><?= ($kat_counts['Oleh-oleh'] ?? 0) ?> produk</div>
                                </div>
                                <div class="kat-mini-num"><?= $kat_counts['Oleh-oleh'] ?? 0 ?></div>
                            </div>
                            <div class="kat-mini" style="background:#fff7ed"><span style="font-size:18px">🌶️</span>
                                <div>
                                    <div style="font-size:11px;font-weight:600">Rempah</div>
                                    <div style="font-size:10px;color:var(--gray-500)"><?= ($kat_counts['Rempah'] ?? 0) ?> produk</div>
                                </div>
                                <div class="kat-mini-num"><?= $kat_counts['Rempah'] ?? 0 ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRODUK + AKTIVITAS -->
            <div class="row-main">
                <div class="card" style="margin-bottom:0">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Daftar Produk</div>
                            <div class="card-subtitle">Stok paling sedikit (perlu restok)</div>
                        </div>
                        <a href="<?= base_url('admin/produk/tambah') ?>" class="btn-add">+ Tambah</a>
                    </div>
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produk_terlaris)): foreach ($produk_terlaris as $p):
                                    $ikon = match ($p['kategori'] ?? '') {
                                        'Hasil Laut' => '🐟',
                                        'Oleh-oleh' => '🎁',
                                        'Buah-buahan' => '🍈',
                                        'Rempah' => '🌶️',
                                        default => '🌾'
                                    };
                            ?>
                                    <tr>
                                        <td>
                                            <div style="display:flex;align-items:center;gap:10px">
                                                <div class="prod-thumb"><?= $ikon ?></div>
                                                <div>
                                                    <div style="font-size:13px;font-weight:600"><?= esc($p['nama_produk']) ?></div>
                                                    <div style="font-size:11px;color:var(--gray-500)"><?= esc($p['kategori'] ?? 'Umum') ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="font-weight:600;color:var(--green-700)">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                        <td style="<?= $p['stok'] < 20 ? 'color:var(--red-600);font-weight:700' : '' ?>"><?= $p['stok'] ?></td>
                                        <td><a href="<?= base_url('admin/produk/edit/' . $p['id_produk']) ?>" class="btn-sm">Edit</a></td>
                                    </tr>
                                <?php endforeach;
                            else: ?>
                                <tr>
                                    <td colspan="4" style="text-align:center;color:var(--gray-500);padding:24px">Belum ada produk</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div style="padding:12px 16px"><a href="<?= base_url('admin/produk') ?>" class="btn-sm">Lihat Semua Produk →</a></div>
                </div>

                <div class="card" style="margin-bottom:0">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Pesanan Terbaru</div>
                            <div class="card-subtitle">Update terkini</div>
                        </div>
                    </div>
                    <div style="padding:8px 20px 0">
                        <?php if (!empty($pesanan_terbaru)): foreach (array_slice($pesanan_terbaru, 0, 6) as $o):
                                $sc = match ($o['status'] ?? 'pending') {
                                    'selesai' => 'pill-green',
                                    'dikirim' => 'pill-blue',
                                    'diproses' => 'pill-teal',
                                    'dibatalkan' => 'pill-red',
                                    default => 'pill-amber'
                                };
                        ?>
                                <div class="act-item">
                                    <div class="act-icon" style="background:var(--green-50)">🛍️</div>
                                    <div style="flex:1">
                                        <div style="font-size:13px;font-weight:600"><?= esc($o['nama'] ?? 'Pembeli') ?></div>
                                        <div style="font-size:12px;color:var(--gray-500)">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></div>
                                        <div style="margin-top:4px">
                                            <span class="status-pill <?= $sc ?>"><span class="dot-s"></span><?= ucfirst($o['status'] ?? 'pending') ?></span>
                                        </div>
                                        <div style="font-size:11px;color:var(--gray-400);margin-top:2px"><?= date('d M Y H:i', strtotime($o['tanggal'] ?? 'now')) ?></div>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <div style="text-align:center;padding:24px;color:var(--gray-500)">Belum ada pesanan</div>
                        <?php endif; ?>
                    </div>
                    <div style="padding:12px 20px"><a href="<?= base_url('admin/pesanan') ?>" class="btn-sm">Lihat Semua Pesanan →</a></div>
                </div>
            </div>

            <!-- TABEL PESANAN TERBARU -->
            <div class="card">
                <div class="card-header">
                    <div>
                        <div class="card-title">Pesanan Terbaru</div>
                        <div class="card-subtitle">5 pesanan terakhir masuk</div>
                    </div>
                    <a href="<?= base_url('admin/pesanan') ?>" class="btn-sm">Lihat Semua</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesanan_terbaru)): foreach (array_slice($pesanan_terbaru, 0, 5) as $o):
                                $sc = match ($o['status'] ?? 'pending') {
                                    'selesai' => 'pill-green',
                                    'dikirim' => 'pill-blue',
                                    'diproses' => 'pill-teal',
                                    'dibatalkan' => 'pill-red',
                                    'dibayar' => 'pill-blue',
                                    default => 'pill-amber'
                                };
                        ?>
                                <tr>
                                    <td><span class="order-id">#<?= $o['id_pesanan'] ?></span></td>
                                    <td>
                                        <div style="font-weight:600"><?= esc($o['nama'] ?? 'Pembeli') ?></div>
                                        <div style="font-size:11px;color:var(--gray-500)"><?= esc($o['alamat'] ?? '') ?></div>
                                    </td>
                                    <td style="font-weight:600;color:var(--green-700)">Rp <?= number_format($o['total_harga'], 0, ',', '.') ?></td>
                                    <td style="color:var(--gray-500)"><?= ucfirst($o['metode_bayar'] ?? 'cash') ?></td>
                                    <td><span class="status-pill <?= $sc ?>"><span class="dot-s"></span><?= ucfirst($o['status'] ?? 'pending') ?></span></td>
                                    <td style="font-size:12px;color:var(--gray-500)"><?= date('d M Y', strtotime($o['tanggal'] ?? 'now')) ?></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" style="text-align:center;color:var(--gray-500);padding:24px">Belum ada pesanan</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        new Chart(document.getElementById('chartPenjualan'), {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    data: [520000, 740000, 960000, 680000, 1100000, 800000, 890000],
                    backgroundColor: ['#d4f5de', '#d4f5de', '#22a046', '#22a046', '#22a046', '#d4f5de', '#22a046'],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID')
                        }
                    }
                },
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: true
            }
        });

        new Chart(document.getElementById('chartKategori'), {
            type: 'doughnut',
            data: {
                labels: ['Hasil Laut', 'Hasil Tani', 'Oleh-oleh', 'Lainnya'],
                datasets: [{
                    data: [
                        <?= $kat_counts['Hasil Laut'] ?? 0 ?>,
                        <?= $kat_counts['Hasil Tani'] ?? 0 ?>,
                        <?= $kat_counts['Oleh-oleh'] ?? 0 ?>,
                        <?= ($kat_counts['Rempah'] ?? 0) + ($kat_counts['Buah-buahan'] ?? 0) + ($kat_counts['Produk Olahan'] ?? 0) ?>
                    ],
                    backgroundColor: ['#22a046', '#2dc653', '#d4f5de', '#6b7280'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '68%',
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: false
            }
        });
    </script>
</body>

</html>