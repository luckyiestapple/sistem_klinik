<?php
$mysqli = new mysqli("localhost", "root", "", "db_klinik");

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

// 4. Update View v_laporan_kas to point to tb_resep instead of tb_transaksi_pasien
$sql_view = "CREATE OR REPLACE VIEW v_laporan_kas AS
SELECT 
    'pengeluaran' AS tipe,
    r.total_biaya AS nominal,
    CONCAT('Restock Obat - ', o.nama_obat, ' (', r.keterangan, ')') AS keterangan,
    r.tanggal,
    r.id_user,
    u.username as nama_user,
    r.created_at
FROM tb_restock r
LEFT JOIN tb_obat o ON r.kode_obat = o.kode_obat
LEFT JOIN tb_user u ON r.id_user = u.id_user
UNION ALL
SELECT 
    'pemasukan' AS tipe,
    t.total_harga AS nominal,
    IF(p.status_bpjs = 'Aktif', 'BPJS', CONCAT(p.nama, ' (Umum)')) AS keterangan,
    t.tgl_resep AS tanggal,
    t.id_dokter AS id_user,
    u.username as nama_user,
    t.tgl_resep AS created_at
FROM tb_resep t
LEFT JOIN tb_pasien p ON t.id_pasien = p.id_pasien
LEFT JOIN tb_dokter d ON t.id_dokter = d.id_dokter
LEFT JOIN tb_user u ON d.id_dokter = u.id_referensi
WHERE t.status = 'selesai'
";
$mysqli->query($sql_view);

echo "View update successful.";
$mysqli->close();
