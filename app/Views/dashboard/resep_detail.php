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
    .btn-outline-teal { color: #0d9488 !important; border-color: #0d9488 !important; }
    .btn-outline-teal:hover { background-color: #0d9488 !important; color: white !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <div class="row">
        <div class="col-lg-8 col-12 mx-auto">
            <div class="card card-modern rounded-2xl">
                <div class="card-header bg-teal rounded-2xl-top d-flex justify-content-between align-items-center">
                    <h4 class="card-title text-white font-weight-bold mb-0"><i class="ft-clipboard"></i> Detail Resep Obat Saya</h4>
                    <a href="<?= base_url('resep_pasien') ?>" class="btn btn-sm btn-light rounded-pill px-3">Kembali</a>
                </div>
                <div class="card-content">
                    <div class="card-body p-4">
                        <!-- Info Resep -->
                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-sm-6 mb-2">
                                <span class="d-block text-muted font-small-3">Diberikan Oleh</span>
                                <strong class="text-dark font-large-1"><?= esc($dokter['nama']) ?></strong>
                                <span class="d-block text-teal font-small-3">Poli <?= esc($dokter['spesialisasi']) ?></span>
                            </div>
                            <div class="col-sm-6 text-sm-right">
                                <span class="d-block text-muted font-small-3">Tanggal Resep</span>
                                <strong class="text-dark d-block mb-1"><?= date('d F Y', strtotime($resep['tgl_resep'])) ?></strong>
                                <span class="d-block text-muted font-small-3">Status</span>
                                <?php 
                                $status = $resep['status'] ?? 'menunggu';
                                if ($status === 'selesai'): 
                                ?>
                                    <span class="badge badge-success font-medium-1">Selesai / Diambil</span>
                                <?php elseif ($status === 'diproses'): ?>
                                    <span class="badge badge-warning text-white font-medium-1">Sedang Diproses</span>
                                <?php else: ?>
                                    <span class="badge badge-danger font-medium-1">Menunggu Apoteker</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Daftar Obat -->
                        <h5 class="font-weight-bold mb-3 text-dark">Daftar Obat</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Dosis / Aturan Pakai</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-right">Harga</th>
                                        <th class="text-right">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($details)): ?>
                                        <?php foreach ($details as $d): ?>
                                            <tr>
                                                <td class="align-middle font-weight-bold text-dark"><?= esc($d['nama_obat']) ?></td>
                                                <td class="align-middle"><?= esc($d['dosis'] ?? '-') ?></td>
                                                <td class="text-center align-middle"><?= esc($d['jumlah']) ?></td>
                                                <td class="text-right align-middle">Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                                                <td class="text-right align-middle font-weight-bold">Rp <?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada detail obat dalam resep ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right font-weight-bold text-dark">Total Pembayaran :</th>
                                        <th class="text-right text-teal font-large-1 font-weight-bold">Rp <?= number_format($resep['total_harga'], 0, ',', '.') ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
