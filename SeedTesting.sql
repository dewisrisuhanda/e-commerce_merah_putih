INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
    (1, 'Biofarmaka',     'biofarmaka',     NOW(), NOW()),
    (2, 'Buah-buahan',    'buah-buahan',    NOW(), NOW()),
    (3, 'Hasil Tani',     'hasil-tani',     NOW(), NOW()),
    (4, 'Hasil Laut',     'hasil-laut',     NOW(), NOW()),
    (5, 'Oleh-oleh',      'oleh-oleh',      NOW(), NOW()),
    (6, 'Produk Olahan',  'produk-olahan',  NOW(), NOW());



INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `price`, `quantity`, `description`, `status`, `created_at`, `updated_at`) VALUES
-- Biofarmaka (category_id = 1)
(1,  1, 'Kapulaga Segar Parigi',  'kapulaga-segar-parigi',  45000,  200, 'Kapulaga segar langsung dari kebun petani Kec. Parigi. Produksi 94.740 kg/tahun. Aroma kuat, biji penuh.',         'ready', NOW(), NOW()),
(2,  1, 'Jahe Merah Segar',       'jahe-merah-segar',       18000,  180, 'Jahe merah organik dari ladang Parigi. Produksi 24.000 kg/tahun. Kandungan gingerol tinggi.',                        'ready', NOW(), NOW()),
(3,  1, 'Kunyit Segar Parigi',    'kunyit-segar-parigi',    12000,  200, 'Kunyit basah warna kuning cerah dari kebun Parigi. Produksi 19.500 kg/tahun. Kurkumin tinggi.',                     'ready', NOW(), NOW()),
(4,  1, 'Kencur Segar',           'kencur-segar',           20000,  150, 'Kencur segar dari petani Parigi. Produksi 12.000 kg/tahun. Cocok untuk jamu dan masakan.',                          'ready', NOW(), NOW()),
(5,  1, 'Lengkuas Segar',         'lengkuas-segar',         10000,  159, 'Lengkuas bongkahan besar dari Parigi. Produksi 21.000 kg/tahun. Segar dan harum.',                                  'ready', NOW(), NOW()),
(6,  1, 'Jahe Putih Kering',      'jahe-putih-kering',      22000,  120, 'Jahe putih dikeringkan alami dari petani Parigi. Tahan lama, siap seduh sebagai minuman kesehatan.',                'ready', NOW(), NOW()),

-- Buah-buahan (category_id = 2)
(7,  2, 'Pisang Kepok Segar',     'pisang-kepok-segar',     8000,   296, 'Pisang kepok kuning matang dari kebun Parigi. Produksi 2.640 kw/tahun. 1 sisir isi 12-15 buah.',                   'ready', NOW(), NOW()),
(8,  2, 'Durian Lokal Parigi',    'durian-lokal-parigi',    35000,  60,  'Durian lokal dari kebun Parigi. Produksi 1.083 kw/tahun. Daging tebal kuning keemasan.',                            'ready', NOW(), NOW()),
(9,  2, 'Alpukat Parigi',         'alpukat-parigi',         15000,  180, 'Alpukat segar dari pohon buah Parigi. Produksi 751 kw/tahun. Daging creamy dan lezat.',                             'ready', NOW(), NOW()),
(10, 2, 'Pepaya California',      'pepaya-california',      8000,   139, 'Pepaya manis dari kebun Parigi. Produksi 14 kw/tahun. Daging oranye tebal dan menyegarkan.',                        'ready', NOW(), NOW()),
(11, 2, 'Mangga Gedong',          'mangga-gedong',          20000,  90,  'Mangga gedong harum dari Parigi. Produksi 27 kw/tahun. Daging kuning cerah, manis legit.',                          'ready', NOW(), NOW()),
(12, 2, 'Pisang Ambon',           'pisang-ambon',           7000,   200, 'Pisang ambon kuning segar dari petani Parigi. Tekstur lembut, rasa manis.',                                         'ready', NOW(), NOW()),

