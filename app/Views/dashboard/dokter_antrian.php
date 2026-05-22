<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row mb-3">
  <div class="col-12">
    <h3 class="content-header-title text-bold-700">Daftar Riwayat Antrian Saya</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard_dokter') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active">Riwayat Antrian</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>

  <!-- Filter Bar -->
  <div class="card">
    <div class="card-header"><h4 class="card-title">Filter Antrean</h4></div>
    <div class="card-content">
      <div class="card-body">
        <form action="<?= base_url('dokter/antrian') ?>" method="GET" class="row">
          <div class="col-md-4 col-12 form-group">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal" class="form-control" value="<?= esc($filter['tanggal']) ?>">
          </div>
          <div class="col-md-4 col-12 form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="">-- Semua Status --</option>
              <option value="menunggu" <?= $filter['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
              <option value="dipanggil" <?= $filter['status'] === 'dipanggil' ? 'selected' : '' ?>>Dipanggil</option>
              <option value="selesai" <?= $filter['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
              <option value="batal" <?= $filter['status'] === 'batal' ? 'selected' : '' ?>>Batal</option>
            </select>
          </div>
          <div class="col-md-4 col-12 form-group d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block"><i class="la la-filter"></i> Terapkan Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Queue List -->
  <div class="card">
    <div class="card-header"><h4 class="card-title">Daftar Kunjungan Pasien</h4></div>
    <div class="card-content">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr class="text-center">
                <th width="100">No. Antrian</th>
                <th>Pasien</th>
                <th>Gender</th>
                <th>No. Telp</th>
                <th>Keluhan Utama</th>
                <th>Status</th>
                <th>Tindakan</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($antrean)): ?>
                <?php foreach ($antrean as $a): ?>
                <tr>
                  <td class="text-center">
                    <span class="badge badge-pill badge-primary font-medium-2 py-1 px-2"><?= esc($a['nomor_antrean']) ?></span>
                  </td>
                  <td><strong><?= esc($a['nama_pasien']) ?></strong><br><small class="text-muted"><?= $a['id_pasien'] ?></small></td>
                  <td class="text-center"><?= $a['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                  <td class="text-center"><?= esc($a['no_telp'] ?? '-') ?></td>
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
                      <form action="<?= base_url('dokter/antrian/selesai/'.$a['id_antrean']) ?>" method="POST" class="d-inline">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-sm btn-info text-white font-weight-bold">
                          <i class="la la-stethoscope"></i> Mulai Periksa
                        </button>
                      </form>
                    <?php elseif ($a['status'] === 'selesai'): ?>
                      <span class="text-success font-weight-bold font-small-3"><i class="la la-check"></i> Selesai</span>
                    <?php else: ?>
                      <span class="text-muted font-small-3">Batal</span>
                    <?php endif; ?>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    Belum ada antrean terdaftar dengan kriteria filter di atas.
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
<?= $this->endSection() ?>
