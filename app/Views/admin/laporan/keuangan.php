<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Keuangan — Parigi Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green-900: #0d4a1e;
            --green-700: #1a7c36;
            --green-600: #22a046;
            --green-500: #2dc653;
            --green-50: #edfff3;
            --amber-100: #fef3c7;
            --amber-600: #b45309;
            --red-600: #dc2626;
            --red-100: #fee2e2;
            --blue-100: #dbeafe;
            --blue-600: #1d4ed8;
            --teal-100: #ccf0eb;
            --teal-600: #0f7a6e;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 20px;
            border: 1px solid var(--gray-100);
        }

        .sc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
        }

        .sc-icon.green {
            background: var(--green-50);
        }

        .sc-icon.amber {
            background: var(--amber-100);
        }

        .sc-icon.red {
            background: var(--red-100);
        }

        .sc-val {
            font-family: var(--font-head);
            font-size: 22px;
            font-weight: 700;
        }

        .sc-label {
            font-size: 12px;
            color: var(--gray-500);
            margin-top: 4px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid var(--gray-100);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid var(--gray-100);
        }

        .card-title {
            font-family: var(--font-head);
            font-size: 14px;
            font-weight: 700;
        }

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
            padding: 12px 16px;
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

        .pill {
            display: inline-flex;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .pill-green {
            background: var(--green-50);
            color: var(--green-700);
        }

        .pill-amber {
            background: var(--amber-100);
            color: var(--amber-600);
        }

        .pill-red {
            background: var(--red-100);
            color: var(--red-600);
        }

        .pill-blue {
            background: var(--blue-100);
            color: var(--blue-600);
        }

        .pill-teal {
            background: var(--teal-100);
            color: var(--teal-600);
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
            <a href="<?= base_url('admin/kelola/kategori') ?>" class="nav-item">🏷️ Kategori</a>
            <div class="nav-section">Laporan</div>
            <a href="<?= base_url('admin/laporan/penjualan') ?>" class="nav-item">📈 Penjualan</a>
            <a href="<?= base_url('admin/laporan/keuangan') ?>" class="nav-item active">💰 Keuangan</a>
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
                <div class="page-title">Laporan Keuangan</div>
                <div class="breadcrumb">Admin → Laporan → Keuangan</div>
            </div>
        </div>
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="sc-icon green">💰</div>
                    <div class="sc-val">Rp <?= number_format($total_masuk ?? 0, 0, ',', '.') ?></div>
                    <div class="sc-label">Total Pemasukan</div>
                </div>
                <div class="stat-card">
                    <div class="sc-icon amber">⏳</div>
                    <div class="sc-val"><?= $total_pending ?? 0 ?></div>
                    <div class="sc-label">Pesanan Pending</div>
                </div>
                <div class="stat-card">
                    <div class="sc-icon red">❌</div>
                    <div class="sc-val"><?= $total_batal ?? 0 ?></div>
                    <div class="sc-label">Pesanan Dibatalkan</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">💳 Riwayat Transaksi</div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pembeli</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Metode Kirim</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($pesanan_list)): foreach ($pesanan_list as $p):
                                $sc = $p['status'] === 'selesai' ? 'pill-green' : ($p['status'] === 'dikirim' ? 'pill-blue' : ($p['status'] === 'diproses' ? 'pill-teal' : ($p['status'] === 'dibatalkan' ? 'pill-red' : 'pill-amber')));
                        ?>
                                <tr>
                                    <td style="font-family:monospace;font-size:12px;color:var(--green-700)">#<?= $p['id_pesanan'] ?></td>
                                    <td style="font-weight:600"><?= esc($p['nama'] ?? '-') ?></td>
                                    <td style="font-weight:600;color:var(--green-700)">Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
                                    <td style="color:var(--gray-500)"><?= ucfirst($p['metode_bayar'] ?? 'cash') ?></td>
                                    <td style="color:var(--gray-500)"><?= isset($p['metode_kirim']) && $p['metode_kirim'] === 'ambil' ? '🏪 Ambil' : '🚚 Antar' ?></td>
                                    <td><span class="pill <?= $sc ?>"><?= ucfirst($p['status']) ?></span></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="6" style="text-align:center;padding:24px;color:var(--gray-500)">Belum ada transaksi</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>