<?php include APPPATH . 'Views/templates/header.php'; ?>

<style>
  :root { --gd:#1a3a2a; --gm:#2d6a4f; --gb:#40916c; --gl:#74c69d; --gp:#d8f3dc; --gold:#e9c46a; }

  /* ── SIDEBAR CART ── */
  .cart-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,0.45);
    z-index: 1050; opacity: 0; pointer-events: none;
    transition: opacity .3s;
  }
  .cart-overlay.open { opacity: 1; pointer-events: all; }

  .cart-sidebar {
    position: fixed; top: 0; right: -480px; width: 100%; max-width: 440px;
    height: 100vh; background: #fff; z-index: 1051;
    display: flex; flex-direction: column;
    box-shadow: -8px 0 40px rgba(26,58,42,0.18);
    transition: right .35s cubic-bezier(.4,0,.2,1);
  }
  .cart-sidebar.open { right: 0; }

  .cart-head {
    background: var(--gb); color: #fff;
    padding: 20px 24px; display: flex; align-items: center; justify-content: space-between;
    flex-shrink: 0;
  }
  .cart-head h5 { margin: 0; font-size: 1.05rem; font-weight: 700; display: flex; align-items: center; gap: 10px; }
  .cart-head .badge-count { background: var(--gold); color: var(--gd); font-size: .75rem; font-weight: 700; padding: 3px 10px; border-radius: 50px; }
  .cart-close { background: rgba(255,255,255,0.18); border: none; color: #fff; width: 34px; height: 34px; border-radius: 50%; font-size: 1.1rem; cursor: pointer; transition: background .2s; display: flex; align-items: center; justify-content: center; }
  .cart-close:hover { background: rgba(255,255,255,0.3); }

  .cart-body { flex: 1; overflow-y: auto; padding: 16px; }
  .cart-body::-webkit-scrollbar { width: 4px; }
  .cart-body::-webkit-scrollbar-thumb { background: var(--gp); border-radius: 4px; }

  .cart-empty { text-align: center; padding: 60px 20px; color: #888; }
  .cart-empty i { font-size: 3rem; color: var(--gp); display: block; margin-bottom: 12px; }
  .cart-empty p { font-size: .9rem; margin-bottom: 16px; }

  .cart-item {
    display: flex; gap: 14px; align-items: flex-start;
    padding: 14px 0; border-bottom: 1px solid #f0f0f0;
  }
  .cart-item:last-child { border-bottom: none; }
  .cart-item-img {
    width: 72px; height: 72px; border-radius: 10px;
    object-fit: cover; flex-shrink: 0;
    background: var(--gp);
  }
  .cart-item-img-placeholder {
    width: 72px; height: 72px; border-radius: 10px;
    background: var(--gp); flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    color: var(--gb); font-size: 1.4rem;
  }
  .cart-item-info { flex: 1; min-width: 0; }
  .cart-item-cat { font-size: .65rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: var(--gb); margin-bottom: 3px; }
  .cart-item-name { font-size: .88rem; font-weight: 600; color: var(--gd); margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  .cart-item-price { font-size: .82rem; color: var(--gb); font-weight: 600; }

  .qty-control { display: flex; align-items: center; gap: 0; margin-top: 8px; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden; width: fit-content; }
  .qty-btn { background: #f8f8f8; border: none; width: 30px; height: 28px; font-size: .9rem; cursor: pointer; color: var(--gd); transition: background .15s; display: flex; align-items: center; justify-content: center; }
  .qty-btn:hover { background: var(--gp); }
  .qty-val { font-size: .84rem; font-weight: 700; color: var(--gd); padding: 0 12px; min-width: 36px; text-align: center; border-left: 1px solid #e0e0e0; border-right: 1px solid #e0e0e0; line-height: 28px; }

  .cart-item-right { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }
  .cart-item-subtotal { font-size: .92rem; font-weight: 700; color: var(--gd); white-space: nowrap; }
  .btn-hapus { background: none; border: 1px solid #ffcdd2; border-radius: 7px; color: #e57373; width: 30px; height: 30px; cursor: pointer; font-size: .85rem; transition: all .2s; display: flex; align-items: center; justify-content: center; }
  .btn-hapus:hover { background: #ffebee; border-color: #ef5350; color: #c62828; }

  .cart-footer {
    padding: 16px 20px; border-top: 1px solid #f0f0f0;
    background: #fafafa; flex-shrink: 0;
  }
  .cart-total-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
  .cart-total-label { font-size: .82rem; color: #888; }
  .cart-total-val { font-size: .88rem; font-weight: 600; color: var(--gd); }
  .cart-grand-row { display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px solid #e8e8e8; margin-bottom: 14px; }
  .cart-grand-label { font-size: .95rem; font-weight: 700; color: var(--gd); }
  .cart-grand-val { font-size: 1.15rem; font-weight: 900; color: var(--gd); font-family: 'Playfair Display', serif; }
  .btn-checkout {
    display: block; width: 100%; text-align: center;
    background: var(--gb); color: #fff;
    padding: 13px; border-radius: 12px; font-size: .92rem; font-weight: 700;
    text-decoration: none; transition: all .2s; border: none; cursor: pointer;
    letter-spacing: .03em;
  }
  .btn-checkout:hover { background: var(--gm); color: #fff; transform: translateY(-1px); }
  .btn-lanjut { display: block; text-align: center; margin-top: 8px; font-size: .82rem; color: var(--gb); text-decoration: none; }
  .btn-lanjut:hover { color: var(--gm); }

  /* ── HALAMAN KERANJANG (fallback full page) ── */
  .page-cart { max-width: 960px; margin: 0 auto; }
  .cart-page-item {
    background: #fff; border-radius: 14px;
    padding: 16px; display: flex; gap: 16px; align-items: center;
    box-shadow: 0 2px 10px rgba(26,58,42,0.07); margin-bottom: 12px;
  }
  .cart-page-img { width: 88px; height: 88px; border-radius: 10px; object-fit: cover; flex-shrink: 0; background: var(--gp); }
  .summary-card { background: #fff; border-radius: 16px; padding: 24px; box-shadow: 0 4px 18px rgba(26,58,42,0.09); position: sticky; top: 80px; }
  .summary-row { display: flex; justify-content: space-between; font-size: .9rem; margin-bottom: 8px; color: #555; }
  .summary-total { display: flex; justify-content: space-between; font-size: 1.05rem; font-weight: 700; color: var(--gd); padding-top: 12px; border-top: 1px solid #eee; margin-bottom: 16px; }
</style>

<!-- SIDEBAR CART -->
<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-head">
    <h5>
      <i class="bi bi-cart3"></i> Keranjang
      <?php if (!empty($keranjang)): ?>
        <span class="badge-count"><?= count($keranjang) ?></span>
      <?php endif; ?>
    </h5>
    <button class="cart-close" onclick="closeCart()"><i class="bi bi-x-lg"></i></button>
  </div>

  <div class="cart-body">
    <?php if (empty($keranjang)): ?>
      <div class="cart-empty">
        <i class="bi bi-cart-x"></i>
        <p>Keranjang kamu masih kosong</p>
        <a href="<?= base_url('produk') ?>" class="btn btn-sm rounded-pill px-4" style="background:var(--gb);color:#fff" onclick="closeCart()">Mulai Belanja</a>
      </div>
    <?php else: ?>
      <?php $total = 0; foreach ($keranjang as $item): $sub = $item['harga'] * $item['jumlah']; $total += $sub; ?>
      <div class="cart-item">
        <?php if (!empty($item['foto'])): ?>
          <?php $src = (substr($item['foto'],0,4)==='http') ? esc($item['foto']) : base_url('uploads/produk/'.esc($item['foto'])); ?>
          <img class="cart-item-img" src="<?= $src ?>" onerror="this.style.display='none'">
        <?php else: ?>
          <div class="cart-item-img-placeholder"><i class="bi bi-image"></i></div>
        <?php endif; ?>

        <div class="cart-item-info">
          <?php if (!empty($item['kategori'])): ?>
            <div class="cart-item-cat"><?= esc($item['kategori']) ?></div>
          <?php endif; ?>
          <div class="cart-item-name"><?= esc($item['nama_produk']) ?></div>
          <div class="cart-item-price">Rp <?= number_format($item['harga'],0,',','.') ?></div>
          <div class="qty-control">
            <form action="<?= base_url('keranjang/update') ?>" method="post" style="display:contents">
              <?= csrf_field() ?>
              <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
              <button type="submit" name="jumlah" value="<?= max(1,$item['jumlah']-1) ?>" class="qty-btn">−</button>
              <span class="qty-val"><?= $item['jumlah'] ?></span>
              <button type="submit" name="jumlah" value="<?= $item['jumlah']+1 ?>" class="qty-btn">+</button>
            </form>
          </div>
        </div>

        <div class="cart-item-right">
          <span class="cart-item-subtotal">Rp <?= number_format($sub,0,',','.') ?></span>
          <form action="<?= base_url('keranjang/hapus') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
            <button type="submit" class="btn-hapus"><i class="bi bi-trash3"></i></button>
          </form>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <?php if (!empty($keranjang)): ?>
  <div class="cart-footer">
    <div class="cart-total-row">
      <span class="cart-total-label"><?= count($keranjang) ?> produk</span>
      <span class="cart-total-val">Rp <?= number_format($total,0,',','.') ?></span>
    </div>
    <div class="cart-grand-row">
      <span class="cart-grand-label">Total</span>
      <span class="cart-grand-val">Rp <?= number_format($total,0,',','.') ?></span>
    </div>
    <a href="<?= base_url('checkout') ?>" class="btn-checkout">Lanjut ke Pembayaran →</a>
    <a href="<?= base_url('produk') ?>" class="btn-lanjut" onclick="closeCart()">← Lanjut Belanja</a>
  </div>
  <?php endif; ?>
</div>

<!-- HALAMAN PENUH KERANJANG -->
<div class="page-cart">
  <div class="d-flex align-items-center gap-3 mb-4">
    <h5 class="fw-bold mb-0" style="color:var(--gd)"><i class="bi bi-cart3 me-2" style="color:var(--gb)"></i>Keranjang Belanja</h5>
    <?php if (!empty($keranjang)): ?>
      <span class="badge rounded-pill" style="background:var(--gp);color:var(--gd);font-size:.78rem"><?= count($keranjang) ?> item</span>
    <?php endif; ?>
  </div>

  <?php if (empty($keranjang)): ?>
    <div class="text-center py-5">
      <i class="bi bi-cart-x" style="font-size:3.5rem;color:var(--gp)"></i>
      <p class="mt-3 text-muted">Keranjang kamu masih kosong.</p>
      <a href="<?= base_url('produk') ?>" class="btn rounded-pill px-4" style="background:var(--gb);color:#fff">Mulai Belanja</a>
    </div>
  <?php else: ?>
    <?php $total = 0; ?>
    <div class="row g-4">
      <div class="col-md-8">
        <?php foreach ($keranjang as $item): ?>
          <?php $sub = $item['harga'] * $item['jumlah']; $total += $sub; ?>
          <div class="cart-page-item">
            <?php if (!empty($item['foto'])): ?>
              <?php $src = (substr($item['foto'],0,4)==='http') ? esc($item['foto']) : base_url('uploads/produk/'.esc($item['foto'])); ?>
              <img class="cart-page-img" src="<?= $src ?>" onerror="this.style.background='#d8f3dc'">
            <?php else: ?>
              <div class="cart-page-img d-flex align-items-center justify-content-center" style="background:var(--gp)"><i class="bi bi-image" style="color:var(--gb);font-size:1.5rem"></i></div>
            <?php endif; ?>
            <div class="flex-grow-1">
              <?php if (!empty($item['kategori'])): ?>
                <div style="font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--gb);margin-bottom:3px"><?= esc($item['kategori']) ?></div>
              <?php endif; ?>
              <p class="fw-semibold mb-1" style="font-size:.95rem;color:var(--gd)"><?= esc($item['nama_produk']) ?></p>
              <p style="color:var(--gb);font-weight:600;font-size:.88rem;margin-bottom:10px">Rp <?= number_format($item['harga'],0,',','.') ?></p>
              <form action="<?= base_url('keranjang/update') ?>" method="post" class="d-flex align-items-center gap-2">
                <?= csrf_field() ?>
                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                <div class="qty-control">
                  <button type="submit" name="jumlah" value="<?= max(1,$item['jumlah']-1) ?>" class="qty-btn">−</button>
                  <span class="qty-val"><?= $item['jumlah'] ?></span>
                  <button type="submit" name="jumlah" value="<?= $item['jumlah']+1 ?>" class="qty-btn">+</button>
                </div>
              </form>
            </div>
            <div class="text-end">
              <p class="fw-bold mb-2" style="color:var(--gd);font-size:.98rem">Rp <?= number_format($sub,0,',','.') ?></p>
              <form action="<?= base_url('keranjang/hapus') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="id_produk" value="<?= $item['id_produk'] ?>">
                <button class="btn-hapus"><i class="bi bi-trash3"></i></button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="col-md-4">
        <div class="summary-card">
          <h6 class="fw-bold mb-3" style="color:var(--gd)">Ringkasan Belanja</h6>
          <div class="summary-row"><span><?= count($keranjang) ?> produk</span><span>Rp <?= number_format($total,0,',','.') ?></span></div>
          <div class="summary-row"><span>Ongkos kirim</span><span class="text-success">Gratis</span></div>
          <div class="summary-total"><span>Total</span><span>Rp <?= number_format($total,0,',','.') ?></span></div>
          <a href="<?= base_url('checkout') ?>" class="btn-checkout">Lanjut ke Pembayaran →</a>
          <a href="<?= base_url('produk') ?>" class="btn-lanjut">← Lanjut Belanja</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<script>
function openCart() {
  document.getElementById('cartSidebar').classList.add('open');
  document.getElementById('cartOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeCart() {
  document.getElementById('cartSidebar').classList.remove('open');
  document.getElementById('cartOverlay').classList.remove('open');
  document.body.style.overflow = '';
}
// Auto buka sidebar waktu halaman keranjang dibuka
window.addEventListener('DOMContentLoaded', () => openCart());
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>