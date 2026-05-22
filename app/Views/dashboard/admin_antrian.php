<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Kelola Antrian Pasien Global</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active">Antrian</li>
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
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
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
        <form action="<?= base_url('admin/antrian') ?>" method="GET" class="row">
          <div class="col-md-3 col-12 form-group">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal" class="form-control" value="<?= esc($filter['tanggal']) ?>">
          </div>
          <div class="col-md-3 col-12 form-group">
            <label>Dokter / Poli</label>
            <select name="dokter_id" class="form-control">
              <option value="">-- Semua Dokter --</option>
              <?php foreach ($dokterList as $d): ?>
                <option value="<?= $d['id_dokter'] ?>" <?= $filter['dokter_id'] == $d['id_dokter'] ? 'selected' : '' ?>>
                  <?= esc($d['nama']) ?> (Poli <?= esc($d['spesialisasi']) ?>)
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="col-md-3 col-12 form-group">
            <label>Status</label>
            <select name="status" class="form-control">
              <option value="">-- Semua Status --</option>
              <option value="menunggu" <?= $filter['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
              <option value="dipanggil" <?= $filter['status'] === 'dipanggil' ? 'selected' : '' ?>>Dipanggil</option>
              <option value="selesai" <?= $filter['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
              <option value="batal" <?= $filter['status'] === 'batal' ? 'selected' : '' ?>>Batal</option>
            </select>
          </div>
          <div class="col-md-3 col-12 form-group d-flex align-items-end">
            <button type="submit" class="btn btn-primary btn-block"><i class="la la-filter"></i> Terapkan Filter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Queue List -->
  <div class="card">
    <div class="card-header"><h4 class="card-title">Daftar Antrian Kunjungan</h4></div>
    <div class="card-content">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-hover mb-0">
            <thead>
              <tr class="text-center">
                <th width="80">No. Antrian</th>
                <th>Pasien</th>
                <th>Dokter Tujuan</th>
                <th>Poli</th>
                <th>Tanggal</th>
                <th>Keluhan Utama</th>
                <th>Status</th>
                <th>Aksi</th>
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
                  <td><strong><?= esc($a['nama_dokter']) ?></strong></td>
                  <td class="text-center"><span class="badge badge-light-info">Poli <?= esc($a['spesialisasi']) ?></span></td>
                  <td class="text-center"><?= date('d/m/Y', strtotime($a['tgl_antrean'])) ?></td>
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
                    <!-- Inline status changer -->
                    <form action="<?= base_url('admin/antrian/update_status/'.$a['id_antrean']) ?>" method="POST" class="form-inline d-inline-block">
                      <?= csrf_field() ?>
                      <div class="input-group input-group-sm">
                        <select name="status" class="form-control form-control-sm" style="width: 110px;" onchange="this.form.submit()">
                          <option value="menunggu" <?= $a['status'] === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                          <option value="dipanggil" <?= $a['status'] === 'dipanggil' ? 'selected' : '' ?>>Panggil</option>
                          <option value="selesai" <?= $a['status'] === 'selesai' ? 'selected' : '' ?>>Selesai</option>
                          <option value="batal" <?= $a['status'] === 'batal' ? 'selected' : '' ?>>Batal</option>
                        </select>
                      </div>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted py-4">
                    Belum ada antrian terdaftar dengan kriteria filter di atas.
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
