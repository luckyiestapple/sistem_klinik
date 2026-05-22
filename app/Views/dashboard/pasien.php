<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
    .dashboard-pasien {
        font-family: 'Inter', sans-serif;
        color: #334155;
    }
    .rounded-2xl { border-radius: 1rem !important; }
    .card-modern {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .text-teal { color: #0d9488 !important; }
    .bg-teal-light { background-color: #ccfbf1 !important; }
    .bg-teal { background-color: #0d9488 !important; color: white !important; }
    .btn-teal { background-color: #0d9488 !important; border-color: #0d9488 !important; color: white !important; }
    .btn-teal:hover { background-color: #0f766e !important; color: white !important; }
    .btn-outline-teal { color: #0d9488 !important; border-color: #0d9488 !important; }
    .btn-outline-teal:hover { background-color: #0d9488 !important; color: white !important; }
    
    .text-blue { color: #2563eb !important; }
    .bg-blue-light { background-color: #dbeafe !important; }
    
    .text-orange { color: #ea580c !important; }
    .bg-orange-light { background-color: #ffedd5 !important; }

    .text-danger-custom { color: #e11d48 !important; }
    .bg-danger-custom-light { background-color: #ffe4e6 !important; }
    
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.5rem;
    }
    
    .highlight-card {
        background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%);
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body dashboard-pasien">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-2xl mb-4" role="alert">
            <strong>Sukses!</strong> <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <!-- Header / Sapaan -->
    <div class="row mb-3 mt-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-weight-bold mb-0">Halo, <?= esc($pasien['nama']) ?> 👋</h2>
                <p class="text-muted">NIK/No. BPJS: <strong><?= esc($pasien['no_bpjs'] ?: $pasien['id_pasien']) ?></strong>. Selamat datang di portal pasien.</p>
            </div>
        </div>
    </div>

    <!-- Health Summary Cards (Dynamic from Database) -->
    <div class="row">
        <!-- Card 1: Tekanan Darah -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-orange-light text-orange mr-3">
                            <i class="ft-heart"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Tekanan Darah</p>
                            <h4 class="mb-0 font-weight-bold"><?= esc($latest_rekmed['tensi'] ?? 'Belum ada') ?></h4>
                        </div>
                    </div>
                    <div class="mt-2 text-muted font-small-2">
                        <?php if(!empty($latest_rekmed['tensi'])): ?>
                            <i class="ft-check-circle text-success"></i> Terakhir diperiksa
                        <?php else: ?>
                            <i class="ft-info text-warning"></i> Belum ada rekam medis
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Nadi & Suhu -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-blue-light text-blue mr-3">
                            <i class="ft-activity"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Nadi / Suhu</p>
                            <h4 class="mb-0 font-weight-bold">
                                <?= esc($latest_rekmed['nadi'] ?? '-') ?> / <?= esc($latest_rekmed['suhu'] ?? '-') ?>
                            </h4>
                        </div>
                    </div>
                    <div class="mt-2 text-muted font-small-2">
                        <?php if(!empty($latest_rekmed['nadi'])): ?>
                            <i class="ft-check-circle text-success"></i> Terakhir diperiksa
                        <?php else: ?>
                            <i class="ft-info text-warning"></i> Belum ada rekam medis
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: BPJS Status -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-teal-light text-teal mr-3">
                            <i class="ft-shield"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Kepesertaan BPJS</p>
                            <?php 
                            $statusBpjs = strtoupper($pasien['status_bpjs'] ?? 'TIDAK AKTIF');
                            if ($statusBpjs === 'AKTIF'):
                            ?>
                                <h4 class="mb-0 font-weight-bold text-success">AKTIF</h4>
                            <?php else: ?>
                                <h4 class="mb-0 font-weight-bold text-danger">TIDAK AKTIF</h4>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mt-2 text-muted font-small-2 text-truncate">
                        Faskes: <?= esc($pasien['faskes'] ?: 'Klinik Utama Sehat') ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Kunjungan Terakhir -->
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-teal text-white mr-3">
                            <i class="ft-calendar"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Kunjungan Terakhir</p>
                            <h4 class="mb-0 font-weight-bold">
                                <?= !empty($latest_rekmed['tgl_periksa']) ? date('d/m/Y', strtotime($latest_rekmed['tgl_periksa'])) : 'Belum Pernah' ?>
                            </h4>
                        </div>
                    </div>
                    <div class="mt-2 text-muted font-small-2">
                        <?php if ($latest_rekmed && !empty($latest_rekmed['tgl_kontrol'])): ?>
                            <i class="ft-info text-info"></i> Kontrol: <?= date('d/m/Y', strtotime($latest_rekmed['tgl_kontrol'])) ?>
                        <?php else: ?>
                            <i class="ft-info text-muted"></i> Tidak ada kontrol dijadwalkan
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Antrean Terdekat & Resep Baru (Side-by-Side) -->
    <div class="row">
        <!-- Highlight Card: Jadwal Kontrol / Antrean -->
        <div class="col-lg-6 col-12">
            <?php if (!empty($antrean)): ?>
                <div class="card card-modern highlight-card rounded-2xl mb-4">
                    <div class="card-body p-4">
                        <h5 class="text-white mb-3"><i class="ft-calendar"></i> Antrean Aktif Hari Ini / Mendatang</h5>
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h3 class="text-white font-weight-bold"><?= esc($antrean['nama_dokter']) ?></h3>
                                <p class="mb-1"><i class="ft-map-pin"></i> Poli <?= esc($antrean['spesialisasi']) ?></p>
                                <p class="mb-0"><i class="ft-clock"></i> <?= date('d M Y', strtotime($antrean['tgl_antrean'])) ?></p>
                            </div>
                            <div class="col-md-4 text-center mt-3 mt-md-0">
                                <div class="bg-white text-teal rounded p-2 mb-2 d-inline-block">
                                    <span class="d-block font-small-2 font-weight-bold text-uppercase text-muted">No. Antrean</span>
                                    <h2 class="mb-0 font-weight-bold text-teal"><?= esc($antrean['nomor_antrean']) ?></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="card card-modern rounded-2xl mb-4" style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: white; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div class="card-body p-4 text-center">
                        <h5 class="text-white mb-2"><i class="ft-calendar"></i> Belum ada jadwal antrean mendatang</h5>
                        <p class="text-white-50 font-small-3 mb-3">Ambil nomor antrean online secara cepat tanpa antre di klinik.</p>
                        <a href="<?= base_url('antrian') ?>" class="btn btn-light rounded-pill font-weight-bold px-4">Ambil Antrean Online</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Active Prescriptions -->
        <div class="col-lg-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-header bg-white border-bottom-0 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="font-weight-bold text-dark mb-0">Resep Obat Terbaru</h5>
                    <a href="<?= base_url('resep_pasien') ?>" class="btn btn-outline-teal btn-sm rounded-pill px-3">Lihat Semua</a>
                </div>
                <div class="card-body p-0 mt-3">
                    <?php if (!empty($resepList)): ?>
                        <ul class="list-group list-group-flush rounded-2xl">
                            <?php foreach ($resepList as $resep): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-teal-light text-teal mr-3" style="width:40px;height:40px;font-size:1.2rem; min-width: 40px;">
                                            <i class="ft-clipboard"></i>
                                        </div>
                                        <div style="max-width: 250px;">
                                            <h6 class="mb-0 font-weight-bold">Resep Tanggal <?= date('d/m/Y', strtotime($resep['tgl_resep'])) ?></h6>
                                            <span class="text-muted font-small-3 text-truncate d-block">
                                                Obat: 
                                                <?php 
                                                $names = [];
                                                foreach ($resep['details'] as $d) {
                                                    $names[] = esc($d['nama_obat']);
                                                }
                                                echo empty($names) ? 'Tidak ada detail obat' : implode(', ', $names);
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <a href="<?= base_url('resep_pasien/detail/'.$resep['id_resep']) ?>" class="btn btn-sm btn-outline-teal rounded-pill font-weight-bold">Detail</a>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <div class="p-4 text-center text-muted" style="min-height: 120px; display: flex; align-items: center; justify-content: center;">Belum ada resep obat untuk Anda.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
