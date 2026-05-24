<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
    .rounded-2xl { border-radius: 1rem !important; }
    .card-modern {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .text-teal { color: #0d9488 !important; }
    .bg-teal-light { background-color: #ccfbf1 !important; }
    .bg-teal { background-color: #0d9488 !important; color: white !important; }
    .btn-teal { background-color: #0d9488 !important; border-color: #0d9488 !important; color: white !important; }
    .btn-teal:hover { background-color: #0f766e !important; color: white !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card card-modern rounded-2xl">
                <div class="card-header bg-teal rounded-2xl-top">
                    <h4 class="card-title text-white font-weight-bold mb-0"><i class="ft-clipboard"></i> Resep Obat Saya</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-4">
                        <?php if (!empty($riwayatResep)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No. Resep</th>
                                            <th>Tanggal Resep</th>
                                            <th>Dokter Meresepkan</th>
                                            <th>Total Biaya</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($riwayatResep as $r): ?>
                                            <tr>
                                                <td class="align-middle"><?= $no++ ?></td>
                                                <td class="align-middle"><strong>RSP-<?= str_pad($r['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                                                <td class="align-middle"><?= date('d/m/Y', strtotime($r['tgl_resep'])) ?></td>
                                                <td class="align-middle"><strong><?= esc($r['nama_dokter']) ?></strong></td>
                                                <td class="align-middle"><?php $statusR = $r['status'] ?? 'menunggu'; if ($r['status_bpjs'] === 'Aktif'): ?><span class="badge badge-success">Rp 0 (BPJS)</span><?php else: ?>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?><?php endif; ?></td>
                                                <td class="text-center align-middle">
                                                    <?php $statusR = $r['status'] ?? 'menunggu'; if ($statusR === 'selesai'): ?>
                                                        <span class="badge badge-success">Selesai / Diambil</span>
                                                    <?php elseif ($statusR === 'diproses'): ?>
                                                        <span class="badge badge-warning text-white">Sedang Diproses</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Menunggu Apoteker</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center flex-wrap" style="gap:6px;">
                                                        <a href="<?= base_url('resep_pasien/detail/'.$r['id_resep']) ?>" class="btn btn-sm btn-teal rounded-pill px-3">
                                                            <i class="ft-eye"></i> Detail
                                                        </a>
                                                        <?php if (($r['status'] ?? 'menunggu') === 'diproses'): ?>
                                                        <form method="POST" action="<?= base_url('resep_pasien/konfirmasi/'.$r['id_resep']) ?>" onsubmit="return confirm('Konfirmasi bahwa Anda sudah mengambil obat ini?')">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                                <i class="la la-check-circle"></i> Ambil Obat
                                                            </button>
                                                        </form>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="ft-info font-large-1 d-block mb-2"></i>
                                Belum ada riwayat resep obat untuk Anda.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
