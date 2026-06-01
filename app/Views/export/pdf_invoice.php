<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pasien</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .clinic-name { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .clinic-address { font-size: 12px; color: #555; }
        .invoice-title { font-size: 16px; font-weight: bold; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .info-table { border: none; margin-bottom: 20px; }
        .info-table th, .info-table td { border: none; padding: 4px; }
        .total-row { font-weight: bold; }
        .footer { text-align: right; margin-top: 40px; }
    </style>
</head>
<body>

<div class="header">
    <div class="clinic-name">KLINIK SEHAT BERSAMA</div>
    <div class="clinic-address">Jl. Kesehatan No. 123, Kota Medis, Telp: (021) 1234567</div>
</div>

<div class="invoice-title">INVOICE PEMBAYARAN RESEP OBAT</div>

<table class="info-table">
    <tr>
        <td width="20%"><strong>ID Resep</strong></td>
        <td width="30%">: #<?= $resep['id_resep'] ?></td>
        <td width="20%"><strong>Tanggal</strong></td>
        <td width="30%">: <?= date('d/m/Y', strtotime($resep['tgl_resep'])) ?></td>
    </tr>
    <tr>
        <td><strong>Nama Pasien</strong></td>
        <td>: <?= $resep['nama_pasien'] ?></td>
        <td><strong>Dokter Pemeriksa</strong></td>
        <td>: <?= $resep['nama_dokter'] ?></td>
    </tr>
    <tr>
        <td><strong>Status BPJS</strong></td>
        <td>: <?= $is_bpjs ? 'Ya (Aktif)' : 'Tidak (Umum)' ?></td>
        <td><strong>No BPJS</strong></td>
        <td>: <?= $resep['no_bpjs'] ?: '-' ?></td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Obat</th>
            <th>Dosis</th>
            <th>Harga Satuan</th>
            <th>Jumlah</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $total = 0; foreach ($detail as $row): 
            $subtotal = $row['jumlah'] * $row['harga'];
            $total += $subtotal;
        ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_obat'] ?></td>
            <td><?= $row['dosis'] ?></td>
            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td><?= $row['jumlah'] ?> <?= $row['satuan'] ?></td>
            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
        
        <?php if ($is_bpjs): ?>
        <tr class="total-row">
            <td colspan="5" style="text-align: right;">Total Ditanggung BPJS</td>
            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="5" style="text-align: right;">Total Tagihan Pasien</td>
            <td>Rp 0</td>
        </tr>
        <?php else: ?>
        <tr class="total-row">
            <td colspan="5" style="text-align: right;">Total Tagihan</td>
            <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="footer">
    <p>Petugas Administrasi,</p>
    <br><br><br>
    <p>(_________________________)</p>
</div>

</body>
</html>