-- Hasil Tani (category_id = 3)
(13, 3, 'Tomat Segar Parigi',     'tomat-segar-parigi',     8000,   160, 'Tomat segar dari petani Parigi. Produksi 557 kw/tahun. Merah segar, asam manis.',                                  'ready', NOW(), NOW()),
(14, 3, 'Cabai Rawit Merah',      'cabai-rawit-merah',      30000,  80,  'Cabai rawit ekstra pedas dari Parigi. Produksi 264 kw/tahun. Dipetik segar setiap pagi.',                          'ready', NOW(), NOW()),
(15, 3, 'Cabai Besar Keriting',   'cabai-besar-keriting',   22000,  100, 'Cabai besar merah keriting dari kebun Parigi. Produksi 150 kw/tahun. Pedas sedang.',                               'ready', NOW(), NOW()),
(16, 3, 'Bawang Merah Parigi',    'bawang-merah-parigi',    25000,  120, 'Bawang merah kering dari petani Parigi. Produksi 106 kw/tahun. Umbi besar, aroma tajam.',                          'ready', NOW(), NOW()),
(17, 3, 'Kangkung Segar',         'kangkung-segar',         5000,   200, 'Kangkung segar petik pagi dari kebun Parigi. Batang renyah, daun hijau segar.',                                    'ready', NOW(), NOW()),
(18, 3, 'Kacang Panjang',         'kacang-panjang',         8000,   150, 'Kacang panjang muda dari petani Parigi. Hijau segar, empuk, cocok untuk tumis.',                                   'ready', NOW(), NOW()),

-- Hasil Laut (category_id = 4)
(19, 4, 'Ikan Tongkol Segar',     'ikan-tongkol-segar',     35000,  100, 'Tongkol segar tangkapan nelayan pesisir Parigi. Didaratkan pagi hari. Daging tebal dan segar.',                   'ready', NOW(), NOW()),
(20, 4, 'Ikan Kakap Merah',       'ikan-kakap-merah',       85000,  40,  'Kakap merah segar dari perairan Desa Cibenda dan Ciliang Parigi. Daging putih lembut, 1-2 kg/ekor.',               'ready', NOW(), NOW()),
(21, 4, 'Ikan Kembung Segar',     'ikan-kembung-segar',     25000,  130, 'Ikan kembung segar dari nelayan Karangjaladri. Kaya omega-3, cocok untuk digoreng atau dibakar.',                  'ready', NOW(), NOW()),
(22, 4, 'Udang Segar Parigi',     'udang-segar-parigi',     65000,  70,  'Udang segar dari perairan pesisir Parigi. Ukuran 30-40 ekor/kg. Segar dan kenyal.',                                'ready', NOW(), NOW()),
(23, 4, 'Cumi-cumi Segar',        'cumi-cumi-segar',        50000,  60,  'Cumi segar dari perairan Parigi. Daging putih bersih. Cocok untuk cumi saus tiram atau bakar.',                    'ready', NOW(), NOW()),
(24, 4, 'Kepiting Bakau',         'kepiting-bakau',         115000, 25,  'Kepiting bakau dari hutan mangrove pesisir Parigi. Ukuran 400-600 gram/ekor. Daging padat.',                       'ready', NOW(), NOW()),
(25, 4, 'Ikan Layur Segar',       'ikan-layur-segar',       30000,  90,  'Ikan layur putih panjang dari tangkapan malam nelayan Parigi. Cocok digoreng tepung.',                             'ready', NOW(), NOW()),
(26, 4, 'Lobster Bambu',          'lobster-bambu',          250000, 15,  'Lobster bambu segar dari perairan Parigi Selatan. Ukuran 300-500 gram. Daging manis dan lembut.',                  'ready', NOW(), NOW()),

