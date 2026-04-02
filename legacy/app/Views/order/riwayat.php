<?php include APPPATH . 'Views/templates/header.php'; ?>

<h5 class="fw-bold mb-4"><i class="bi bi-bag-check me-2"></i>Riwayat Pesanan</h5>

<?php if (empty($pesanan)): ?>
  <div class="text-center py-5 text-muted">
    <i class="bi bi-bag-x fs-1"></i>
    <p class="mt-2">Belum ada pesanan.</p>
    <a href="<?= base_url('/') ?>" class="btn btn-hijau">Mulai Belanja</a>
  </div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table table-hover bg-white shadow-sm rounded align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Total</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($pesanan as $p): ?>
          <tr>
            <td><?= $p['id_pesanan'] ?></td>
            <td><?= date('d M Y H:i', strtotime($p['tanggal'])) ?></td>
            <td>Rp <?= number_format($p['total_harga'], 0, ',', '.') ?></td>
            <td>
              <span class="badge badge-status-<?= $p['status'] ?>">
                <?= ucfirst($p['status']) ?>
              </span>
            </td>
            <td><a href="<?= base_url('pesanan/' . $p['id_pesanan']) ?>" class="btn btn-sm btn-outline-success">Detail</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>

<?php include APPPATH . 'Views/templates/footer.php'; ?>