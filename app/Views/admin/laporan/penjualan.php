<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan Penjualan — Parigi Admin</title>
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
            --amber-100: #fef3c7;
            --amber-600: #b45309;
            --red-600: #dc2626;
            --red-100: #fee2e2;
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
            <a href="<?= base_url('admin/laporan/penjualan') ?>" class="nav-item active">📈 Penjualan</a>
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
                <div class="page-title">Laporan Penjualan</div>
                <div class="breadcrumb">Admin → Laporan → Penjualan</div>
            </div>
        </div>
        <div class="content">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="sc-icon green">📦</div>
                    <div class="sc-val"><?= $total_terjual ?? 0 ?></div>
                    <div class="sc-label">Total Item Terjual</div>
                </div>
                <div class="stat-card">
                    <div class="sc-icon green">🛍️</div>
                    <div class="sc-val"><?= $total_pesanan ?? 0 ?></div>
                    <div class="sc-label">Pesanan Selesai</div>
                </div>
                <div class="stat-card">
                    <div class="sc-icon amber">💰</div>
                    <div class="sc-val">Rp <?= number_format($total_revenue ?? 0, 0, ',', '.') ?></div>
                    <div class="sc-label">Total Pendapatan</div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">📈 Grafik Penjualan Bulanan</div>
                </div>
                <div style="padding:20px"><canvas id="chartBulanan" height="80"></canvas></div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="card-title">📦 Daftar Produk</div>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok Sisa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($produk_list)): foreach ($produk_list as $p): ?>
                                <tr>
                                    <td style="font-weight:600"><?= esc($p['nama_produk']) ?></td>
                                    <td style="color:var(--gray-500)"><?= esc($p['kategori'] ?? '-') ?></td>
                                    <td style="color:var(--green-700);font-weight:600">Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                    <td style="<?= $p['stok'] < 20 ? 'color:var(--red-600);font-weight:700' : '' ?>"><?= $p['stok'] ?></td>
                                </tr>
                            <?php endforeach;
                        else: ?>
                            <tr>
                                <td colspan="4" style="text-align:center;padding:24px;color:var(--gray-500)">Belum ada data</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        new Chart(document.getElementById('chartBulanan'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [2100000, 3400000, <?= $total_revenue ?? 0 ?>, 3800000, 5100000, 4600000, 6200000, 5800000, 7100000, 6500000, 8200000, 9100000],
                    borderColor: '#22a046',
                    backgroundColor: 'rgba(34,160,70,0.08)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#22a046'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            callback: function(v) {
                                return 'Rp ' + v.toLocaleString('id-ID')
                            }
                        },
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                responsive: true
            }
        });
    </script>
</body>

</html>