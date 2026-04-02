<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin — Kelola Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark" style="background:#2e7d32">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold">🌿 Admin Parigi Market</span>
            <div class="d-flex gap-3">
                <a href="<?= base_url('admin/pesanan') ?>" class="text-white text-decoration-none small">Pesanan</a>
                <a href="<?= base_url('/') ?>" class="text-white text-decoration-none small">Lihat Toko</a>
                <a href="<?= base_url('logout') ?>" class="text-white text-decoration-none small">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Produk</h5>
            <a href="<?= base_url('admin/produk/tambah') ?>" class="btn btn-sm text-white" style="background:#2e7d32">
                <i class="bi bi-plus-lg me-1"></i>Tambah Produk
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover bg-white shadow-sm rounded align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produk)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada produk.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produk as $p): ?>
                            <tr>
                                <td>
                                    <?php if ($p['foto']): ?>
                                        <img src="<?= base_url('uploads/produk/' . esc($p['foto'])) ?>" style="width:56px;height:56px;object-fit:cover;border-radius:6px">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded" style="width:56px;height:56px"></div>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($p['nama_produk']) ?></td>
                                <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                                <td><?= $p['stok'] ?></td>
                                <td class="d-flex gap-2">
                                    <a href="<?= base_url('admin/produk/edit/' . $p['id_produk']) ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <a href="<?= base_url('admin/produk/hapus/' . $p['id_produk']) ?>" class="btn btn-sm btn-outline-danger"
                                        onclick="return confirm('Hapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>