-- Oleh-oleh (category_id = 5)
(27, 5, 'Abon Ikan Tongkol',      'abon-ikan-tongkol',      35000,  200, 'Abon ikan tongkol khas nelayan Parigi. Tanpa MSG, kemasan 200 gram. Gurih dan tahan lama.',                       'ready', NOW(), NOW()),
(28, 5, 'Keripik Pisang Coklat',  'keripik-pisang-coklat',  18000,  250, 'Keripik pisang kepok dari Parigi dengan balutan coklat. Renyah dan manis. Kemasan 200 gram.',                     'ready', NOW(), NOW()),
(29, 5, 'Dodol Durian Parigi',    'dodol-durian-parigi',    45000,  120, 'Dodol tradisional isian durian lokal Parigi. Tanpa pewarna. Kemasan 500 gram.',                                    'ready', NOW(), NOW()),
(30, 5, 'Madu Hutan Parigi',      'madu-hutan-parigi',      90000,  80,  'Madu murni dari lebah liar hutan Parigi. Botol 350 ml. Warna amber keemasan.',                                    'ready', NOW(), NOW()),
(31, 5, 'Gula Aren Asli',         'gula-aren-asli',         28000,  200, 'Gula aren murni dari nira enau petani Parigi. Kemasan 500 gram.',                                                  'ready', NOW(), NOW()),

-- Produk Olahan (category_id = 6)
(32, 6, 'VCO Minyak Kelapa Murni','vco-minyak-kelapa-murni',60000,  100, 'Virgin coconut oil cold-pressed dari kelapa lokal Parigi. Botol kaca 250 ml. Murni tanpa campuran.',               'ready', NOW(), NOW()),
(33, 6, 'Tepung Tapioka',         'tepung-tapioka',         12000,  300, 'Tepung tapioka putih bersih dari singkong lokal Parigi. Kemasan 1 kg.',                                            'ready', NOW(), NOW()),
(34, 6, 'Sambal Roa Parigi',      'sambal-roa-parigi',      30000,  160, 'Sambal roa khas Parigi dari ikan fufu asap. Resep turun-temurun. Kemasan 150 gram.',                               'ready', NOW(), NOW());




