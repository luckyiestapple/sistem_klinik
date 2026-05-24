-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 24, 2026 at 04:04 AM
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
(1, 'P002', 'D001', '2026-05-20', 'A01', 'selesai', 'Sakit tenggorokan dan flu berat'),
(2, 'P001', 'D009', '2026-05-23', 'A01', 'selesai', 'Sakit telinga'),
(3, 'P003', 'D009', '2026-05-23', 'A02', 'selesai', 'sakit telinga\r\n'),
(4, 'P003', 'D001', '2026-05-23', 'A01', 'selesai', 'demam');

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
('D002', 'drg. Diana Eka Sari', 'Jl. Akasia', 'Gigi', 'SIP/145/736/2025', 'aktif', 'Selasa-Kamis', '08:20-12:00', '08122216718', 'diana@kliniksehat.com'),
('D003', 'dr. Ahmad Fauzi', 'Jl. Sudirman No. 45, Jakarta', 'Umum', 'SIP/003/UMUM/2026', 'aktif', 'Senin - Rabu', '08:00 - 12:00', '081234567803', 'ahmadfauzi@kliniksehat.com'),
('D004', 'dr. Siti Aminah', 'Jl. Gatot Subroto No. 12, Jakarta', 'Umum', 'SIP/004/UMUM/2026', 'aktif', 'Kamis - Sabtu', '13:00 - 17:00', '081234567804', 'sitiaminah@kliniksehat.com'),
('D005', 'drg. Rian Hidayat', 'Jl. Merdeka No. 89, Bandung', 'Gigi', 'SIP/005/GIGI/2026', 'aktif', 'Senin - Rabu', '09:00 - 13:00', '081234567805', 'rianhidayat@kliniksehat.com'),
('D006', 'drg. Larasati Putri', 'Jl. Diponegoro No. 34, Bandung', 'Gigi', 'SIP/006/GIGI/2026', 'aktif', 'Kamis - Sabtu', '14:00 - 18:00', '081234567806', 'larasatiputri@kliniksehat.com'),
('D007', 'dr. Hendra Wijaya, Sp.S', 'Jl. Pemuda No. 12, Semarang', 'Syaraf', 'SIP/007/SYARAF/2026', 'aktif', 'Senin - Jumat', '09:00 - 14:00', '081234567807', 'hendrawijaya@kliniksehat.com'),
('D008', 'dr. Kartika Sari, Sp.S', 'Jl. Pahlawan No. 78, Semarang', 'Syaraf', 'SIP/008/SYARAF/2026', 'aktif', 'Senin - Kamis', '13:00 - 17:00', '081234567808', 'kartikasari@kliniksehat.com'),
('D009', 'dr. Farhan Malik, Sp.THT', 'Jl. Ahmad Yani No. 56, Surabaya', 'THT', 'SIP/009/THT/2026', 'aktif', 'Selasa - Kamis', '08:00 - 12:00', '081234567809', 'farhanmalik@kliniksehat.com'),
('D010', 'dr. Annisa Rahma, Sp.THT', 'Jl. Basuki Rahmat No. 23, Surabaya', 'THT', 'SIP/010/THT/2026', 'aktif', 'Jumat - Sabtu', '13:00 - 17:00', '081234567810', 'annisarahma@kliniksehat.com'),
('D011', 'dr. Bambang Hermawan, Sp.A', 'Jl. Malioboro No. 100, Yogyakarta', 'Anak', 'SIP/011/ANAK/2026', 'aktif', 'Senin - Rabu', '10:00 - 14:00', '081234567811', 'bambanghermawan@kliniksehat.com'),
('D012', 'dr. Dewa Ayu, Sp.A', 'Jl. Kaliurang KM 5, Yogyakarta', 'Anak', 'SIP/012/ANAK/2026', 'aktif', 'Kamis - Sabtu', '13:00 - 16:00', '081234567812', 'dewaayu@kliniksehat.com'),
('D013', 'dr. Yusuf Bachtiar, Sp.OG', 'Jl. Urip Sumoharjo No. 8, Makassar', 'Kandungan', 'SIP/013/KANDUNGAN/2026', 'aktif', 'Senin - Jumat', '08:30 - 13:00', '081234567813', 'yusufbachtiar@kliniksehat.com'),
('D014', 'dr. Maria Ulfa, Sp.OG', 'Jl. AP Pettarani No. 54, Makassar', 'Kandungan', 'SIP/014/KANDUNGAN/2026', 'aktif', 'Senin - Kamis', '14:00 - 18:00', '081234567814', 'mariaulfa@kliniksehat.com'),
('D015', 'dr. Gunawan Pratama, Sp.KK', 'Jl. Teuku Umar No. 17, Denpasar', 'Kulit & Kelamin', 'SIP/015/KULIT/2026', 'aktif', 'Senin - Rabu', '09:00 - 12:00', '081234567815', 'gunawanpratama@kliniksehat.com'),
('D016', 'dr. Citra Lestari, Sp.KK', 'Jl. Sunset Road No. 88, Denpasar', 'Kulit & Kelamin', 'SIP/016/KULIT/2026', 'aktif', 'Kamis - Sabtu', '13:00 - 16:00', '081234567816', 'citralestari@kliniksehat.com');

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

