<?php include APPPATH . 'Views/templates/header.php'; ?>

<div class="d-flex align-items-center mb-4 gap-2">
    <a href="<?= base_url('pesanan') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    <h5 class="fw-bold mb-0">Detail Pesanan #<?= $pesanan['id_pesanan'] ?></h5>
</div>

<div class="row g-4">

    <!-- Info Pesanan -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Info Pesanan</h6>
                <table class="table table-borderless mb-0">
                    <tr>
                        <td class="text-muted" style="width:40%">Tanggal</td>
                        <td><?= date('d M Y, H:i', strtotime($pesanan['tanggal'] ?? 'now')) ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge badge-status-<?= $pesanan['status'] ?>">
                                <?= ucfirst($pesanan['status'] ?? 'pending') ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Bayar</td>
                        <td><?= ucfirst($pesanan['metode_bayar'] ?? 'cash') ?></td>
                    </tr>
                    <tr>
                        <td class="text-muted">Metode Kirim</td>
                        <td><?= isset($pesanan['metode_kirim']) && $pesanan['metode_kirim'] === 'ambil' ? '🏪 Ambil di Toko' : '🚚 Antar ke Rumah' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Alamat Pengiriman -->
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Alamat Pengiriman</h6>
                <p class="text-muted mb-0"><?= nl2br(esc((string)($pesanan['alamat_kirim'] ?? 'Ambil di Toko — Jl. Trans Sulawesi, Parigi'))) ?></p>
            </div>

            <!-- Daftar Produk -->
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Produk yang Dipesan</h6>
                        <?php $total = 0; ?>
                        <?php if (!empty($detail)): ?>
                            <?php foreach ($detail as $item):
                                $sub = ($item['harga'] ?? 0) * ($item['jumlah'] ?? 1);
                                $total += $sub;
                                $foto = $item['foto'] ?? '';
                            ?>
                                <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                                    <?php if (!empty($foto)): ?>
                                        <?php $imgSrc = substr($foto, 0, 4) === 'http' ? esc($foto) : base_url('uploads/produk/' . esc($foto)); ?>
                                        <img src="<?= $imgSrc ?>" style="width:70px;height:70px;object-fit:cover;border-radius:8px"
                                            onerror="this.style.display='none'">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center rounded" style="width:70px;height:70px;font-size:28px">📦</div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-0"><?= esc($item['nama_produk'] ?? 'Produk') ?></p>
                                        <small class="text-muted">Rp <?= number_format($item['harga'] ?? 0, 0, ',', '.') ?> × <?= $item['jumlah'] ?? 1 ?></small>
                                    </div>
                                    <span class="fw-bold text-success">Rp <?= number_format($sub, 0, ',', '.') ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Tidak ada detail produk.</p>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between fw-bold fs-6 mt-2">
                            <span>Total</span>
                            <span class="text-success">Rp <?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <?php include APPPATH . 'Views/templates/footer.php'; ?>