<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
    .rounded-2xl { border-radius: 1rem !important; }
    .card-modern { border: none; box-shadow: 0 4px 6px -1px rgba(0,0,0,.1), 0 2px 4px -1px rgba(0,0,0,.06); }
    .text-teal { color: #0d9488 !important; }
    .bg-teal { background-color: #0d9488 !important; color: white !important; }
    .btn-teal { background-color: #0d9488 !important; border-color: #0d9488 !important; color: white !important; }
    .btn-teal:hover { background-color: #0f766e !important; color: white !important; }
    .vital-card { background:#f8fafc; border:1px solid #e2e8f0; border-radius:.75rem; padding:1rem; text-align:center; }
    .vital-card .val { font-size:1.4rem; font-weight:700; color:#0d9488; }
    .vital-card .lbl { font-size:.75rem; color:#64748b; }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <!-- Header Breadcrumb -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="font-weight-bold mb-0 text-dark"><i class="ft-activity text-teal mr-1"></i> Detail Rekam Medis</h4>
                    <small class="text-muted">Data kunjungan medis Anda</small>
                </div>
                <a href="<?= base_url('rekam_medis_pasien') ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                    <i class="ft-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="row">
                <!-- Kartu Info Kunjungan -->
                <div class="col-md-5 mb-3">
                    <div class="card card-modern rounded-2xl h-100">
                        <div class="card-header bg-teal rounded-2xl-top">
                            <h5 class="card-title text-white mb-0"><i class="ft-user"></i> Informasi Kunjungan</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <th width="130" class="text-muted font-small-3">Tanggal Periksa</th>
                                    <td class="font-weight-bold"><?= date('d F Y', strtotime($rekmed['tgl_periksa'])) ?></td>
                                </tr>
                                <tr>
                                    <th class="text-muted font-small-3">Dokter</th>
                                    <td class="font-weight-bold"><?= esc($rekmed['nama_dokter']) ?></td>
                                </tr>
                                <tr>
                                    <th class="text-muted font-small-3">Poli</th>
                                    <td><span class="badge badge-info px-2 py-1">Poli <?= esc($rekmed['spesialisasi']) ?></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Kartu Tanda Vital -->
                <div class="col-md-7 mb-3">
                    <div class="card card-modern rounded-2xl h-100">
                        <div class="card-header bg-teal rounded-2xl-top">
                            <h5 class="card-title text-white mb-0"><i class="ft-activity"></i> Tanda-Tanda Vital</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6 col-md-4 mb-2">
                                    <div class="vital-card">
                                        <div class="val"><?= esc($rekmed['tensi'] ?: '-') ?></div>
                                        <div class="lbl">Tekanan Darah</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-2">
                                    <div class="vital-card">
                                        <div class="val"><?= esc($rekmed['nadi'] ?: '-') ?></div>
                                        <div class="lbl">Nadi</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4 mb-2">
                                    <div class="vital-card">
                                        <div class="val"><?= esc($rekmed['suhu'] ?: '-') ?></div>
                                        <div class="lbl">Suhu Tubuh</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 mb-2">
                                    <div class="vital-card">
                                        <div class="val"><?= $rekmed['berat_badan'] ? esc($rekmed['berat_badan']) . ' kg' : '-' ?></div>
                                        <div class="lbl">Berat Badan</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="vital-card">
                                        <div class="val"><?= $rekmed['tinggi_badan'] ? esc($rekmed['tinggi_badan']) . ' cm' : '-' ?></div>
                                        <div class="lbl">Tinggi Badan</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hasil Pemeriksaan -->
                <div class="col-12 mb-3">
                    <div class="card card-modern rounded-2xl">
                        <div class="card-header bg-teal rounded-2xl-top">
                            <h5 class="card-title text-white mb-0"><i class="ft-file-text"></i> Hasil Pemeriksaan</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="font-weight-bold text-muted font-small-3 text-uppercase">Keluhan &amp; Gejala</label>
                                <div class="p-3 border rounded bg-light"><?= nl2br(esc($rekmed['keluhan'])) ?></div>
                            </div>
                            <?php if (!empty($rekmed['pemeriksaan_fisik'])): ?>
                            <div class="mb-3">
                                <label class="font-weight-bold text-muted font-small-3 text-uppercase">Catatan Pemeriksaan Fisik</label>
                                <div class="p-3 border rounded bg-light"><?= nl2br(esc($rekmed['pemeriksaan_fisik'])) ?></div>
                            </div>
                            <?php endif; ?>
                            <div class="mb-0">
                                <label class="font-weight-bold text-success font-small-3 text-uppercase">Diagnosa / Hasil Akhir</label>
                                <div class="p-3 border border-success rounded" style="background:#f0fff4;">
                                    <strong><?= nl2br(esc($rekmed['diagnosa'])) ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jadwal Kontrol -->
                <?php if (!empty($rekmed['tgl_kontrol'])): ?>
                <div class="col-md-6 mb-3">
                    <div class="card card-modern rounded-2xl border-warning">
                        <div class="card-body text-center py-3">
                            <i class="ft-calendar" style="font-size:2rem;color:#f59e0b;"></i>
                            <div class="font-weight-bold mt-1">Jadwal Kontrol Kembali</div>
                            <div class="h5 text-warning font-weight-bold mt-1"><?= date('d F Y', strtotime($rekmed['tgl_kontrol'])) ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
