<?php include APPPATH . 'Views/templates/header.php'; ?>

<h5 class="fw-bold mb-4">🛒 Konfirmasi Pesanan</h5>

<?php $total = 0; ?>
<div class="row g-4">

  <!-- DAFTAR PRODUK -->
  <div class="col-md-7">
    <div class="card border-0 shadow-sm mb-3">
      <div class="card-body">
        <h6 class="fw-bold mb-3">Produk yang Dipesan</h6>
        <?php foreach ($keranjang as $item):
          $sub = $item['harga'] * $item['jumlah'];
          $total += $sub; ?>
          <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
            <span><?= esc($item['nama_produk']) ?> <span class="text-muted">×<?= $item['jumlah'] ?></span></span>
            <span class="fw-semibold">Rp <?= number_format($sub, 0, ',', '.') ?></span>
          </div>
        <?php endforeach; ?>
        <div class="d-flex justify-content-between fw-bold mt-2">
          <span>Total</span>
          <span class="text-success fs-5">Rp <?= number_format($total, 0, ',', '.') ?></span>
        </div>
      </div>
    </div>
  </div>

  <!-- FORM CHECKOUT -->
  <div class="col-md-5">
    <form action="<?= base_url('checkout/proses') ?>" method="post">
      <?= csrf_field() ?>

      <!-- METODE PENGIRIMAN -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3">🚚 Metode Pengiriman</h6>

          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="metode_kirim" id="antar" value="antar" checked onchange="toggleAlamat(this.value)">
            <label class="form-check-label fw-semibold" for="antar">
              🏠 Antar ke Rumah
              <small class="text-muted d-block fw-normal">Pesanan dikirim ke alamat kamu</small>
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_kirim" id="ambil" value="ambil" onchange="toggleAlamat(this.value)">
            <label class="form-check-label fw-semibold" for="ambil">
              🏪 Ambil di Toko
              <small class="text-muted d-block fw-normal">Jl. Trans Sulawesi, Parigi Kota</small>
            </label>
          </div>

          <!-- Alamat (muncul kalau pilih antar) -->
          <div id="box-alamat" class="mt-3">
            <label class="form-label fw-semibold small">Alamat Pengiriman</label>
            <textarea name="alamat_kirim" class="form-control form-control-sm" rows="3"
              placeholder="Masukkan alamat lengkap..."><?= esc(session()->get('alamat') ?? '') ?></textarea>
          </div>
        </div>
      </div>

      <!-- METODE PEMBAYARAN -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <h6 class="fw-bold mb-3">💳 Metode Pembayaran</h6>

          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="metode_bayar" id="cash" value="cash" checked>
            <label class="form-check-label fw-semibold" for="cash">
              💰 Cash / Tunai
              <small class="text-muted d-block fw-normal">Bayar saat terima barang atau di toko</small>
            </label>
          </div>

          <div class="form-check">
            <input class="form-check-input" type="radio" name="metode_bayar" id="credit" value="credit">
            <label class="form-check-label fw-semibold" for="credit">
              💳 Credit Card
              <small class="text-muted d-block fw-normal">Kartu kredit / debit</small>
            </label>
          </div>
        </div>
      </div>

      <!-- TOMBOL -->
      <button type="submit" class="btn btn-hijau w-100 py-2">
        <i class="bi bi-check-circle me-1"></i> Buat Pesanan
      </button>
      <a href="<?= base_url('keranjang') ?>" class="btn btn-link w-100 text-muted mt-1">← Kembali ke Keranjang</a>

    </form>
  </div>
</div>

<script>
  function toggleAlamat(val) {
    document.getElementById('box-alamat').style.display = val === 'antar' ? 'block' : 'none';
  }
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>