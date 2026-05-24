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
    .vital-badge {
        font-size: 0.85rem;
        background-color: #f1f5f9;
        color: #475569;
        border-radius: 0.5rem;
        padding: 4px 8px;
        display: inline-block;
        margin-right: 5px;
        margin-bottom: 5px;
        border: 1px solid #e2e8f0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card card-modern rounded-2xl">
                <div class="card-header bg-teal rounded-2xl-top">
                    <h4 class="card-title text-white font-weight-bold mb-0"><i class="ft-activity"></i> Rekam Medis & Riwayat Kesehatan Saya</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-4">
                        <?php if (!empty($riwayatRekmed)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th width="40">#</th>
                                            <th width="140">Tanggal Periksa</th>
                                            <th width="200">Dokter Pemeriksa</th>
                                            <th>Keluhan & Pemeriksaan Fisik</th>
                                            <th width="250">Hasil Diagnosa Dokter</th>
                                            <th width="150">Kontrol Kembali</th>
                                            <th width="90" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; foreach ($riwayatRekmed as $r): ?>
                                            <tr>
                                                <td class="align-middle text-center"><?= $no++ ?></td>
                                                <td class="align-middle font-weight-bold text-dark"><?= date('d/m/Y', strtotime($r['tgl_periksa'])) ?></td>
                                                <td class="align-middle">
                                                    <span class="d-block font-weight-bold text-dark"><?= esc($r['nama_dokter']) ?></span>
                                                    <span class="badge badge-light-teal px-2 py-1 text-teal" style="background-color: #ccfbf1; font-weight: bold; font-size: 0.75rem;">Poli <?= esc($r['spesialisasi']) ?></span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="mb-2">
                                                        <strong class="font-small-3">Keluhan:</strong>
                                                        <span class="d-block text-muted font-small-3"><?= esc($r['keluhan']) ?></span>
                                                    </div>
                                                    
                                                    <!-- Vital Signs / Tanda Vital -->
                                                    <div class="mb-2">
                                                        <span class="vital-badge"><strong>TD:</strong> <?= esc($r['tensi'] ?: '-') ?></span>
                                                        <span class="vital-badge"><strong>Nadi:</strong> <?= esc($r['nadi'] ?: '-') ?></span>
                                                        <span class="vital-badge"><strong>Suhu:</strong> <?= esc($r['suhu'] ?: '-') ?></span>
                                                        <span class="vital-badge"><strong>BB:</strong> <?= $r['berat_badan'] ? esc($r['berat_badan']) . ' kg' : '-' ?></span>
                                                        <span class="vital-badge"><strong>TB:</strong> <?= $r['tinggi_badan'] ? esc($r['tinggi_badan']) . ' cm' : '-' ?></span>
                                                    </div>

                                                    <?php if(!empty($r['pemeriksaan_fisik'])): ?>
                                                        <div>
                                                            <strong class="font-small-3">Pemeriksaan Fisik:</strong>
                                                            <span class="d-block text-muted font-small-3"><?= esc($r['pemeriksaan_fisik']) ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="align-middle font-weight-bold text-teal" style="font-size: 1.05rem;"><?= esc($r['diagnosa']) ?></td>
                                                <td class="align-middle text-center">
                                                    <?php if ($r['tgl_kontrol']): ?>
                                                        <span class="badge badge-warning text-white py-1 px-2 font-weight-bold"><?= date('d/m/Y', strtotime($r['tgl_kontrol'])) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="<?= base_url('rekam_medis_pasien/detail/'.$r['id_rekam_medis']) ?>" class="btn btn-sm btn-teal rounded-pill px-3">
                                                        <i class="ft-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="ft-info font-large-1 d-block mb-2"></i>
                                Belum ada data rekam medis untuk Anda.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
