<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Pesanan — Parigi Market</title>
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
      --amber-600: #b45309;
      --red-600: #dc2626;
      --red-100: #fee2e2;
      --blue-100: #dbeafe;
      --blue-600: #1d4ed8;
      --teal-100: #ccf0eb;
      --teal-600: #0f7a6e;
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
      max-width: 860px;
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

    .card-body {
      padding: 20px;
    }

    .info-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .info-item .label {
      font-size: 11px;
      font-weight: 600;
      color: var(--gray-500);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 4px;
    }

    .info-item .value {
      font-size: 14px;
      font-weight: 500;
      color: var(--gray-900);
    }

    .status-pill {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      font-size: 12px;
      font-weight: 600;
      padding: 4px 12px;
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

    .prod-thumb {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      object-fit: cover;
      border: 1px solid var(--gray-100);
    }

    .prod-thumb-placeholder {
      width: 40px;
      height: 40px;
      border-radius: 8px;
      background: var(--green-50);
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 18px;
    }

    .total-row td {
      font-weight: 700;
      font-size: 14px;
      background: var(--gray-50);
    }

    .btn {
      padding: 9px 18px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      border: none;
      font-family: var(--font-body);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-secondary {
      background: var(--gray-100);
      color: var(--gray-700);
      border: 1px solid var(--gray-300);
    }

    .btn-primary {
      background: var(--green-600);
      color: #fff;
    }

    select.status-select {
      font-size: 13px;
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid var(--gray-300);
      background: #fff;
      cursor: pointer;
      font-family: var(--font-body);
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
      <a href="<?= base_url('admin/produk') ?>" class="nav-item">📦 Produk</a>
      <a href="<?= base_url('admin/pesanan') ?>" class="nav-item active">🛍️ Pesanan</a>
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
        <div class="page-title">Detail Pesanan #<?= $pesanan['id_pesanan'] ?? '' ?></div>
        <div class="breadcrumb">Admin → Pesanan → Detail</div>
      </div>
      <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-secondary">← Kembali</a>
    </div>

    <div class="content">

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success">✅ <?= session()->getFlashdata('success') ?></div>
      <?php endif; ?>

      <?php if (empty($pesanan)): ?>
        <div style="text-align:center;padding:40px;color:var(--gray-500)">Pesanan tidak ditemukan.</div>
      <?php else: ?>

        <!-- INFO PESANAN -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">📋 Informasi Pesanan</div>
            <?php
            $sc = 'pill-amber';
            if ($pesanan['status'] === 'selesai')      $sc = 'pill-green';
            elseif ($pesanan['status'] === 'dikirim')  $sc = 'pill-blue';
            elseif ($pesanan['status'] === 'diproses') $sc = 'pill-teal';
            elseif ($pesanan['status'] === 'dibatalkan') $sc = 'pill-red';
            ?>
            <span class="status-pill <?= $sc ?>"><span class="dot-s"></span><?= ucfirst($pesanan['status'] ?? 'pending') ?></span>
          </div>
          <div class="card-body">
            <div class="info-grid">
              <div class="info-item">
                <div class="label">ID Pesanan</div>
                <div class="value" style="font-family:monospace;color:var(--green-700)">#<?= $pesanan['id_pesanan'] ?></div>
              </div>
              <div class="info-item">
                <div class="label">Tanggal</div>
                <div class="value"><?= date('d F Y, H:i', strtotime($pesanan['tanggal'] ?? 'now')) ?></div>
              </div>
              <div class="info-item">
                <div class="label">ID Pembeli</div>
                <div class="value"><?= $pesanan['id_user'] ?? '-' ?></div>
              </div>
              <div class="info-item">
                <div class="label">Total Harga</div>
                <div class="value" style="color:var(--green-700);font-size:16px">Rp <?= number_format($pesanan['total_harga'] ?? 0, 0, ',', '.') ?></div>
              </div>
            </div>
          </div>
        </div>

        <!-- UBAH STATUS -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">🔄 Ubah Status Pesanan</div>
          </div>
          <div class="card-body">
            <form action="<?= base_url('admin/pesanan/status') ?>" method="post" style="display:flex;align-items:center;gap:12px;flex-wrap:wrap">
              <?= csrf_field() ?>
              <input type="hidden" name="id_pesanan" value="<?= $pesanan['id_pesanan'] ?>">
              <select name="status" class="status-select">
                <?php foreach (['pending', 'dibayar', 'diproses', 'dikirim', 'selesai', 'dibatalkan'] as $s): ?>
                  <option value="<?= $s ?>" <?= ($pesanan['status'] ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-primary">💾 Simpan Status</button>
            </form>
          </div>
        </div>

        <!-- DETAIL PRODUK -->
        <div class="card">
          <div class="card-header">
            <div class="card-title">🛒 Produk Dipesan</div>
          </div>
          <div class="card-body" style="padding:0">
            <?php if (empty($detail)): ?>
              <div style="padding:24px;text-align:center;color:var(--gray-500)">Tidak ada detail produk.</div>
            <?php else: ?>
              <table class="data-table">
                <thead>
                  <tr>
                    <th>Produk</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $grandTotal = 0;
                  foreach ($detail as $d):
                    $subtotal = ($d['harga'] ?? 0) * ($d['jumlah'] ?? 1);
                    $grandTotal += $subtotal;
                    $foto = $d['foto'] ?? '';
                  ?>
                    <tr>
                      <td>
                        <div style="display:flex;align-items:center;gap:10px">
                          <?php if (!empty($foto)): ?>
                            <img src="<?= substr($foto, 0, 4) === 'http' ? esc($foto) : base_url('uploads/produk/' . esc($foto)) ?>"
                              class="prod-thumb"
                              onerror="this.style.display='none'">
                          <?php else: ?>
                            <div class="prod-thumb-placeholder">📦</div>
                          <?php endif; ?>
                          <span style="font-weight:600"><?= esc($d['nama_produk'] ?? 'Produk') ?></span>
                        </div>
                      </td>
                      <td>Rp <?= number_format($d['harga'] ?? 0, 0, ',', '.') ?></td>
                      <td><?= $d['jumlah'] ?? 1 ?></td>
                      <td style="font-weight:600;color:var(--green-700)">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                    </tr>
                  <?php endforeach; ?>
                  <tr class="total-row">
                    <td colspan="3" style="text-align:right;padding-right:16px">Total</td>
                    <td style="color:var(--green-700)">Rp <?= number_format($grandTotal, 0, ',', '.') ?></td>
                  </tr>
                </tbody>
              </table>
            <?php endif; ?>
          </div>
        </div>

      <?php endif; ?>
    </div>
  </div>

</body>

</html>