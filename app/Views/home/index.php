<?php include APPPATH . 'Views/templates/header.php'; ?>

<style>
  :root {
    --gb: #40916c;
    --gd: #1a3a2a;
    --gp: #d8f3dc;
    --gold: #e9c46a;
    --cream: #fefae0;
  }

  .produk-header {
    background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%);
    padding: 32px 24px;
    border-radius: 16px;
    margin-bottom: 24px;
    color: #fff;
  }

  .produk-header h4 {
    font-weight: 900;
    font-size: 1.5rem;
    margin-bottom: 4px;
  }

  .produk-header p {
    color: rgba(255, 255, 255, 0.7);
    font-size: .9rem;
    margin: 0;
  }

  .card-produk {
    transition: transform .25s, box-shadow .25s;
    border-radius: 14px !important;
    overflow: hidden;
  }

  .card-produk:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(26, 58, 42, 0.15) !important;
  }

  .tab-kategori .btn {
    font-size: .82rem;
    border-radius: 50px !important;
  }

  .search-wrap {
    position: relative;
  }

  .search-wrap input {
    border-radius: 50px !important;
    padding-left: 40px;
    border-color: rgba(64, 145, 108, 0.35);
  }

  .search-wrap input:focus {
    border-color: var(--gb);
    box-shadow: 0 0 0 3px rgba(64, 145, 108, 0.15);
  }

  .search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
  }

  .info-strip {
    background: var(--gp);
    border-radius: 10px;
    padding: 10px 16px;
    font-size: .82rem;
    color: var(--gd);
  }

  .komoditas-strip {
    background: #1a3a2a;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
  }

  .komoditas-strip .label {
    font-size: .68rem;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.5);
    margin-bottom: 10px;
  }

  .komoditas-item {
    background: rgba(255, 255, 255, 0.07);
    border-radius: 8px;
    padding: 10px 12px;
    text-align: center;
  }

  .komoditas-item .nama {
    font-size: .78rem;
    font-weight: 700;
    color: #fff;
    margin-bottom: 2px;
  }

  .komoditas-item .prod {
    font-size: .7rem;
    color: rgba(255, 255, 255, 0.55);
  }

  .komoditas-item .ikon {
    font-size: 1.2rem;
    margin-bottom: 4px;
  }
</style>

<!-- HEADER -->
<div class="produk-header">
  <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
    <div>
      <p style="font-size:.7rem;letter-spacing:.14em;text-transform:uppercase;color:rgba(255,255,255,0.55);margin-bottom:6px;font-weight:700">🌿 Marketplace Lokal</p>
      <h4>
        <?php if ($keyword): ?>
          Hasil: <em style="color:var(--gold)">"<?= esc($keyword) ?>"</em>
        <?php elseif ($kategoriAktif !== 'Semua'): ?>
          Kategori: <em style="color:var(--gold)"><?= esc($kategoriAktif) ?></em>
        <?php else: ?>
          Semua Produk Parigi
        <?php endif; ?>
      </h4>
      <p><?= count($produk) ?> produk dari petani & pengrajin lokal Kec. Parigi, Pangandaran</p>
    </div>
    <a href="<?= base_url() ?>" class="btn btn-outline-light btn-sm rounded-pill align-self-start">← Beranda</a>
  </div>
</div>

<!-- STRIP KOMODITAS DATA BPS -->
<div class="komoditas-strip">
  <div class="label">📊 Data Produksi BPS Kec. Parigi 2024</div>
  <div class="row g-2">
    <?php
    $kdata = [
      ['🌿', 'Kapulaga', '94.740 kg'],
      ['🫚', 'Jahe', '24.000 kg'],
      ['🟡', 'Kunyit', '19.500 kg'],
      ['🍌', 'Pisang', '2.640 kw'],
      ['🍈', 'Durian', '1.083 kw'],
      ['🍅', 'Tomat', '557 kw'],
      ['🌶️', 'Cabai Rawit', '264 kw'],
      ['🧅', 'Bawang Merah', '106 kw'],
      ['🥑', 'Alpukat', '751 kw'],
      ['🌶️', 'Cabai Besar', '150 kw'],
      ['🌱', 'Kencur', '12.000 kg'],
      ['🫚', 'Lengkuas', '21.000 kg'],
    ];
    foreach ($kdata as $kd): ?>
      <div class="col-6 col-md-3 col-lg-2">
        <div class="komoditas-item">
          <div class="ikon"><?= $kd[0] ?></div>
          <div class="nama"><?= $kd[1] ?></div>
          <div class="prod"><?= $kd[2] ?>/thn</div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- SEARCH + TAB FILTER -->
