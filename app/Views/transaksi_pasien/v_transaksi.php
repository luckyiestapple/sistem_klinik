<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Riwayat Transaksi Pasien</h3>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Daftar Transaksi</h4>
          <a href="<?= base_url('transaksipasien/tambah') ?>" class="btn btn-primary btn-sm"><i class="la la-plus"></i> Transaksi Baru</a>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pasien</th>
                    <th>Status Pasien</th>
                    <th>Total Biaya</th>
                    <th>Admin</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($transaksi)): $no = 1; ?>
                    <?php foreach ($transaksi as $t): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                      <td><?= esc($t['nama_pasien']) ?></td>
                      <td>
                          <?php if($t['is_bpjs']): ?>
                              <span class="badge badge-info">BPJS</span>
                          <?php else: ?>
                              <span class="badge badge-secondary">Umum</span>
                          <?php endif; ?>
                      </td>
                      <td>Rp <?= number_format($t['total_biaya'], 0, ',', '.') ?></td>
                      <td><?= esc($t['username']) ?></td>
                      <td>
                          <a href="<?= base_url('transaksipasien/nota/'.$t['id_transaksi']) ?>" class="btn btn-sm btn-outline-info" target="_blank"><i class="la la-print"></i> Cetak Nota</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center py-3">Belum ada transaksi.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
