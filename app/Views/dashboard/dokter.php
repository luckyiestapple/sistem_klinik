<?= $this->extend('templates/template') ?>

<?= $this->section('konten') ?>
<div class="content-header row mb-3">
  <div class="col-12">
    <h2 class="content-header-title text-bold-700">Dashboard Dokter</h2>
    <p class="text-muted">Halo, dr. <strong><?= esc($dokter['nama']); ?></strong>. Berikut adalah ringkasan praktik dan daftar antrean Anda hari ini.</p>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>

  <!-- Stats Cards -->
  <div class="row">
    <div class="col-xl-4 col-md-4 col-12">
      <div class="card bg-info text-white text-center box-shadow-2">
        <div class="card-body">
          <h5 class="text-white">Total Antrean Hari Ini</h5>
          <h2 class="text-white text-bold-700 mt-2"><?= $total_today ?></h2>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-md-4 col-12">
      <div class="card bg-success text-white text-center box-shadow-2">
        <div class="card-body">
          <h5 class="text-white">Selesai Diperiksa</h5>
          <h2 class="text-white text-bold-700 mt-2"><?= $completed_today ?></h2>
        </div>
      </div>
    </div>
    <div class="col-xl-4 col-md-4 col-12">
      <div class="card bg-warning text-white text-center box-shadow-2">
        <div class="card-body">
          <h5 class="text-white">Sisa Antrean</h5>
          <h2 class="text-white text-bold-700 mt-2"><?= $pending_today ?></h2>
        </div>
      </div>
    </div>
  </div>

  <!-- Today's Queue List -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title text-bold-600">Antrean Pemeriksaan Hari Ini (Tanggal: <?= date('d/m/Y') ?>)</h4>
          <a href="<?= base_url('dokter/antrian') ?>" class="btn btn-outline-info btn-sm">Lihat Semua Riwayat</a>
        </div>
        <div class="card-content mt-1">
          <div class="table-responsive">
            <table class="table table-hover table-xl mb-0">
              <thead>
                <tr class="text-center">
                  <th width="100">No. Antrean</th>
                  <th>Nama Pasien</th>
                  <th>Gender / Umur</th>
                  <th>Keluhan Utama</th>
                  <th>Status</th>
                  <th>Aksi Tindakan</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($antrean)): ?>
                  <?php foreach ($antrean as $a): ?>
                  <tr>
                    <td class="text-center">
                      <span class="badge badge-pill badge-primary font-medium-2 py-1 px-2"><?= esc($a['nomor_antrean']) ?></span>
                    </td>
                    <td class="font-weight-bold text-dark"><?= esc($a['nama_pasien']) ?></td>
                    <td class="text-center">
                      <?= $a['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?> / 
                      <?php 
                        if (!empty($a['tgl_lahir'])) {
                            $birthDate = new \DateTime($a['tgl_lahir']);
                            $today = new \DateTime();
                            $age = $today->diff($birthDate)->y;
                            echo $age . ' Thn';
                        } else {
                            echo '-';
                        }
                      ?>
                    </td>
                    <td><?= esc($a['keluhan'] ?: '-') ?></td>
                    <td class="text-center">
                      <?php if ($a['status'] === 'menunggu'): ?>
                        <span class="badge badge-danger">Menunggu</span>
                      <?php elseif ($a['status'] === 'dipanggil'): ?>
                        <span class="badge badge-warning text-white">Dipanggil</span>
                      <?php elseif ($a['status'] === 'selesai'): ?>
                        <span class="badge badge-success">Selesai</span>
                      <?php else: ?>
                        <span class="badge badge-secondary">Batal</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <?php if ($a['status'] === 'menunggu' || $a['status'] === 'dipanggil'): ?>
                        <div class="d-flex justify-content-center">
                          <!-- Form panggil -->
                          <form action="<?= base_url('dokter/antrian/panggil/'.$a['id_antrean']) ?>" method="POST" class="mr-2">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-warning">
                              <i class="la la-volume-up"></i> <?= $a['status'] === 'dipanggil' ? 'Panggil Lagi' : 'Panggil' ?>
                            </button>
                          </form>
                          <!-- Form periksa -->
                          <form action="<?= base_url('dokter/antrian/selesai/'.$a['id_antrean']) ?>" method="POST">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-info text-white font-weight-bold">
                              <i class="la la-stethoscope"></i> Mulai Periksa
                            </button>
                          </form>
                        </div>
                      <?php elseif ($a['status'] === 'selesai'): ?>
                        <span class="text-success font-weight-bold font-small-3"><i class="la la-check"></i> Selesai Diperiksa</span>
                      <?php else: ?>
                        <span class="text-muted font-small-3">Batal</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                      Belum ada antrean pasien untuk hari ini.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