<div class="row g-3 mb-4 align-items-center">
  <div class="col-md-5">
    <form method="get" action="<?= base_url('produk') ?>">
      <div class="search-wrap">
        <i class="bi bi-search search-icon"></i>
        <input type="text" name="cari" class="form-control"
          placeholder="Cari produk Parigi..." value="<?= esc($keyword) ?>">
      </div>
    </form>
  </div>
  <div class="col-md-7">
    <div class="tab-kategori d-flex gap-2 flex-wrap">
      <?php
      $ikonKategori = [
        'Semua'         => '🛒',
        'Hasil Tani'    => '🌾',
        'Hasil Laut'    => '🐟',
        'Oleh-oleh'     => '🎁',
        'Buah-buahan'   => '🍌',
        'Rempah'        => '🌿',
        'Biofarmaka'    => '🌱',
        'Produk Olahan' => '🏭',
      ];
      $tabs = array_merge(['Semua'], $allKategori);
      foreach ($tabs as $tab):
        $aktif = ($kategoriAktif === $tab) ? 'btn-success' : 'btn-outline-success';
        $ikon  = $ikonKategori[$tab] ?? '📦';
        $url   = base_url('produk') . '?kategori=' . urlencode($tab) . ($keyword ? '&cari=' . urlencode($keyword) : '');
      ?>
        <a href="<?= $url ?>" class="btn <?= $aktif ?> btn-sm"><?= $ikon ?> <?= esc($tab) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<!-- GRID PRODUK -->
<?php if (empty($produk)): ?>
  <div class="text-center py-5 text-muted">
    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
    <h6 class="fw-semibold">Produk tidak ditemukan</h6>
    <p class="small">Coba kategori lain atau hapus kata kunci pencarian.</p>
    <a href="<?= base_url('produk') ?>" class="btn btn-outline-success btn-sm rounded-pill mt-2">Lihat Semua Produk</a>
  </div>
<?php else: ?>
  <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
    <?php foreach ($produk as $p): ?>
      <div class="col">
        <div class="card card-produk h-100 border-0 shadow-sm">
          <?php
          $foto = $p['foto'];
          if (!empty($foto)) {
            $imgSrc = (substr($foto, 0, 4) === 'http') ? esc($foto) : base_url('uploads/produk/' . esc($foto));
            echo '<img src="' . $imgSrc . '" class="card-img-top" style="height:180px;object-fit:cover"
              onerror="this.onerror=null;this.src=\'https://placehold.co/400x300/e8f5e9/2e7d32?text=Parigi+Market\'">';
          } else {
            echo '<div class="bg-light d-flex align-items-center justify-content-center" style="height:180px">
              <i class="bi bi-image text-secondary fs-2"></i></div>';
          }
          ?>
          <div class="card-body p-3">
            <?php if (!empty($p['kategori'])): ?>
              <span class="badge bg-success bg-opacity-10 text-success mb-1" style="font-size:.68rem;font-weight:700;letter-spacing:.06em"><?= esc($p['kategori']) ?></span>
            <?php endif; ?>
            <p class="card-title fw-semibold mb-1 mt-1" style="font-size:.92rem"><?= esc($p['nama_produk']) ?></p>
            <p class="text-success fw-bold mb-1">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>
            <small class="text-muted">Stok: <?= $p['stok'] ?></small>
          </div>
          <div class="card-footer bg-white border-0 pb-3 px-3">
            <a href="<?= base_url('produk/' . $p['id_produk']) ?>"
              class="btn btn-outline-success btn-sm w-100 rounded-pill">Lihat Detail</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php include APPPATH . 'Views/templates/footer.php'; ?>