-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 22, 2026 at 09:42 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_klinik`
--
CREATE DATABASE IF NOT EXISTS `db_klinik` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `db_klinik`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_antrean`
--

CREATE TABLE `tb_antrean` (
  `id_antrean` int NOT NULL,
  `id_pasien` varchar(12) NOT NULL,
  `id_dokter` varchar(12) NOT NULL,
  `tgl_antrean` date NOT NULL,
  `nomor_antrean` varchar(10) NOT NULL,
  `status` varchar(20) DEFAULT 'menunggu',
  `keluhan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_antrean`
--

INSERT INTO `tb_antrean` (`id_antrean`, `id_pasien`, `id_dokter`, `tgl_antrean`, `nomor_antrean`, `status`, `keluhan`) VALUES
(1, 'P002', 'D001', '2026-05-20', 'A01', 'dipanggil', 'Sakit tenggorokan dan flu berat');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokter`
--

CREATE TABLE `tb_dokter` (
  `id_dokter` varchar(12) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `spesialisasi` varchar(50) NOT NULL,
  `sip_str` varchar(50) DEFAULT NULL,
  `status_aktif` varchar(20) DEFAULT 'aktif',
  `hari_praktek` varchar(100) DEFAULT NULL,
  `jam_praktek` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_dokter`
--

INSERT INTO `tb_dokter` (`id_dokter`, `nama`, `alamat`, `spesialisasi`, `sip_str`, `status_aktif`, `hari_praktek`, `jam_praktek`, `no_telp`, `email`) VALUES
('D001', 'dr. Budi Santoso', 'Jl. Kesehatan No. 10', 'Umum', 'SIP/123/456/2025', 'aktif', 'Senin - Jumat', '08:00 - 14:00', '081234567890', 'budi@kliniksehat.com'),
('D002', 'drg. Diana Eka Sari', 'Jl. Akasia', 'Gigi', 'SIP/145/736/2025', 'aktif', 'Selasa-Kamis', '08:20-12:00', '08122216718', 'diana@kliniksehat.com');

-- --------------------------------------------------------

--
-- Table structure for table `tb_level_user`
--

CREATE TABLE `tb_level_user` (
  `id_level` int NOT NULL,
  `nama_level` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_level_user`
--

INSERT INTO `tb_level_user` (`id_level`, `nama_level`) VALUES
(1, 'Apoteker'),
(2, 'Pasien'),
(3, 'Dokter');

-- --------------------------------------------------------

--
-- Table structure for table `tb_obat`
--

CREATE TABLE `tb_obat` (
  `kode_obat` varchar(11) NOT NULL,
  `nama_obat` varchar(20) NOT NULL,
  `kandungan` varchar(255) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `stok` int NOT NULL,
  `satuan` varchar(20) DEFAULT 'tablet',
  `tgl_expired` date DEFAULT NULL,
  `stok_minimum` int DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pasien`
--

CREATE TABLE `tb_pasien` (
  `id_pasien` varchar(12) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `jk` char(1) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `no_bpjs` varchar(30) DEFAULT NULL,
  `status_bpjs` varchar(20) DEFAULT 'Tidak Aktif',
  `faskes` varchar(100) DEFAULT NULL,
  `kelas_rawat` varchar(20) DEFAULT NULL,
  `gol_darah` varchar(5) DEFAULT NULL,
  `alergi_obat` text,
  `riwayat_penyakit` text,
  `kontak_darurat_nama` varchar(100) DEFAULT NULL,
  `kontak_darurat_telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pasien`
--

INSERT INTO `tb_pasien` (`id_pasien`, `nama`, `alamat`, `jk`, `tgl_lahir`, `no_telp`, `no_bpjs`, `status_bpjs`, `faskes`, `kelas_rawat`, `gol_darah`, `alergi_obat`, `riwayat_penyakit`, `kontak_darurat_nama`, `kontak_darurat_telp`) VALUES
('P001', 'NAZWA YUMNA ZHARIFAH', 'jl. mawar', 'P', '2006-09-05', '081263614896', NULL, 'Tidak Aktif', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
('P002', 'Test Patient', 'Jl. Sukses No. 5', 'L', '1990-01-01', '081223334444', '0127192192101', 'aktif', 'Klinik Pratama', 'Kelas II', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekam_medis`
--

CREATE TABLE `tb_rekam_medis` (
  `id_rekam_medis` int NOT NULL,
  `id_pasien` varchar(12) NOT NULL,
  `id_dokter` varchar(12) NOT NULL,
  `tgl_periksa` date NOT NULL,
  `keluhan` text NOT NULL,
  `diagnosa` text NOT NULL,
  `tensi` varchar(20) DEFAULT NULL,
  `nadi` varchar(20) DEFAULT NULL,
  `suhu` varchar(10) DEFAULT NULL,
  `berat_badan` varchar(10) DEFAULT NULL,
  `tinggi_badan` varchar(10) DEFAULT NULL,
  `pemeriksaan_fisik` text,
  `tgl_kontrol` date DEFAULT NULL,
  `id_antrean` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_resep`
--

CREATE TABLE `tb_resep` (
  `id_resep` int NOT NULL,
  `id_pasien` varchar(12) NOT NULL,
  `id_dokter` varchar(12) NOT NULL,
  `tgl_resep` date NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `status` varchar(20) DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_resepdetail`
--

CREATE TABLE `tb_resepdetail` (
  `id_detail` int NOT NULL,
  `kode_resep` varchar(10) NOT NULL,
  `kode_obat` varchar(10) NOT NULL,
  `dosis` varchar(50) NOT NULL,
  `jumlah` int NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_level` int NOT NULL,
  `id_referensi` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `username`, `password`, `id_level`, `id_referensi`) VALUES
(1, 'admin', '$2y$10$rgjqMhgc9br/S9UmJM8tKeuDWxNYLuw.M3JSgYgDAvocencBAD8fG', 1, 'P001'),
(3, 'nanaz123', '$2y$10$anJpyhSeH9vnTqIq7ESHtuPEuTeQKqaeS1WhmK7r32ugTCYPhk0WG', 2, 'P001'),
(5, 'testpatient', '$2y$10$X9GZ1po2CyOOp7ayPVaQruHkpZ5xgyXgvXj7ay1A9eN5Ahpy0qDAq', 2, 'P002'),
(6, 'budi', '$2y$10$yfmR8RZRgIMnV/Pl21zqLON4Dp8lhkCerE/xjB8gyOF4lIt4V.E7m', 3, 'D001'),
(7, 'diana', '$2y$10$tkFgCFsjYI6cs98WvY/aVOG4kDSWVUIzERkDdnVNwyFQPyCmCCTtW', 3, 'D002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_antrean`
--
ALTER TABLE `tb_antrean`
  ADD PRIMARY KEY (`id_antrean`);

--
-- Indexes for table `tb_dokter`
--
ALTER TABLE `tb_dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `tb_level_user`
--
ALTER TABLE `tb_level_user`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `tb_obat`
--
ALTER TABLE `tb_obat`
  ADD PRIMARY KEY (`kode_obat`);

--
-- Indexes for table `tb_pasien`
--
ALTER TABLE `tb_pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `tb_rekam_medis`
--
ALTER TABLE `tb_rekam_medis`
  ADD PRIMARY KEY (`id_rekam_medis`);

--
-- Indexes for table `tb_resep`
--
ALTER TABLE `tb_resep`
  ADD PRIMARY KEY (`id_resep`);

--
-- Indexes for table `tb_resepdetail`
--
ALTER TABLE `tb_resepdetail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_antrean`
--
ALTER TABLE `tb_antrean`
  MODIFY `id_antrean` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_level_user`
--
ALTER TABLE `tb_level_user`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_rekam_medis`
--
ALTER TABLE `tb_rekam_medis`
  MODIFY `id_rekam_medis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_resep`
--
ALTER TABLE `tb_resep`
  MODIFY `id_resep` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_resepdetail`
--
ALTER TABLE `tb_resepdetail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
