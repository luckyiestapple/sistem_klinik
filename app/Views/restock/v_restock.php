<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Restock Obat</h3>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Riwayat Restock</h4>
          <a href="<?= base_url('restock/tambah') ?>" class="btn btn-primary btn-sm"><i class="la la-plus"></i> Tambah Restock</a>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Obat</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Total Biaya</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($restock)): $no = 1; ?>
                    <?php foreach ($restock as $r): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= date('d/m/Y', strtotime($r['tanggal'])) ?></td>
                      <td><?= esc($r['nama_obat']) ?></td>
                      <td><?= esc($r['keterangan']) ?></td>
                      <td><?= $r['jumlah'] ?></td>
                      <td>Rp <?= number_format($r['harga_beli'], 0, ',', '.') ?></td>
                      <td>Rp <?= number_format($r['total_biaya'], 0, ',', '.') ?></td>
                      <td>
                          <a href="<?= base_url('export/restockPdf/'.$r['id_restock']) ?>" target="_blank" class="btn btn-sm btn-outline-info" title="Cetak PDF"><i class="la la-file-pdf-o"></i> Cetak Invoice PDF</a>
                          <?php if(session()->get('id_level') == 1): ?>
                          <a href="<?= base_url('restock/hapus/'.$r['id_restock']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus restock ini? Stok obat akan dikurangi kembali.')">Hapus</a>
                          <?php endif; ?>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Belum ada riwayat restock.</td></tr>
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
