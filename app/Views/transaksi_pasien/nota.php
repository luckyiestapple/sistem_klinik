<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; }
        .nota-container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px dashed #333; padding-bottom: 10px; }
        .header h2 { margin: 0; }
        .info { margin-bottom: 20px; }
        .info table { width: 100%; }
        .info td { padding: 5px 0; }
        .items table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items th, .items td { border-bottom: 1px solid #ddd; padding: 8px 0; text-align: left; }
        .items th.right, .items td.right { text-align: right; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 10px; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #777; }
        @media print {
            body { margin: 0; padding: 0; }
            .nota-container { border: none; max-width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="nota-container">
    <div class="header">
        <h2>KLINIK SEHAT</h2>
        <p>Jl. Contoh No. 123, Kota Anda<br>Telp: 0812-3456-7890</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="30%"><strong>No. Transaksi</strong></td>
                <td>: TRXB-<?= sprintf('%04d', $transaksi['id_transaksi']) ?></td>
            </tr>
            <tr>
                <td><strong>Tanggal</strong></td>
                <td>: <?= date('d M Y', strtotime($transaksi['tanggal'])) ?></td>
            </tr>
            <tr>
                <td><strong>Nama Pasien</strong></td>
                <td>: <?= esc($transaksi['nama_pasien']) ?></td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>: <?= $transaksi['is_bpjs'] ? 'BPJS' : 'Umum' ?></td>
            </tr>
            <tr>
                <td><strong>Admin</strong></td>
                <td>: <?= esc($transaksi['username']) ?></td>
            </tr>
        </table>
    </div>

    <div class="items">
        <table>
            <thead>
                <tr>
                    <th>Obat</th>
                    <th class="right">Harga</th>
                    <th class="right">Qty</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($detail as $d): ?>
                <tr>
                    <td><?= esc($d['nama_obat']) ?></td>
                    <td class="right">Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?></td>
                    <td class="right"><?= $d['jumlah'] ?></td>
                    <td class="right">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="total">
        TOTAL BIAYA: Rp <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?>
    </div>

    <div class="footer">
        <p>Terima kasih atas kunjungan Anda.<br>Semoga lekas sembuh.</p>
    </div>

    <div style="text-align: center; margin-top: 20px;" class="no-print">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Cetak Nota</button>
    </div>
</div>

</body>
</html>
