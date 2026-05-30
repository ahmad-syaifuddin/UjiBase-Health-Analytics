-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 30, 2026 at 10:17 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ujibase_health`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int NOT NULL,
  `transaksi_id` int NOT NULL,
  `obat_id` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `obat_id`, `jumlah`, `harga_jual`, `subtotal`) VALUES
(1, 1, 1, 2, 5000.00, 10000.00),
(2, 2, 4, 2, 7000.00, 14000.00),
(3, 3, 3, 1, 4000.00, 4000.00);

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int NOT NULL,
  `nama_dokter` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `spesialisasi` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `nama_dokter`, `spesialisasi`, `telepon`) VALUES
(1, 'dr. Budi Santoso', 'Dokter Umum', '081234567890');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Kategori Obat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(1, 'Analgesik & Antipiretik'),
(2, 'Antibiotik'),
(3, 'Obat Saluran Cerna'),
(4, 'Vitamin & Suplemen'),
(5, 'Obat Kardiovaskuler'),
(6, 'Anti viruss');

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `supplier_id` int NOT NULL,
  `kode_obat` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_obat` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `satuan` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `stok` int NOT NULL DEFAULT '0',
  `stok_minimum` int NOT NULL DEFAULT '10',
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `expired_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `kategori_id`, `supplier_id`, `kode_obat`, `nama_obat`, `satuan`, `stok`, `stok_minimum`, `harga_beli`, `harga_jual`, `expired_date`) VALUES
(1, 1, 1, 'OBT-001', 'Paracetamol 500mg', 'Strip', 50, 20, 3000.00, 5000.00, '2027-12-31'),
(2, 2, 2, 'OBT-002', 'Amoxicillin 500mg', 'Strip', 5, 10, 5000.00, 8000.00, '2026-10-15'),
(3, 3, 1, 'OBT-003', 'Antasida Doen', 'Tablet', 99, 15, 2000.00, 4000.00, '2028-01-01'),
(4, 5, 2, 'OBT-004', 'Amlodipine 5mg', 'Strip', 30, 10, 4000.00, 7000.00, '2027-05-20'),
(5, 1, 2, 'OBT-005', 'Antimo', 'Tablet', 10, 10, 12000.00, 13500.00, '2030-10-30');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id` int NOT NULL,
  `no_identitas` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_pasien` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_general_ci,
  `tanggal_daftar` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pasien`
--

INSERT INTO `pasien` (`id`, `no_identitas`, `nama_pasien`, `telepon`, `alamat`, `tanggal_daftar`) VALUES
(1, '3578012345678901', 'Dimas', '085611223344', 'Jl. Kenangan No. 10', '2026-05-01'),
(2, '3578012345678902', 'Budi Santoso', '085622334455', 'Jl. Melati No. 5', '2026-05-15'),
(3, '6329038290382032', 'Pasien 1', '081234853', 'Banjar', '2026-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `penyakit`
--

CREATE TABLE `penyakit` (
  `id` int NOT NULL,
  `kode_icd` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_penyakit` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyakit`
--

INSERT INTO `penyakit` (`id`, `kode_icd`, `nama_penyakit`, `deskripsi`) VALUES
(1, 'J10', 'Influenza', 'Infeksi pernapasan akibat virus'),
(2, 'I10', 'Hipertensi', 'Tekanan darah tinggi'),
(3, 'A09', 'Gastroenteritis (GEA)', 'Peradangan saluran pencernaan'),
(4, 'E56', 'Defisiensi Vitamin', 'Kekurangan asupan vitamin esensial'),
(5, 'ES4', 'HIV', 'entah lah.....');

-- --------------------------------------------------------

--
-- Table structure for table `resep`
--

CREATE TABLE `resep` (
  `id` int NOT NULL,
  `pasien_id` int NOT NULL,
  `penyakit_id` int NOT NULL,
  `tanggal_resep` date NOT NULL,
  `status_resep` enum('Menunggu','Diproses','Selesai') COLLATE utf8mb4_general_ci DEFAULT 'Menunggu',
  `dokter_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resep`
--

INSERT INTO `resep` (`id`, `pasien_id`, `penyakit_id`, `tanggal_resep`, `status_resep`, `dokter_id`) VALUES
(1, 1, 1, '2026-05-28', 'Selesai', 1),
(2, 2, 2, '2026-05-29', 'Selesai', 1),
(3, 1, 5, '2026-05-30', 'Selesai', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama_supplier` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `telepon` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama_supplier`, `telepon`, `alamat`) VALUES
(1, 'PT Sehat Sejahtera', '081234567890', 'Jl. Merdeka No.1, Surabaya'),
(2, 'CV Medika Pharma', '081987654321', 'Jl. Pahlawan No.45, Surabayaa');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `kode_transaksi` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `resep_id` int DEFAULT NULL,
  `user_id` int NOT NULL,
  `total_harga` decimal(12,2) NOT NULL DEFAULT '0.00',
  `tanggal_transaksi` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_pembayaran` enum('Belum Lunas','Lunas') COLLATE utf8mb4_general_ci DEFAULT 'Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_transaksi`, `resep_id`, `user_id`, `total_harga`, `tanggal_transaksi`, `status_pembayaran`) VALUES
(1, 'TRX-260528-001', 1, 2, 10000.00, '2026-05-28 10:00:00', 'Lunas'),
(2, 'TRX-260529-002', 2, 2, 14000.00, '2026-05-29 14:30:00', 'Lunas'),
(3, 'TRX-20260530-0001', 3, 1, 4000.00, '2026-05-30 17:05:05', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('Kepala Klinik','Petugas') COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Dr. Oppenheimer', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Kepala Klinik', '2026-05-29 16:33:30'),
(2, 'Puput', 'kasir1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Petugas', '2026-05-29 16:33:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `obat_id` (`obat_id`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_obat` (`kode_obat`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_identitas` (`no_identitas`);

--
-- Indexes for table `penyakit`
--
ALTER TABLE `penyakit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resep`
--
ALTER TABLE `resep`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pasien_id` (`pasien_id`),
  ADD KEY `penyakit_id` (`penyakit_id`),
  ADD KEY `fk_resep_dokter` (`dokter_id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `resep_id` (`resep_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penyakit`
--
ALTER TABLE `penyakit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `resep`
--
ALTER TABLE `resep`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`obat_id`) REFERENCES `obat` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `obat`
--
ALTER TABLE `obat`
  ADD CONSTRAINT `obat_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `obat_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `resep`
--
ALTER TABLE `resep`
  ADD CONSTRAINT `fk_resep_dokter` FOREIGN KEY (`dokter_id`) REFERENCES `dokter` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `resep_ibfk_1` FOREIGN KEY (`pasien_id`) REFERENCES `pasien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `resep_ibfk_2` FOREIGN KEY (`penyakit_id`) REFERENCES `penyakit` (`id`) ON DELETE RESTRICT;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`resep_id`) REFERENCES `resep` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
