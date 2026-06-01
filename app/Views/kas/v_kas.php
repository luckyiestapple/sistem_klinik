<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Laporan Kas Otomatis</h3>
  </div>
</div>

<div class="content-body">
  <!-- Ringkasan Card -->
  <div class="row">
      <div class="col-md-4">
          <div class="card bg-success text-white">
              <div class="card-body text-center">
                  <h4>Total Pemasukan</h4>
                  <h2>Rp <?= number_format($ringkasan['pemasukan'], 0, ',', '.') ?></h2>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card bg-danger text-white">
              <div class="card-body text-center">
                  <h4>Total Pengeluaran</h4>
                  <h2>Rp <?= number_format($ringkasan['pengeluaran'], 0, ',', '.') ?></h2>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card bg-info text-white">
              <div class="card-body text-center">
                  <h4>Saldo Kas</h4>
                  <h2>Rp <?= number_format($ringkasan['saldo'], 0, ',', '.') ?></h2>
              </div>
          </div>
      </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Filter Laporan Kas</h4>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="row">
                <div class="col-md-3">
                    <label>Tipe</label>
                    <select name="tipe" class="form-control">
                        <option value="">Semua</option>
                        <option value="pemasukan" <?= $tipe == 'pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                        <option value="pengeluaran" <?= $tipe == 'pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Tgl Mulai</label>
                    <input type="date" name="tgl_mulai" class="form-control" value="<?= $tgl_mulai ?>">
                </div>
                <div class="col-md-3">
                    <label>Tgl Akhir</label>
                    <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Data Laporan Kas</h4>
          <a href="<?= base_url('export/excel') ?>" class="btn btn-success btn-sm"><i class="la la-file-excel-o"></i> Export Excel (Kas & Resep)</a>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Tipe</th>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($laporan)): $no = 1; ?>
                    <?php foreach ($laporan as $row): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                      <td>
                          <?php if($row['tipe'] == 'pemasukan'): ?>
                              <span class="badge badge-success">Pemasukan</span>
                          <?php else: ?>
                              <span class="badge badge-danger">Pengeluaran</span>
                          <?php endif; ?>
                      </td>
                      <td><?= esc($row['keterangan']) ?></td>
                      <td>Rp <?= number_format($row['nominal'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="5" class="text-center">Belum ada transaksi.</td></tr>
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
