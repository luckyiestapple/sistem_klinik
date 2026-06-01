<?php
$conn = new mysqli('localhost', 'root', '', 'db_klinik');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 1. Tambah kolom id_user dan created_at ke tb_resep jika belum ada
$res = $conn->query("SHOW COLUMNS FROM tb_resep LIKE 'id_user'");
if($res->num_rows == 0) {
    $conn->query("ALTER TABLE tb_resep ADD COLUMN id_user INT DEFAULT NULL AFTER status");
    echo "Added id_user column.\n";
}
$res = $conn->query("SHOW COLUMNS FROM tb_resep LIKE 'created_at'");
if($res->num_rows == 0) {
    $conn->query("ALTER TABLE tb_resep ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER id_user");
    echo "Added created_at column.\n";
}

// 2. Update v_laporan_kas
$viewSQL = "
CREATE OR REPLACE VIEW v_laporan_kas AS 
SELECT 
    'pengeluaran' AS tipe, 
    r.total_biaya AS nominal, 
    CONCAT('Restock Obat - ', o.nama_obat, ' (', r.keterangan, ')') AS keterangan, 
    r.tanggal AS tanggal, 
    r.id_user AS id_user, 
    u.username AS nama_user, 
    r.created_at AS created_at 
FROM (tb_restock r 
LEFT JOIN tb_obat o ON r.kode_obat = o.kode_obat) 
LEFT JOIN tb_user u ON r.id_user = u.id_user 

UNION ALL 

SELECT 
    'pemasukan' AS tipe, 
    t.total_biaya AS nominal, 
    CONCAT('Penjualan Pasien', IF(t.is_bpjs = 1, ' (BPJS)', ' (Umum)'), ' - ', t.nama_pasien) AS keterangan, 
    t.tanggal AS tanggal, 
    t.id_user AS id_user, 
    u.username AS nama_user, 
    t.created_at AS created_at 
FROM tb_transaksi_pasien t 
LEFT JOIN tb_user u ON t.id_user = u.id_user

UNION ALL

SELECT 
    'pemasukan' AS tipe, 
    IF(p.status_bpjs = 'Aktif' OR p.status_bpjs = 'aktif', 0, res.total_harga) AS nominal, 
    IF(p.status_bpjs = 'Aktif' OR p.status_bpjs = 'aktif', 'BPJS', CONCAT(p.nama, ' (Umum)')) AS keterangan, 
    res.tgl_resep AS tanggal, 
    res.id_user AS id_user, 
    u.username AS nama_user, 
    res.created_at AS created_at 
FROM tb_resep res
JOIN tb_pasien p ON res.id_pasien = p.id_pasien
LEFT JOIN tb_user u ON res.id_user = u.id_user
";

if($conn->query($viewSQL) === TRUE) {
    echo "Updated v_laporan_kas view successfully.\n";
} else {
    echo "Error updating view: " . $conn->error . "\n";
}

$conn->close();
?>