INSERT INTO `product_images` (`product_id`, `url`, `is_primary`, `order`, `created_at`, `updated_at`) VALUES
    (1,  'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400', true, 0, NOW(), NOW()),
    (2,  'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400', true, 0, NOW(), NOW()),
    (3,  'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400', true, 0, NOW(), NOW()),
    (4,  'https://images.unsplash.com/photo-1599940778173-e276d4acb2bb?w=400', true, 0, NOW(), NOW()),
    (5,  'https://images.unsplash.com/photo-1599940778173-e276d4acb2bb?w=400', true, 0, NOW(), NOW()),
    (6,  'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400', true, 0, NOW(), NOW()),
    (7,  'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400', true, 0, NOW(), NOW()),
    (8,  'https://images.unsplash.com/photo-1602201130723-9f78e41d70c5?w=400', true, 0, NOW(), NOW()),
    (9,  'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400', true, 0, NOW(), NOW()),
    (10, 'https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=400', true, 0, NOW(), NOW()),
    (11, 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400', true, 0, NOW(), NOW()),
    (12, 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400', true, 0, NOW(), NOW()),
    (13, 'https://images.unsplash.com/photo-1558818498-28c1e002b655?w=400', true, 0, NOW(), NOW()),
    (14, 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400', true, 0, NOW(), NOW()),
    (15, 'https://images.unsplash.com/photo-1583119022894-919a68a3d0e3?w=400', true, 0, NOW(), NOW()),
    (16, 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400', true, 0, NOW(), NOW()),
    (17, 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400', true, 0, NOW(), NOW()),
    (18, 'https://images.unsplash.com/photo-1567337710282-00832b415979?w=400', true, 0, NOW(), NOW()),
    (19, 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=400', true, 0, NOW(), NOW()),
    (20, 'https://images.unsplash.com/photo-1611171711912-e3f5b1561e9b?w=400', true, 0, NOW(), NOW()),
    (21, 'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=400', true, 0, NOW(), NOW()),
    (22, 'https://images.unsplash.com/photo-1565680018093-ebb6b9ab5460?w=400', true, 0, NOW(), NOW()),
    (23, 'https://images.unsplash.com/photo-1563557717-8e680e985e44?w=400', true, 0, NOW(), NOW()),
    (24, 'https://images.unsplash.com/photo-1555951015-6da899b5c2cd?w=400', true, 0, NOW(), NOW()),
    (25, 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400', true, 0, NOW(), NOW()),
    (26, 'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=400', true, 0, NOW(), NOW()),
    (27, 'https://images.unsplash.com/photo-1606787364406-a3cdf06c6d0c?w=400', true, 0, NOW(), NOW()),
    (28, 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400', true, 0, NOW(), NOW()),
    (29, 'https://images.unsplash.com/photo-1567206563114-c179900d98b8?w=400', true, 0, NOW(), NOW()),
    (30, 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=400', true, 0, NOW(), NOW()),
    (31, 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=400', true, 0, NOW(), NOW()),
    (32, 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400', true, 0, NOW(), NOW()),
    (33, 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400', true, 0, NOW(), NOW()),
    (34, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400', true, 0, NOW(), NOW());


INSERT INTO `shipping_methods` (`id`, `name`, `code`, `description`, `active`, `created_at`, `updated_at`) VALUES
   (1, 'Antar ke Alamat', 'antar', 'Pengiriman langsung ke alamat pembeli.',  true, NOW(), NOW()),
   (2, 'Ambil di Toko',   'ambil', 'Pembeli mengambil sendiri di toko/gudang.', true, NOW(), NOW());


INSERT INTO `payment_methods` (`id`, `name`, `code`, `description`, `active`, `created_at`, `updated_at`) VALUES
  (1, 'Tunai (Cash)',        'cash',   'Bayar tunai saat barang diterima (COD) atau di toko.', true, NOW(), NOW()),
  (2, 'Kartu Kredit/Debit', 'credit', 'Pembayaran menggunakan kartu kredit atau debit.',       true, NOW(), NOW());


INSERT INTO `orders` (
    `id`, `order_number`, `user_id`,
    `shipping_method_id`, `payment_method_id`,
    `address`, `subtotal`, `shipping_cost`, `total_amount`,
    `status`, `created_at`, `updated_at`
) VALUES
      (1,  'INV-20260315-0001', 2, 1, 1, NULL,                        18000,  0, 18000,  'canceled',        '2026-03-15 12:40:05', '2026-03-15 12:40:05'),
      (2,  'INV-20260310-0002', 2, 1, 1, 'Jl. Veteran No.12, Palu',  200000, 0, 200000, 'completed',       '2026-03-10 09:00:00', '2026-03-10 09:00:00'),
      (4,  'INV-20260313-0004', 2, 2, 2, 'Ambil di Toko',            105000, 0, 105000, 'processing',      '2026-03-13 10:15:00', '2026-03-13 10:15:00'),
      (7,  'INV-20260317-0007', 2, 1, 1, NULL,                        45000,  0, 45000,  'processing',      '2026-03-17 09:03:58', '2026-03-17 09:03:58'),
      (8,  'INV-20260327-0008', 2, 1, 1, NULL,                        10000,  0, 10000,  'completed',       '2026-03-27 10:30:13', '2026-03-27 10:30:13'),
      (9,  'INV-20260327-0009', 2, 1, 1, NULL,                        8000,   0, 8000,   'completed',       '2026-03-27 10:31:28', '2026-03-27 10:31:28'),
      (10, 'INV-20260327-0010', 2, 1, 1, NULL,                        8000,   0, 8000,   'pending_payment', '2026-03-27 10:34:30', '2026-03-27 10:34:30');


INSERT INTO `order_details` (
    `order_id`, `product_id`,
    `product_name`, `product_price`,
    `quantity`, `subtotal`,
    `created_at`, `updated_at`
) VALUES
      (8,  5,  'Lengkuas Segar',    10000, 1, 10000, NOW(), NOW()),
      (9,  7,  'Pisang Kepok Segar', 8000, 1,  8000, NOW(), NOW()),
      (10, 10, 'Pepaya California',  8000, 1,  8000, NOW(), NOW());

select * from payments;
select * from orders;
select * from order_details;
