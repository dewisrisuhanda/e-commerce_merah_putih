-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2026 at 05:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parigi_marketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `id_produk` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_pesanan`, `id_produk`, `jumlah`, `harga`) VALUES
(1, 8, 5, 1, 10000),
(2, 9, 7, 1, 8000),
(3, 10, 10, 1, 8000);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `metode_bayar` varchar(30) DEFAULT 'cash',
  `metode_kirim` varchar(30) DEFAULT 'antar',
  `alamat_kirim` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tanggal`, `status`, `total_harga`, `metode_bayar`, `metode_kirim`, `alamat_kirim`) VALUES
(1, 3, '2026-03-15 12:40:05', 'dibatalkan', 18000, 'cash', 'antar', NULL),
(2, 3, '2026-03-10 09:00:00', 'selesai', 200000, 'cash', 'antar', 'Jl. Veteran No.12, Palu'),
(4, 3, '2026-03-13 10:15:00', 'diproses', 105000, 'credit', 'ambil', 'Ambil di Toko'),
(7, 3, '2026-03-17 09:03:58', 'diproses', 45000, 'cash', 'antar', NULL),
(8, 3, '2026-03-27 10:30:13', 'selesai', 10000, 'cash', 'antar', NULL),
(9, 3, '2026-03-27 10:31:28', 'selesai', 8000, 'cash', 'antar', NULL),
(10, 3, '2026-03-27 10:34:30', 'pending', 8000, 'cash', 'antar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT 'Lainnya',
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `id_penjual` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori`, `harga`, `stok`, `foto`, `deskripsi`, `id_penjual`) VALUES
(1, 'Kapulaga Segar Parigi', 'Biofarmaka', 45000, 200, 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=400', 'Kapulaga segar langsung dari kebun petani Kec. Parigi. Produksi 94.740 kg/tahun. Aroma kuat, biji penuh.', 1),
(2, 'Jahe Merah Segar', 'Biofarmaka', 18000, 180, 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400', 'Jahe merah organik dari ladang Parigi. Produksi 24.000 kg/tahun. Kandungan gingerol tinggi.', 1),
(3, 'Kunyit Segar Parigi', 'Biofarmaka', 12000, 200, 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?w=400', 'Kunyit basah warna kuning cerah dari kebun Parigi. Produksi 19.500 kg/tahun. Kurkumin tinggi.', 1),
(4, 'Kencur Segar', 'Biofarmaka', 20000, 150, 'https://images.unsplash.com/photo-1599940778173-e276d4acb2bb?w=400', 'Kencur segar dari petani Parigi. Produksi 12.000 kg/tahun. Cocok untuk jamu dan masakan.', 1),
(5, 'Lengkuas Segar', 'Biofarmaka', 10000, 159, 'https://images.unsplash.com/photo-1599940778173-e276d4acb2bb?w=400', 'Lengkuas bongkahan besar dari Parigi. Produksi 21.000 kg/tahun. Segar dan harum.', 1),
(6, 'Jahe Putih Kering', 'Biofarmaka', 22000, 120, 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=400', 'Jahe putih dikeringkan alami dari petani Parigi. Tahan lama, siap seduh sebagai minuman kesehatan.', 1),
(7, 'Pisang Kepok Segar', 'Buah-buahan', 8000, 296, 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=400', 'Pisang kepok kuning matang dari kebun Parigi. Produksi 2.640 kw/tahun. 1 sisir isi 12-15 buah.', 1),
(8, 'Durian Lokal Parigi', 'Buah-buahan', 35000, 60, 'https://images.unsplash.com/photo-1602201130723-9f78e41d70c5?w=400', 'Durian lokal dari kebun Parigi. Produksi 1.083 kw/tahun. Daging tebal kuning keemasan.', 1),
(9, 'Alpukat Parigi', 'Buah-buahan', 15000, 180, 'https://images.unsplash.com/photo-1619566636858-adf3ef46400b?w=400', 'Alpukat segar dari pohon buah Parigi. Produksi 751 kw/tahun. Daging creamy dan lezat.', 1),
(10, 'Pepaya California', 'Buah-buahan', 8000, 139, 'https://images.unsplash.com/photo-1526318472351-c75fcf070305?w=400', 'Pepaya manis dari kebun Parigi. Produksi 14 kw/tahun. Daging oranye tebal dan menyegarkan.', 1),
(11, 'Mangga Gedong', 'Buah-buahan', 20000, 90, 'https://images.unsplash.com/photo-1553279768-865429fa0078?w=400', 'Mangga gedong harum dari Parigi. Produksi 27 kw/tahun. Daging kuning cerah, manis legit.', 1),
(12, 'Pisang Ambon', 'Buah-buahan', 7000, 200, 'https://images.unsplash.com/photo-1528825871115-3581a5387919?w=400', 'Pisang ambon kuning segar dari petani Parigi. Tekstur lembut, rasa manis.', 1),
(13, 'Tomat Segar Parigi', 'Hasil Tani', 8000, 160, 'https://images.unsplash.com/photo-1558818498-28c1e002b655?w=400', 'Tomat segar dari petani Parigi. Produksi 557 kw/tahun. Merah segar, asam manis.', 1),
(14, 'Cabai Rawit Merah', 'Hasil Tani', 30000, 80, 'https://images.unsplash.com/photo-1601004890657-77e09e8fb064?w=400', 'Cabai rawit ekstra pedas dari Parigi. Produksi 264 kw/tahun. Dipetik segar setiap pagi.', 1),
(15, 'Cabai Besar Keriting', 'Hasil Tani', 22000, 100, 'https://images.unsplash.com/photo-1583119022894-919a68a3d0e3?w=400', 'Cabai besar merah keriting dari kebun Parigi. Produksi 150 kw/tahun. Pedas sedang.', 1),
(16, 'Bawang Merah Parigi', 'Hasil Tani', 25000, 120, 'https://images.unsplash.com/photo-1587735243615-c03f25aaff15?w=400', 'Bawang merah kering dari petani Parigi. Produksi 106 kw/tahun. Umbi besar, aroma tajam.', 1),
(17, 'Kangkung Segar', 'Hasil Tani', 5000, 200, 'https://images.unsplash.com/photo-1576045057995-568f588f82fb?w=400', 'Kangkung segar petik pagi dari kebun Parigi. Batang renyah, daun hijau segar.', 1),
(18, 'Kacang Panjang', 'Hasil Tani', 8000, 150, 'https://images.unsplash.com/photo-1567337710282-00832b415979?w=400', 'Kacang panjang muda dari petani Parigi. Hijau segar, empuk, cocok untuk tumis.', 1),
(19, 'Ikan Tongkol Segar', 'Hasil Laut', 35000, 100, 'https://images.unsplash.com/photo-1534482421-64566f976cfa?w=400', 'Tongkol segar tangkapan nelayan pesisir Parigi. Didaratkan pagi hari. Daging tebal dan segar.', 1),
(20, 'Ikan Kakap Merah', 'Hasil Laut', 85000, 40, 'https://images.unsplash.com/photo-1611171711912-e3f5b1561e9b?w=400', 'Kakap merah segar dari perairan Desa Cibenda dan Ciliang Parigi. Daging putih lembut, 1-2 kg/ekor.', 1),
(21, 'Ikan Kembung Segar', 'Hasil Laut', 25000, 130, 'https://images.unsplash.com/photo-1559737558-2f5a35f4523b?w=400', 'Ikan kembung segar dari nelayan Karangjaladri. Kaya omega-3, cocok untuk digoreng atau dibakar.', 1),
(22, 'Udang Segar Parigi', 'Hasil Laut', 65000, 70, 'https://images.unsplash.com/photo-1565680018093-ebb6b9ab5460?w=400', 'Udang segar dari perairan pesisir Parigi. Ukuran 30-40 ekor/kg. Segar dan kenyal.', 1),
(23, 'Cumi-cumi Segar', 'Hasil Laut', 50000, 60, 'https://images.unsplash.com/photo-1563557717-8e680e985e44?w=400', 'Cumi segar dari perairan Parigi. Daging putih bersih. Cocok untuk cumi saus tiram atau bakar.', 1),
(24, 'Kepiting Bakau', 'Hasil Laut', 115000, 25, 'https://images.unsplash.com/photo-1555951015-6da899b5c2cd?w=400', 'Kepiting bakau dari hutan mangrove pesisir Parigi. Ukuran 400-600 gram/ekor. Daging padat.', 1),
(25, 'Ikan Layur Segar', 'Hasil Laut', 30000, 90, 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400', 'Ikan layur putih panjang dari tangkapan malam nelayan Parigi. Cocok digoreng tepung.', 1),
(26, 'Lobster Bambu', 'Hasil Laut', 250000, 15, 'https://images.unsplash.com/photo-1510130387422-82bed34b37e9?w=400', 'Lobster bambu segar dari perairan Parigi Selatan. Ukuran 300-500 gram. Daging manis dan lembut.', 1),
(27, 'Abon Ikan Tongkol', 'Oleh-oleh', 35000, 200, 'https://images.unsplash.com/photo-1606787364406-a3cdf06c6d0c?w=400', 'Abon ikan tongkol khas nelayan Parigi. Tanpa MSG, kemasan 200 gram. Gurih dan tahan lama.', 1),
(28, 'Keripik Pisang Coklat', 'Oleh-oleh', 18000, 250, 'https://images.unsplash.com/photo-1621939514649-280e2ee25f60?w=400', 'Keripik pisang kepok dari Parigi dengan balutan coklat. Renyah dan manis. Kemasan 200 gram.', 1),
(29, 'Dodol Durian Parigi', 'Oleh-oleh', 45000, 120, 'https://images.unsplash.com/photo-1567206563114-c179900d98b8?w=400', 'Dodol tradisional isian durian lokal Parigi. Tanpa pewarna. Kemasan 500 gram.', 1),
(30, 'Madu Hutan Parigi', 'Oleh-oleh', 90000, 80, 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=400', 'Madu murni dari lebah liar hutan Parigi. Botol 350 ml. Warna amber keemasan.', 1),
(31, 'Gula Aren Asli', 'Oleh-oleh', 28000, 200, 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?w=400', 'Gula aren murni dari nira enau petani Parigi. Kemasan 500 gram.', 1),
(32, 'VCO Minyak Kelapa Murni', 'Produk Olahan', 60000, 100, 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=400', 'Virgin coconut oil cold-pressed dari kelapa lokal Parigi. Botol kaca 250 ml. Murni tanpa campuran.', 1),
(33, 'Tepung Tapioka', 'Produk Olahan', 12000, 300, 'https://images.unsplash.com/photo-1574323347407-f5e1ad6d020b?w=400', 'Tepung tapioka putih bersih dari singkong lokal Parigi. Kemasan 1 kg.', 1),
(34, 'Sambal Roa Parigi', 'Produk Olahan', 30000, 160, 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=400', 'Sambal roa khas Parigi dari ikan fufu asap. Resep turun-temurun. Kemasan 150 gram.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `alamat`) VALUES
(3, 'Dewi Sri Suhanda', 'dewi.suhanda@widyatama.ac.id', '$2y$10$Swjs4ecslgYYOQl/mGp5Vulmn/MoWG8tqvHiomVk7tB/m2FYsx2zG', 'admin', 'Parigi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
