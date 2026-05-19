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
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show rounded-2xl mb-4" role="alert">
            <strong>Gagal!</strong> <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Form Ambil Antrian -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card card-modern rounded-2xl">
                <div class="card-header bg-teal rounded-2xl-top">
                    <h4 class="card-title text-white font-weight-bold mb-0"><i class="ft-calendar"></i> Ambil Nomor Antrean</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-4">
                        <form action="<?= base_url('antrian/simpan') ?>" method="POST" id="formAntrian">
                            <?= csrf_field() ?>
                            
                            <!-- Pilih Poliklinik / Spesialisasi -->
                            <div class="form-group mb-3">
                                <label for="poliklinik" class="font-weight-bold text-dark">Pilih Poliklinik (Spesialisasi)</label>
                                <select class="form-control rounded-pill" id="poliklinik" name="poliklinik" required>
                                    <option value="" disabled selected>-- Pilih Poliklinik --</option>
                                    <?php foreach ($spesialisasi as $sp): ?>
                                        <option value="<?= esc($sp['spesialisasi']) ?>"><?= esc($sp['spesialisasi']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Pilih Dokter -->
                            <div class="form-group mb-3">
                                <label for="id_dokter" class="font-weight-bold text-dark">Pilih Dokter</label>
                                <select class="form-control rounded-pill" id="id_dokter" name="id_dokter" required disabled>
                                    <option value="" disabled selected>-- Pilih Poliklinik Dahulu --</option>
                                </select>
                            </div>

                            <!-- Pilih Tanggal Kunjungan -->
                            <div class="form-group mb-4">
                                <label for="tgl_antrean" class="font-weight-bold text-dark">Tanggal Kunjungan</label>
                                <input type="date" class="form-control rounded-pill" id="tgl_antrean" name="tgl_antrean" min="<?= date('Y-m-d') ?>" required>
                            </div>

                            <button type="submit" class="btn btn-teal btn-block rounded-pill font-weight-bold py-2">
                                <i class="ft-check"></i> Ambil Antrean Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Antrian -->
        <div class="col-md-6 col-12 mb-4">
            <div class="card card-modern rounded-2xl">
                <div class="card-header bg-teal rounded-2xl-top">
                    <h4 class="card-title text-white font-weight-bold mb-0"><i class="ft-clock"></i> Riwayat & Status Antrean</h4>
                </div>
                <div class="card-content">
                    <div class="card-body p-4">
                        <?php if (!empty($riwayatAntrean)): ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Tgl Kunjungan</th>
                                            <th>Poli / Dokter</th>
                                            <th class="text-center">No. Antrean</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($riwayatAntrean as $ra): ?>
                                            <tr>
                                                <td class="align-middle"><?= date('d/m/Y', strtotime($ra['tgl_antrean'])) ?></td>
                                                <td class="align-middle">
                                                    <span class="d-block font-weight-bold text-dark">Poli <?= esc($ra['spesialisasi']) ?></span>
                                                    <small class="text-muted"><?= esc($ra['nama_dokter']) ?></small>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <span class="badge badge-info font-weight-bold" style="font-size: 1rem;"><?= esc($ra['nomor_antrean']) ?></span>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <?php if ($ra['status'] === 'menunggu'): ?>
                                                        <span class="badge badge-warning">Menunggu</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Selesai</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted">
                                <i class="ft-info font-large-1 d-block mb-2"></i>
                                Belum ada riwayat antrean untuk Anda.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    // List all doctors
    const doctors = <?= json_encode($dokter) ?>;

    document.getElementById('poliklinik').addEventListener('change', function() {
        const selectedPoli = this.value;
        const dokterSelect = document.getElementById('id_dokter');
        
        // Clear previous options
        dokterSelect.innerHTML = '<option value="" disabled selected>-- Pilih Dokter --</option>';
        dokterSelect.disabled = false;

        // Filter and add new options
        const filteredDoctors = doctors.filter(doc => doc.spesialisasi === selectedPoli);
        
        if (filteredDoctors.length > 0) {
            filteredDoctors.forEach(doc => {
                const opt = document.createElement('option');
                opt.value = doc.id_dokter;
                opt.textContent = doc.nama;
                dokterSelect.appendChild(opt);
            });
        } else {
            dokterSelect.innerHTML = '<option value="" disabled selected>Tidak ada dokter tersedia</option>';
            dokterSelect.disabled = true;
        }
    });
</script>
<?= $this->endSection() ?>
