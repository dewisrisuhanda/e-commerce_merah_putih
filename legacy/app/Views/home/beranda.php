<?php include APPPATH . 'Views/templates/header.php'; ?>

<style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --gd: #1a3a2a;
        --gm: #2d6a4f;
        --gb: #40916c;
        --gl: #74c69d;
        --gp: #d8f3dc;
        --gold: #e9c46a;
        --cream: #fefae0;
        --w: #fff;
    }

    html {
        scroll-behavior: smooth;
    }

    /* HERO */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-top: -64px;
    }

    .hero-bg {
        position: absolute;
        inset: 0;
        background: linear-gradient(160deg, rgba(26, 58, 42, 0.78) 0%, rgba(45, 106, 79, 0.5) 50%, rgba(26, 58, 42, 0.72) 100%), url('https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=1600&q=80') center/cover no-repeat;
        animation: slowZoom 18s ease-in-out infinite alternate;
    }

    @keyframes slowZoom {
        from {
            transform: scale(1.04)
        }

        to {
            transform: scale(1.12)
        }
    }

    .hero-badge {
        position: absolute;
        top: 90px;
        right: 60px;
        background: var(--gold);
        color: var(--gd);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: 7px 16px;
        border-radius: 50px;
        animation: fadeDown .8s .4s both;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 0 20px;
        max-width: 820px;
    }

    .hero-eyebrow {
        font-size: .78rem;
        font-weight: 600;
        letter-spacing: .2em;
        text-transform: uppercase;
        color: var(--gl);
        margin-bottom: 16px;
        animation: fadeUp .7s .1s both;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2.6rem, 7vw, 5rem);
        font-weight: 900;
        line-height: 1.08;
        color: #fff;
        margin-bottom: 20px;
        animation: fadeUp .7s .25s both;
    }

    .hero-title em {
        font-style: normal;
        color: var(--gold);
    }

    .hero-sub {
        font-size: 1.02rem;
        line-height: 1.72;
        color: rgba(255, 255, 255, 0.82);
        max-width: 560px;
        margin: 0 auto 36px;
        animation: fadeUp .7s .4s both;
    }

    .hero-actions {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        animation: fadeUp .7s .55s both;
    }

    .btn-p {
        background: var(--gb);
        color: #fff;
        padding: 13px 32px;
        border-radius: 50px;
        font-size: .92rem;
        font-weight: 600;
        text-decoration: none;
        transition: all .25s;
        box-shadow: 0 8px 24px rgba(64, 145, 108, 0.4);
    }

    .btn-p:hover {
        background: var(--gl);
        transform: translateY(-2px);
    }

    .btn-o {
        border: 2px solid rgba(255, 255, 255, 0.5);
        color: #fff;
        padding: 11px 30px;
        border-radius: 50px;
        font-size: .92rem;
        font-weight: 500;
        text-decoration: none;
        transition: all .25s;
    }

    .btn-o:hover {
        border-color: var(--gl);
        color: var(--gl);
    }

    .hero-scroll {
        position: absolute;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        color: rgba(255, 255, 255, 0.4);
        font-size: .7rem;
        letter-spacing: .1em;
        text-transform: uppercase;
    }

    .scroll-line {
        width: 1px;
        height: 32px;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.5), transparent);
        animation: scrollP 2s infinite;
    }

    @keyframes scrollP {

        0%,
        100% {
            opacity: .4
        }

        50% {
            opacity: 1
        }
    }

    /* STATS */
    .stats {
        background: var(--gd);
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-bottom: 3px solid var(--gb);
    }

    .stat {
        padding: 26px 16px;
        text-align: center;
        border-right: 1px solid rgba(116, 198, 157, 0.15);
    }

    .stat:last-child {
        border-right: none;
    }

    .stat-n {
        font-family: 'Playfair Display', serif;
        font-size: 1.9rem;
        font-weight: 900;
        color: var(--gold);
        line-height: 1;
    }

    .stat-l {
        font-size: .75rem;
        color: rgba(255, 255, 255, 0.52);
        margin-top: 4px;
        letter-spacing: .05em;
    }

    /* SECTION */
    .sec {
        padding: 88px 60px;
    }

    .sec-tag {
        display: inline-block;
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: var(--gb);
        background: rgba(64, 145, 108, 0.1);
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 12px;
    }

    .sec-title {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.8rem, 3.5vw, 2.7rem);
        font-weight: 900;
        line-height: 1.15;
        color: var(--gd);
        margin-bottom: 12px;
    }

    .sec-desc {
        font-size: 1rem;
        line-height: 1.75;
        color: #4a6258;
        max-width: 520px;
    }

    /* ABOUT */
    .about-inner {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: start;
        max-width: 1200px;
        margin: 0 auto;
    }

    .about-img {
        width: 100%;
        height: 360px;
        object-fit: cover;
        border-radius: 18px;
        box-shadow: 0 20px 56px rgba(26, 58, 42, 0.18);
    }

    .facts {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 24px;
    }

    .fact {
        background: var(--w);
        border-radius: 0 10px 10px 0;
        padding: 16px;
        border-left: 3px solid var(--gb);
        box-shadow: 0 3px 12px rgba(26, 58, 42, 0.07);
    }

    .fact h4 {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: var(--gb);
        margin-bottom: 4px;
    }

    .fact p {
        font-size: .9rem;
        color: var(--gd);
        font-weight: 600;
        margin: 0;
    }

    /* PETA */
    .peta-inner {
        max-width: 1200px;
        margin: 0 auto;
    }

    .peta-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 44px;
        align-items: start;
    }

    .peta-map-wrap {
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 16px 48px rgba(26, 58, 42, 0.15);
        position: relative;
    }

    .peta-map-wrap iframe {
        width: 100%;
        height: 400px;
        border: none;
        display: block;
    }

    .peta-map-label {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(26, 58, 42, 0.9);
        color: var(--gl);
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 50px;
        z-index: 2;
    }

    .desa-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .desa-card {
        background: var(--w);
        border-radius: 10px;
        padding: 13px 15px;
        border-top: 2px solid var(--gb);
        box-shadow: 0 2px 8px rgba(26, 58, 42, 0.07);
    }

    .desa-card .nama {
        font-size: .9rem;
        font-weight: 700;
        color: var(--gd);
        margin-bottom: 2px;
    }

    .desa-card .luas {
        font-size: .75rem;
        color: #5a7060;
    }

    .desa-card .tipe {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: var(--gb);
        margin-top: 4px;
    }

    /* CIRI KHAS */
    .ciri-header {
        text-align: center;
        max-width: 580px;
        margin: 0 auto 52px;
    }

    .ciri-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .ciri-card {
        background: rgba(255, 255, 255, 0.055);
        border: 1px solid rgba(116, 198, 157, 0.18);
        border-radius: 16px;
        padding: 32px 24px;
        border-top: 3px solid var(--gb);
        transition: all .3s;
    }

    .ciri-card:hover {
        background: rgba(255, 255, 255, 0.09);
        transform: translateY(-4px);
    }

    .ciri-icon {
        font-size: 2rem;
        margin-bottom: 16px;
        display: block;
    }

    .ciri-card h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        color: #fff;
        margin-bottom: 8px;
    }

    .ciri-card p {
        font-size: .87rem;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.56);
    }

    .ciri-fact {
        display: inline-block;
        margin-top: 12px;
        background: rgba(116, 198, 157, 0.15);
        color: var(--gl);
        font-size: .7rem;
        font-weight: 700;
        letter-spacing: .08em;
        padding: 4px 11px;
        border-radius: 50px;
    }

    /* PRODUK */
    .produk-filter {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 36px;
    }

    .filter-btn {
        font-size: .78rem;
        font-weight: 600;
        padding: 7px 18px;
        border-radius: 50px;
        border: 1.5px solid rgba(64, 145, 108, 0.3);
        background: transparent;
        color: var(--gm);
        cursor: pointer;
        transition: all .2s;
        text-decoration: none;
    }

    .filter-btn:hover,
    .filter-btn.active {
        background: var(--gb);
        color: #fff;
        border-color: var(--gb);
    }

    .produk-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .produk-card {
        background: var(--w);
        border-radius: 16px;
        overflow: hidden;
        transition: all .3s;
        box-shadow: 0 4px 16px rgba(26, 58, 42, 0.08);
    }

    .produk-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 40px rgba(26, 58, 42, 0.14);
    }

    .produk-card img {
        width: 100%;
        height: 170px;
        object-fit: cover;
    }

    .produk-body {
        padding: 16px;
    }

    .produk-cat {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: var(--gb);
        margin-bottom: 4px;
    }

    .produk-name {
        font-weight: 700;
        font-size: .92rem;
        color: var(--gd);
        margin-bottom: 4px;
    }

    .produk-prod {
        font-size: .75rem;
        color: #5a7060;
        margin-bottom: 5px;
    }

    .produk-price {
        font-family: 'Playfair Display', serif;
        font-size: 1.05rem;
        color: var(--gm);
        font-weight: 700;
    }

    .produk-btn {
        display: block;
        text-align: center;
        margin-top: 11px;
        background: var(--gp);
        color: var(--gd);
        padding: 8px;
        border-radius: 8px;
        text-decoration: none;
        font-size: .82rem;
        font-weight: 600;
        transition: all .2s;
    }

    .produk-btn:hover {
        background: var(--gb);
        color: #fff;
    }

    /* CTA */
    .cta-banner {
        background: linear-gradient(135deg, var(--gd) 0%, var(--gm) 60%, var(--gb) 100%);
        padding: 88px 60px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-banner::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 70% 50%, rgba(233, 196, 106, 0.12), transparent 60%);
    }

    .cta-banner h2 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(1.9rem, 5vw, 3.2rem);
        font-weight: 900;
        color: #fff;
        margin-bottom: 12px;
        position: relative;
    }

    .cta-banner p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.72);
        max-width: 480px;
        margin: 0 auto 36px;
        line-height: 1.72;
        position: relative;
    }

    .cta-btn {
        position: relative;
        background: var(--gold);
        color: var(--gd);
        padding: 14px 36px;
        border-radius: 50px;
        font-size: .93rem;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 8px 28px rgba(233, 196, 106, 0.4);
        display: inline-block;
        transition: all .2s;
    }

    .cta-btn:hover {
        background: #f0d080;
        transform: translateY(-3px);
    }

    /* FOOTER */
    .site-footer {
        background: #0f2318;
        padding: 52px 60px 24px;
    }

    .footer-top {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 40px;
        padding-bottom: 40px;
        border-bottom: 1px solid rgba(116, 198, 157, 0.12);
    }

    .footer-brand-desc {
        font-size: .86rem;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.42);
        margin-top: 10px;
        max-width: 240px;
    }

    .footer-col h4 {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--gl);
        margin-bottom: 16px;
    }

    .footer-col ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-col ul li {
        margin-bottom: 7px;
    }

    .footer-col ul li a {
        color: rgba(255, 255, 255, 0.42);
        text-decoration: none;
        font-size: .84rem;
        transition: color .2s;
    }

    .footer-col ul li a:hover {
        color: var(--gl);
    }

    .footer-bot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .footer-bot p {
        font-size: .78rem;
        color: rgba(255, 255, 255, 0.28);
        margin: 0;
    }

    .nav-logo-footer {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--gp);
        text-decoration: none;
    }

    .nav-logo-footer span {
        color: var(--gold);
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(24px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    @keyframes fadeDown {
        from {
            opacity: 0;
            transform: translateY(-14px)
        }

        to {
            opacity: 1;
            transform: translateY(0)
        }
    }

    @media(max-width:1024px) {
        .sec {
            padding: 64px 32px;
        }

        .about-inner,
        .peta-grid,
        .ciri-grid {
            grid-template-columns: 1fr;
        }

        .produk-grid {
            grid-template-columns: 1fr 1fr;
        }

        .stats {
            grid-template-columns: 1fr 1fr;
        }

        .footer-top {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width:640px) {
        .sec {
            padding: 48px 16px;
        }

        .produk-grid {
            grid-template-columns: 1fr 1fr;
        }

        .desa-grid {
            grid-template-columns: 1fr;
        }

        .stats {
            grid-template-columns: 1fr 1fr;
        }

        .footer-top {
            grid-template-columns: 1fr;
        }

        .hero-badge {
            display: none;
        }
    }
</style>

<!-- HERO -->
<div class="hero-section">
    <div class="hero-bg"></div>
    <div class="hero-badge">✦ Kec. Parigi, Kab. Pangandaran — Jawa Barat</div>
    <div class="hero-content">
        <p class="hero-eyebrow">Selamat Datang di</p>
        <h1 class="hero-title">Pesona <em>Alam & Produk</em><br>Kecamatan Parigi</h1>
        <p class="hero-sub">Kecamatan di ujung selatan Kabupaten Pangandaran, berbatasan langsung dengan Samudra Hindia. Rumah bagi 46.500 jiwa dengan kekayaan alam, pertanian, dan budaya lokal yang khas.</p>
        <div class="hero-actions">
            <a href="#tentang" class="btn-p">Kenali Parigi</a>
            <a href="<?= base_url('produk') ?>" class="btn-o">Lihat Produk Lokal</a>
        </div>
    </div>
    <div class="hero-scroll">
        <div class="scroll-line"></div>Scroll
    </div>
</div>

<!-- STATS -->
<div class="stats">
    <div class="stat">
        <div class="stat-n">100,1</div>
        <div class="stat-l">km² Luas Wilayah</div>
    </div>
    <div class="stat">
        <div class="stat-n">11</div>
        <div class="stat-l">Desa</div>
    </div>
    <div class="stat">
        <div class="stat-n">46,5rb</div>
        <div class="stat-l">Penduduk (2025)</div>
    </div>
    <div class="stat">
        <div class="stat-n">489</div>
        <div class="stat-l">jiwa/km² Kepadatan</div>
    </div>
</div>

<!-- TENTANG -->
<div class="sec" id="tentang" style="background:var(--cream)">
    <div class="about-inner">
        <div><img class="about-img" src="https://images.unsplash.com/photo-1596178060671-7a80dc8059ea?w=800&q=80" alt="Parigi" /></div>
        <div>
            <span class="sec-tag">Mengenal Daerah</span>
            <h2 class="sec-title">Kecamatan Parigi,<br>Gerbang Selatan Pangandaran</h2>
            <p class="sec-desc">Secara astronomis terletak antara 7°38'31.2" LS dan 108°30'39.6" BT. Berbatasan dengan Kec. Langkaplancar (Utara), Kec. Cijulang (Barat), Samudra Hindia (Selatan), dan Kec. Sidamulih (Timur). Jarak ke ibukota kabupaten hanya 0,2 km.</p>
            <div class="facts">
                <div class="fact">
                    <h4>Ibukota Kab.</h4>
                    <p>Pangandaran</p>
                </div>
                <div class="fact">
                    <h4>Provinsi</h4>
                    <p>Jawa Barat</p>
                </div>
                <div class="fact">
                    <h4>Jumlah RW / RT</h4>
                    <p>123 RW · 404 RT</p>
                </div>
                <div class="fact">
                    <h4>Batas Selatan</h4>
                    <p>Samudra Hindia</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PETA -->
<div class="sec" id="peta" style="background:#f4faf6">
    <div class="peta-inner">
        <div style="text-align:center;margin-bottom:44px">
            <span class="sec-tag">Peta Wilayah</span>
            <h2 class="sec-title">11 Desa di Kecamatan Parigi</h2>
            <p class="sec-desc" style="margin:0 auto;text-align:center">Total luas 100,149 km². Desa Selasari terluas (22,92 km²), Desa Cibenda terpadat.</p>
        </div>
        <div class="peta-grid">
            <div class="peta-map-wrap">
                <span class="peta-map-label">📍 Kec. Parigi, Pangandaran</span>
                <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=108.4200%2C-7.7200%2C108.6000%2C-7.5800&layer=mapnik&marker=-7.6500%2C108.4900" allowfullscreen loading="lazy"></iframe>
            </div>
            <div>
                <div class="desa-grid">
                    <?php foreach (
                        [
                            ['Karangjaladri', '3,549 km²', '🌊 Pesisir'],
                            ['Ciliang', '9,413 km²', '🌊 Pesisir'],
                            ['Cibenda', '7,593 km²', '🌊 Pesisir · Terpadat'],
                            ['Parigi', '3,327 km²', '🏛️ Ibukota Kec.'],
                            ['Selasari', '22,920 km²', '🏔️ Terluas'],
                            ['Cintaratu', '10,290 km²', '🌿 Bukan Pesisir'],
                            ['Cintakarya', '15,470 km²', '🌿 Bukan Pesisir'],
                            ['Parakanmanggu', '10,574 km²', '🌿 Bukan Pesisir'],
                            ['Karangbenda', '6,923 km²', '🌿 Bukan Pesisir'],
                            ['Bojong', '10,090 km²', '🌿 Bukan Pesisir'],
                        ] as $d
                    ): ?>
                        <div class="desa-card">
                            <div class="nama"><?= $d[0] ?></div>
                            <div class="luas"><?= $d[1] ?></div>
                            <div class="tipe"><?= $d[2] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CIRI KHAS -->
<div class="sec" id="ciri-khas" style="background:var(--gd)">
    <div class="ciri-header">
        <span class="sec-tag" style="background:rgba(116,198,157,0.15);color:var(--gl)">Ciri Khas Daerah</span>
        <h2 class="sec-title" style="color:#fff">Yang Membuat Parigi Unik</h2>
        <p class="sec-desc" style="margin:0 auto;color:rgba(255,255,255,0.55);text-align:center">Sumber: BPS Kecamatan Parigi Dalam Angka 2025</p>
    </div>
    <div class="ciri-grid">
        <?php foreach (
            [
                ['🌊', 'Pesisir Samudra Hindia', '3 desa berbatasan langsung dengan Samudra Hindia — Karangjaladri, Ciliang, Cibenda. Potensi wisata pantai dan perikanan tangkap yang besar.', '3 Desa Pesisir'],
                ['🌿', 'Kapulaga & Biofarmaka', 'Kapulaga 94.740 kg, jahe 24.000 kg, kunyit 19.500 kg, kencur 12.000 kg per tahun. Salah satu sentra biofarmaka Jawa Barat.', '94.740 kg/tahun'],
                ['🍌', 'Buah Lokal Unggulan', 'Pisang 2.640 kw, durian 1.083 kw, alpukat 751 kw per tahun. Tanaman buah tahunan jadi andalan warga desa pegunungan.', 'Buah Andalan'],
                ['🌶️', 'Sayuran & Hortikultura', 'Tomat 557 kw, cabai rawit 264 kw, cabai besar 150 kw, bawang merah 106 kw diproduksi tiap tahun.', 'Hortikultura Unggulan'],
                ['🏫', 'Pendidikan Lengkap', '35 SD, 6 SMP, 5 SMK, 1 SMA, 1 MA. Akses pendidikan TK hingga SMA sangat mudah di seluruh 11 desa.', '48+ Sekolah'],
                ['🛒', 'Perdagangan Aktif', '2 pasar permanen, 6 minimarket, 5 rumah makan, 4 bank pemerintah, 4 koperasi simpan pinjam aktif.', '6 Minimarket · 2 Pasar'],
            ] as $c
        ): ?>
            <div class="ciri-card">
                <span class="ciri-icon"><?= $c[0] ?></span>
                <h3><?= $c[1] ?></h3>
                <p><?= $c[2] ?></p>
                <span class="ciri-fact"><?= $c[3] ?></span>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- PRODUK KOMODITAS -->
<div class="sec" id="produk" style="background:var(--cream)">
    <div style="max-width:1200px;margin:0 auto">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;flex-wrap:wrap;gap:16px;margin-bottom:32px">
            <div>
                <span class="sec-tag">Marketplace Lokal</span>
                <h2 class="sec-title">Produk Unggulan Parigi</h2>
                <p class="sec-desc">Komoditas unggulan dari petani lokal Parigi — data produksi BPS 2024.</p>
            </div>
            <a href="<?= base_url('produk') ?>" class="btn-p" style="white-space:nowrap">Semua Produk →</a>
        </div>

        <!-- FILTER KATEGORI ESTETIK -->
        <div class="produk-filter" id="filterKategori">
            <a href="#" class="filter-btn active" data-cat="semua">🛒 Semua</a>
            <a href="#" class="filter-btn" data-cat="biofarmaka">🌿 Biofarmaka</a>
            <a href="#" class="filter-btn" data-cat="rempah">🫚 Rempah</a>
            <a href="#" class="filter-btn" data-cat="buah">🍌 Buah-buahan</a>
            <a href="#" class="filter-btn" data-cat="sayuran">🌶️ Sayuran</a>
        </div>

        <div class="produk-grid" id="produkGrid">
            <?php
            $komoditas = [
                ['biofarmaka', 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400&q=80', 'Biofarmaka', 'Kapulaga Segar', 'Prod. 94.740 kg/thn', 'Rp 45.000/kg'],
                ['rempah', 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400&q=80', 'Rempah', 'Jahe Segar', 'Prod. 24.000 kg/thn', 'Rp 18.000/kg'],
                ['rempah', 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400&q=80', 'Rempah', 'Kunyit Segar', 'Prod. 19.500 kg/thn', 'Rp 12.000/kg'],
                ['rempah', 'https://images.unsplash.com/photo-1599909313208-3f9c08b11af5?w=400&q=80', 'Rempah', 'Kencur', 'Prod. 12.000 kg/thn', 'Rp 20.000/kg'],
                ['buah', 'https://images.unsplash.com/photo-1602201130723-9f78e41d70c5?w=400&q=80', 'Buah-buahan', 'Durian Lokal', 'Prod. 1.083 kw/thn', 'Rp 35.000/buah'],
                ['buah', 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400&q=80', 'Buah-buahan', 'Pisang Lokal', 'Prod. 2.640 kw/thn', 'Rp 8.000/sisir'],
                ['buah', 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400&q=80', 'Buah-buahan', 'Alpukat', 'Prod. 751 kw/thn', 'Rp 15.000/buah'],
                ['sayuran', 'https://images.unsplash.com/photo-1558818498-28c1e002b655?w=400&q=80', 'Sayuran', 'Tomat Segar', 'Prod. 557 kw/thn', 'Rp 8.000/kg'],
                ['sayuran', 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', 'Sayuran', 'Cabai Rawit', 'Prod. 264 kw/thn', 'Rp 30.000/kg'],
                ['sayuran', 'https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?w=400&q=80', 'Sayuran', 'Cabai Besar', 'Prod. 150 kw/thn', 'Rp 22.000/kg'],
                ['sayuran', 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400&q=80', 'Sayuran', 'Bawang Merah', 'Prod. 106 kw/thn', 'Rp 25.000/kg'],
                ['buah', 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400&q=80', 'Buah-buahan', 'Pepaya', 'Prod. 14 kw/thn', 'Rp 6.000/kg'],
            ];
            foreach ($komoditas as $k): ?>
                <div class="produk-card" data-cat="<?= $k[0] ?>">
                    <img src="<?= $k[1] ?>" onerror="this.src='https://placehold.co/400x300/e8f5e9/2e7d32?text=<?= urlencode($k[3]) ?>'" />
                    <div class="produk-body">
                        <div class="produk-cat"><?= $k[2] ?></div>
                        <div class="produk-name"><?= $k[3] ?></div>
                        <div class="produk-prod"><?= $k[4] ?></div>
                        <div class="produk-price"><?= $k[5] ?></div>
                        <a href="<?= base_url('produk?kategori=' . urlencode($k[2])) ?>" class="produk-btn">Cari di Marketplace</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- CTA -->
<div class="cta-banner">
    <h2>Dukung Produk Lokal Parigi,<br>Bangkitkan Ekonomi Daerah</h2>
    <p>Bergabunglah dan dukung UMKM serta petani lokal Kecamatan Parigi, Pangandaran.</p>
    <a href="<?= base_url('produk') ?>" class="cta-btn">Mulai Belanja Sekarang →</a>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-top">
        <div>
            <a href="<?= base_url() ?>" class="nav-logo-footer">🌿 Parigi<span>Market</span></a>
            <p class="footer-brand-desc">Platform marketplace digital produk lokal Kecamatan Parigi, Kabupaten Pangandaran, Jawa Barat.</p>
        </div>
        <div class="footer-col">
            <h4>Navigasi</h4>
            <ul>
                <li><a href="#tentang">Tentang Parigi</a></li>
                <li><a href="#peta">Peta Wilayah</a></li>
                <li><a href="#ciri-khas">Ciri Khas</a></li>
                <li><a href="#produk">Produk Lokal</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Marketplace</h4>
            <ul>
                <li><a href="<?= base_url('produk') ?>">Semua Produk</a></li>
                <li><a href="<?= base_url('register') ?>">Daftar Penjual</a></li>
                <li><a href="<?= base_url('login') ?>">Masuk</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Kontak</h4>
            <ul>
                <li><a href="#">Parigi, Pangandaran — Jabar</a></li>
                <li><a href="#">info@parigimarket.id</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bot">
        <p>© 2025 Parigi Market. Hak cipta dilindungi.</p>
        <p>Data: BPS Kecamatan Parigi Dalam Angka 2025</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('#filterKategori .filter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('#filterKategori .filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cat = this.dataset.cat;
            document.querySelectorAll('#produkGrid .produk-card').forEach(card => {
                card.style.display = (cat === 'semua' || card.dataset.cat === cat) ? 'block' : 'none';
            });
        });
    });
</script>

<?php include APPPATH . 'Views/templates/footer.php'; ?>