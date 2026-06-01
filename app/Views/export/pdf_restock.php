<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Restock Obat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .clinic-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .clinic-address { font-size: 12px; color: #555; }
        .invoice-title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .info-table { border: none; margin-bottom: 20px; }
        .info-table th, .info-table td { border: none; padding: 4px; }
        .footer { text-align: right; margin-top: 40px; }
    </style>
</head>
<body>

<div class="header">
    <div class="clinic-name">KLINIK SEHAT BERSAMA</div>
    <div class="clinic-address">Jl. Kesehatan No. 123, Kota Medis, Telp: (021) 1234567</div>
</div>

<div class="invoice-title">Laporan Detail Restock Obat (Pengeluaran)</div>

<table class="info-table">
    <tr>
        <td width="20%"><strong>ID Restock</strong></td>
        <td width="30%">: #<?= $restock['id_restock'] ?></td>
        <td width="20%"><strong>Tanggal</strong></td>
        <td width="30%">: <?= date('d/m/Y', strtotime($restock['tanggal'])) ?></td>
    </tr>
    <tr>
        <td><strong>Nama Obat</strong></td>
        <td colspan="3">: <?= $restock['nama_obat'] ?></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Keterangan Tambahan</th>
            <th>Jumlah Tambah Stok</th>
            <th>Harga Beli (Satuan)</th>
            <th>Total Biaya (Pengeluaran)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $restock['keterangan'] ?: '-' ?></td>
            <td><?= $restock['jumlah'] ?> <?= $restock['satuan'] ?></td>
            <td>Rp <?= number_format($restock['harga_beli'], 0, ',', '.') ?></td>
            <td><strong>Rp <?= number_format($restock['total_biaya'], 0, ',', '.') ?></strong></td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <p>Petugas Restock / Apoteker,</p>
    <br><br><br>
    <p>( .................................... )</p>
</div>

</body>
</html>
