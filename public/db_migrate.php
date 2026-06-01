<?php
$mysqli = new mysqli("localhost", "root", "", "db_klinik");

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

// 1. Create tb_restock
$sql_restock = "CREATE TABLE IF NOT EXISTS tb_restock (
    id_restock INT AUTO_INCREMENT PRIMARY KEY,
    kode_obat VARCHAR(11) NOT NULL,
    tanggal DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    jumlah INT NOT NULL,
    harga_beli DECIMAL(12,2) NOT NULL,
    total_biaya DECIMAL(12,2) NOT NULL,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$mysqli->query($sql_restock);

// 2. Create tb_transaksi_pasien
$sql_transaksi = "CREATE TABLE IF NOT EXISTS tb_transaksi_pasien (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    nama_pasien VARCHAR(100) NOT NULL,
    is_bpjs TINYINT(1) DEFAULT 0,
    tanggal DATE NOT NULL,
    total_biaya DECIMAL(12,2) NOT NULL DEFAULT 0,
    id_user INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$mysqli->query($sql_transaksi);

// 3. Create tb_detail_transaksi
$sql_detail = "CREATE TABLE IF NOT EXISTS tb_detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    kode_obat VARCHAR(11) NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,0) NOT NULL,
    subtotal DECIMAL(12,2) NOT NULL
)";
$mysqli->query($sql_detail);

// 4. Create View v_laporan_kas
$sql_view = "CREATE OR REPLACE VIEW v_laporan_kas AS
SELECT 
    'pengeluaran' AS tipe,
    r.total_biaya AS nominal,
    CONCAT('Restock Obat - ', o.nama_obat, ' (', r.keterangan, ')') AS keterangan,
    r.tanggal,
    r.id_user,
    u.username as nama_admin,
    r.created_at
FROM tb_restock r
LEFT JOIN tb_obat o ON r.kode_obat = o.kode_obat
LEFT JOIN tb_user u ON r.id_user = u.id_user
UNION ALL
SELECT 
    'pemasukan' AS tipe,
    t.total_biaya AS nominal,
    CONCAT('Penjualan Pasien', IF(t.is_bpjs = 1, ' (BPJS)', ' (Umum)'), ' - ', t.nama_pasien) AS keterangan,
    t.tanggal,
    t.id_user,
    u.username as nama_admin,
    t.created_at
FROM tb_transaksi_pasien t
LEFT JOIN tb_user u ON t.id_user = u.id_user
";
$mysqli->query($sql_view);

echo "Migration successful.";
$mysqli->close();
