<?php include APPPATH . 'Views/templates/header.php'; ?>

<div class="row g-4">
  <div class="col-md-5">
    <?php if ($produk['foto']): ?>
      <img src="<?= base_url('uploads/produk/' . esc($produk['foto'])) ?>" class="img-fluid rounded shadow-sm w-100" style="max-height:380px;object-fit:cover">
    <?php else: ?>
      <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height:300px">
        <i class="bi bi-image text-white fs-1"></i>
      </div>
    <?php endif; ?>
  </div>
  <div class="col-md-7">
    <h4 class="fw-bold"><?= esc($produk['nama_produk']) ?></h4>
    <h5 class="text-success">Rp <?= number_format($produk['harga'], 0, ',', '.') ?></h5>
    <p class="text-muted">Stok tersedia: <strong><?= $produk['stok'] ?></strong></p>
    <hr>
    <p><?= nl2br(esc($produk['deskripsi'])) ?></p>
    <hr>

    <?php if (session()->get('id_user')): ?>
      <form action="<?= base_url('keranjang/tambah') ?>" method="post" class="d-flex align-items-center gap-2">
        <?= csrf_field() ?>
        <input type="hidden" name="id_produk" value="<?= $produk['id_produk'] ?>">
        <input type="number" name="jumlah" value="1" min="1" max="<?= $produk['stok'] ?>" class="form-control" style="width:80px">
        <button type="submit" class="btn btn-hijau px-4">
          <i class="bi bi-cart-plus me-1"></i> Tambah ke Keranjang
        </button>
      </form>
    <?php else: ?>
      <a href="<?= base_url('login') ?>" class="btn btn-outline-success">Login untuk Beli</a>
    <?php endif; ?>

    <a href="<?= base_url('/') ?>" class="btn btn-link text-muted mt-2 ps-0">← Kembali ke Katalog</a>
  </div>
</div>

<?php include APPPATH . 'Views/templates/footer.php'; ?>