--
-- Dumping data for table `tb_obat`
--

INSERT INTO `tb_obat` (`kode_obat`, `nama_obat`, `kandungan`, `harga`, `stok`, `satuan`, `tgl_expired`, `stok_minimum`) VALUES
('OB001', 'Paracetamol', 'Paracetamol 500mg', 5000, 99, 'tablet', '2028-12-31', 10),
('OB002', 'Amoxicillin', 'Amoxicillin 500mg', 8000, 149, 'tablet', '2027-06-30', 10),
('OB003', 'Asam Mefenamat', 'Asam Mefenamat 500mg', 6000, 120, 'tablet', '2028-03-31', 10),
('OB004', 'Cataflam', 'Kalium Diklofenak 50mg', 25000, 50, 'tablet', '2027-11-30', 10),
('OB005', 'Neurobion Forte', 'Vitamin B1 100mg, B6 100mg, B12 5000mcg', 15000, 80, 'tablet', '2029-01-31', 10),
('OB006', 'Gabapentin', 'Gabapentin 100mg', 22000, 40, 'tablet', '2027-08-31', 10),
('OB007', 'Demacolin', 'Paracetamol, Pseudoephedrine HCl, Chlorpheniramine Maleate', 7000, 58, 'tablet', '2028-05-31', 10),
('OB008', 'Hufagrip BP', 'Chlorpheniramine Maleate, Pseudoephedrine Hcl', 12000, 60, 'botol', '2027-10-31', 5),
('OB009', 'Tempra Syrup', 'Paracetamol Drop 80mg/0.8ml', 45000, 30, 'botol', '2028-02-29', 5),
('OB010', 'Sanmol Syrup', 'Paracetamol Suspensi 120mg/5ml', 18000, 50, 'botol', '2027-09-30', 5),
('OB011', 'Folavit', 'Asam Folat 400mcg', 10000, 200, 'tablet', '2029-04-30', 10),
('OB012', 'Sangobion', 'Ferrous Gluconate, Manganese Sulfate, Copper Sulfate, Vitamin C', 14000, 150, 'tablet', '2028-07-31', 10),
('OB013', 'Acyclovir Cream', 'Acyclovir 5%', 8000, 50, 'tube', '2027-12-31', 10),
('OB014', 'Betasone Cream', 'Betamethasone Valerate 0.1%', 15000, 40, 'tube', '2028-10-31', 10);

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
('P002', 'Test Patient', 'Jl. Sukses No. 5', 'L', '1990-01-01', '081223334444', '0127192192101', 'aktif', 'Klinik Pratama', 'Kelas II', NULL, NULL, NULL, NULL, NULL),
('P003', 'Bayu Prayoga', 'dadjasdada', 'L', '1993-12-03', '083847331626', '182131931718', 'aktif', 'Faskes Darma', 'Kelas II', NULL, NULL, NULL, NULL, NULL);

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
  `id_antrean` int DEFAULT NULL,
  `resep_obat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_rekam_medis`
