<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Parigi Marketplace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --gd: #1a3a2a;
      --gm: #2d6a4f;
      --gb: #40916c;
      --gl: #74c69d;
      --gp: #d8f3dc;
      --gold: #e9c46a;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: #f8faf8;
    }

    /* ── NAVBAR ── */
    .main-nav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 999;
      background: rgba(26, 58, 42, 0.96);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid rgba(116, 198, 157, 0.18);
      padding: 0 40px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
    }

    .nav-brand {
      font-family: 'Playfair Display', serif;
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--gp);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px;
      white-space: nowrap;
    }

    .nav-brand span {
      color: var(--gold);
    }

    .nav-links-center {
      display: flex;
      align-items: center;
      gap: 4px;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-links-center a {
      color: rgba(255, 255, 255, 0.68);
      text-decoration: none;
      font-size: .85rem;
      font-weight: 500;
      padding: 6px 14px;
      border-radius: 50px;
      transition: all .2s;
      white-space: nowrap;
    }

    .nav-links-center a:hover {
      color: var(--gl);
      background: rgba(116, 198, 157, 0.1);
    }

    .nav-search {
      display: flex;
      align-items: center;
      background: rgba(255, 255, 255, 0.09);
      border: 1px solid rgba(116, 198, 157, 0.22);
      border-radius: 50px;
      overflow: hidden;
      padding: 0 4px 0 14px;
      flex: 1;
      max-width: 260px;
    }

    .nav-search input {
      background: transparent;
      border: none;
      outline: none;
      color: #fff;
      font-size: .84rem;
      width: 100%;
      padding: 7px 0;
    }

    .nav-search input::placeholder {
      color: rgba(255, 255, 255, 0.4);
    }

    .nav-search button {
      background: var(--gb);
      border: none;
      color: #fff;
      border-radius: 50px;
      padding: 5px 14px;
      font-size: .82rem;
      font-weight: 600;
      cursor: pointer;
      transition: background .2s;
      white-space: nowrap;
    }

    .nav-search button:hover {
      background: var(--gl);
    }

    .nav-right {
      display: flex;
      align-items: center;
      gap: 8px;
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .nav-right a {
      text-decoration: none;
    }

    .btn-nav-login {
      color: rgba(255, 255, 255, 0.75);
      font-size: .84rem;
      font-weight: 500;
      padding: 7px 16px;
      border-radius: 50px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all .2s;
      white-space: nowrap;
    }

    .btn-nav-login:hover {
      color: #fff;
      border-color: rgba(255, 255, 255, 0.5);
    }

    .btn-nav-register {
      background: var(--gold);
      color: var(--gd);
      font-size: .84rem;
      font-weight: 700;
      padding: 7px 18px;
      border-radius: 50px;
      transition: all .2s;
      white-space: nowrap;
    }

    .btn-nav-register:hover {
      background: #f0d080;
      transform: translateY(-1px);
    }

    .nav-icon-btn {
      color: rgba(255, 255, 255, 0.75);
      font-size: 1.1rem;
      padding: 6px 10px;
      border-radius: 50px;
      transition: all .2s;
      position: relative;
    }

    .nav-icon-btn:hover {
      color: var(--gl);
      background: rgba(116, 198, 157, 0.1);
    }

    .nav-icon-btn .badge {
      position: absolute;
      top: 2px;
      right: 2px;
      font-size: .6rem;
      padding: 2px 5px;
      background: #e9c46a;
      color: #1a3a2a;
    }

    .nav-user-btn {
      display: flex;
      align-items: center;
      gap: 7px;
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(116, 198, 157, 0.2);
      border-radius: 50px;
      padding: 5px 14px 5px 6px;
      color: rgba(255, 255, 255, 0.85);
      font-size: .84rem;
      font-weight: 500;
      text-decoration: none;
      transition: all .2s;
    }

    .nav-user-btn:hover {
      background: rgba(255, 255, 255, 0.14);
      color: #fff;
    }

    .nav-user-avatar {
      width: 28px;
      height: 28px;
      border-radius: 50%;
      background: var(--gb);
      color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: .72rem;
      font-weight: 700;
    }

    .dropdown-menu {
      border: none;
      box-shadow: 0 8px 32px rgba(26, 58, 42, 0.18);
      border-radius: 12px;
      overflow: hidden;
      padding: 6px;
      min-width: 180px;
    }

    .dropdown-item {
      border-radius: 8px;
      font-size: .86rem;
      padding: 8px 12px;
      transition: background .15s;
    }

    .nav-admin-badge {
      background: rgba(233, 196, 106, 0.18);
      color: var(--gold);
      font-size: .72rem;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      padding: 4px 10px;
      border-radius: 50px;
      text-decoration: none;
      transition: all .2s;
      white-space: nowrap;
    }

    .nav-admin-badge:hover {
      background: rgba(233, 196, 106, 0.3);
      color: var(--gold);
    }

    /* Page offset for fixed nav */
    body>.container.py-4,
    body>div.container.py-4 {
      padding-top: 84px !important;
    }

    .page-content {
      padding-top: 64px;
    }

    /* ── EXISTING UTILITY ── */
    .btn-hijau {
      background: #2e7d32;
      color: #fff;
      border: none;
    }

    .btn-hijau:hover {
      background: #1b5e20;
      color: #fff;
    }

    .card-produk {
      transition: transform .2s;
    }

    .card-produk:hover {
      transform: translateY(-4px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, .12);
    }

    .badge-status-pending {
      background: #ffc107;
      color: #000
    }

    .badge-status-processing {
      background: #0dcaf0;
      color: #000
    }

    .badge-status-shipped {
      background: #0d6efd;
      color: #fff
    }

    .badge-status-done {
      background: #198754;
      color: #fff
    }

    .badge-status-cancelled {
      background: #dc3545;
      color: #fff
    }

    .badge-status-dibayar {
      background: #0dcaf0;
      color: #000
    }

    .badge-status-diproses {
      background: #0d6efd;
      color: #fff
    }

    .badge-status-dikirim {
      background: #6f42c1;
      color: #fff
    }

    .badge-status-selesai {
      background: #198754;
      color: #fff
    }

    .badge-status-dibatalkan {
      background: #dc3545;
      color: #fff
    }

    @media(max-width:991px) {
      .main-nav {
        padding: 0 16px;
      }

      .nav-links-center {
        display: none;
      }

      .nav-search {
        max-width: 180px;
      }
    }

    @media(max-width:640px) {
      .nav-search {
        display: none;
      }
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="main-nav">
    <a href="<?= base_url('/') ?>" class="nav-brand">🌿 Parigi<span>Market</span></a>

    <ul class="nav-links-center">
      <li><a href="<?= base_url('/') ?>#tentang">Tentang Parigi</a></li>
      <li><a href="<?= base_url('/') ?>#peta">Peta Wilayah</a></li>
      <li><a href="<?= base_url('/') ?>#ciri-khas">Ciri Khas</a></li>
      <li><a href="<?= base_url('/') ?>#produk">Produk Lokal</a></li>
      <li><a href="<?= base_url('produk') ?>">Marketplace</a></li>
    </ul>

    <form class="nav-search" action="<?= base_url('produk') ?>" method="get">
      <i class="bi bi-search" style="color:rgba(255,255,255,0.4);font-size:.85rem"></i>&nbsp;
      <input type="search" name="cari" placeholder="Cari produk..." value="<?= esc($keyword ?? '') ?>">
      <button type="submit">Cari</button>
    </form>

    <ul class="nav-right">
      <?php if (session()->get('id_user')): ?>
        <li>
          <a href="<?= base_url('keranjang') ?>" class="nav-icon-btn">
            <i class="bi bi-cart3"></i>
            <?php $k = session()->get('keranjang') ?? []; ?>
            <?php if (count($k)): ?><span class="badge rounded-pill"><?= count($k) ?></span><?php endif; ?>
          </a>
        </li>
        <li><a href="<?= base_url('pesanan') ?>" class="nav-icon-btn" title="Pesanan Saya"><i class="bi bi-bag-check"></i></a></li>
        <?php if (session()->get('role') === 'admin'): ?>
          <li><a href="<?= base_url('admin') ?>" class="nav-admin-badge"><i class="bi bi-shield-check me-1"></i>Admin</a></li>
        <?php endif; ?>
        <li class="dropdown">
          <a href="#" class="nav-user-btn dropdown-toggle" data-bs-toggle="dropdown">
            <div class="nav-user-avatar"><?= strtoupper(substr(session()->get('nama'), 0, 2)) ?></div>
            <?= esc(session()->get('nama')) ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="<?= base_url('pesanan') ?>"><i class="bi bi-bag me-2 text-success"></i>Pesanan Saya</a></li>
            <li>
              <hr class="dropdown-divider my-1">
            </li>
            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
          </ul>
        </li>
      <?php else: ?>
        <li><a href="<?= base_url('login') ?>" class="btn-nav-login">Masuk</a></li>
        <li><a href="<?= base_url('register') ?>" class="btn-nav-register">Daftar</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div class="page-content">
    <?php if (session()->getFlashdata('success')): ?>
      <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show border-0 rounded-3" style="background:#d8f3dc;color:#1a3a2a">
          <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3">
          <i class="bi bi-exclamation-circle-fill me-2"></i><?= session()->getFlashdata('error') ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    <?php endif; ?>