--

INSERT INTO `tb_rekam_medis` (`id_rekam_medis`, `id_pasien`, `id_dokter`, `tgl_periksa`, `keluhan`, `diagnosa`, `tensi`, `nadi`, `suhu`, `berat_badan`, `tinggi_badan`, `pemeriksaan_fisik`, `tgl_kontrol`, `id_antrean`, `resep_obat`) VALUES
(1, 'P001', 'D001', '2026-05-23', 'Sakit tenggorokan dan flu berat', 'adwladamwa', '124/85', '', '38', '53', '165x', 'aasjdald', NULL, 1, 'Paracetamol (3x1) sesudah makan'),
(2, 'P001', 'D009', '2026-05-23', 'Sakit telinga', 'jangan', '124/85', '80x/menit', '36.5', '63', '168', 'okey', NULL, 2, 'dajdaod'),
(3, 'P003', 'D009', '2026-05-23', 'sakit telinga\r\n', 'iya', '150/29', '80x/menit', '36', '56', '171', 'iya', NULL, 3, NULL),
(4, 'P003', 'D001', '2026-05-23', 'demam', 'uiuyfukb', '150/29', '80x/menit', '39', '63', '165', 'n, jihi', NULL, 4, NULL);

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

--
-- Dumping data for table `tb_resep`
--

INSERT INTO `tb_resep` (`id_resep`, `id_pasien`, `id_dokter`, `tgl_resep`, `total_harga`, `status`) VALUES
(1, 'P001', 'D001', '2026-05-23', 5000.00, 'menunggu'),
(2, 'P003', 'D009', '2026-05-23', 0.00, 'diproses'),
(3, 'P003', 'D001', '2026-05-23', 0.00, 'menunggu');

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

--
-- Dumping data for table `tb_resepdetail`
--

INSERT INTO `tb_resepdetail` (`id_detail`, `kode_resep`, `kode_obat`, `dosis`, `jumlah`, `harga`) VALUES
(1, '1', 'OB001', '3x1 sesudah makan', 1, 5000),
(2, '2', 'OB007', '2x1', 32, 7000),
(3, '3', 'OB002', '3x1 sesudah makan', 1, 8000);

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
(7, 'diana', '$2y$10$tkFgCFsjYI6cs98WvY/aVOG4kDSWVUIzERkDdnVNwyFQPyCmCCTtW', 3, 'D002'),
(8, 'ahmadfauzi', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D003'),
(9, 'sitiaminah', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D004'),
(10, 'rianhidayat', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D005'),
(11, 'larasatiputri', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D006'),
(12, 'hendrawijaya', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D007'),
(13, 'kartikasari', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D008'),
(14, 'farhanmalik', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D009'),
(15, 'annisarahma', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D010'),
(16, 'bambanghermawan', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D011'),
(17, 'dewaayu', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D012'),
(18, 'yusufbachtiar', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D013'),
(19, 'mariaulfa', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D014'),
(20, 'gunawanpratama', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D015'),
(21, 'citralestari', '$2y$10$0bI7qFRIHKhSptvi804WzuQ6qf5.mfhS1aWvp2ZcehdKOE0sFI4Da', 3, 'D016'),
(22, 'yuu', '$2y$10$zpDvf5OWulEGiwHH0/jBR.QfVnfc8DD5kzqKl2E49IpkDOq45K.a2', 2, 'P003');

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
  MODIFY `id_antrean` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_level_user`
--
ALTER TABLE `tb_level_user`
  MODIFY `id_level` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_rekam_medis`
--
ALTER TABLE `tb_rekam_medis`
  MODIFY `id_rekam_medis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_resep`
--
ALTER TABLE `tb_resep`
  MODIFY `id_resep` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_resepdetail`
--
ALTER TABLE `tb_resepdetail`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
