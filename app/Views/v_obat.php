<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Obat</h3>
    <ol class="breadcrumb"><li class="breadcrumb-item">Klinik</li><li class="breadcrumb-item active">Obat</li></ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Stok Obat Klinik</h4>
          <div class="heading-elements">
            <a href="<?= base_url('obat/tambah') ?>" class="btn btn-primary btn-sm">
              <i class="la la-plus"></i> Tambah Obat
            </a>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Kode Obat</th>
                    <th>Nama Obat</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Harga Satuan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($obat)): $no = 1; ?>
                    <?php foreach ($obat as $o): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><code><?= esc($o['kode_obat']) ?></code></td>
                      <td><?= esc($o['nama_obat']) ?></td>
                      <td><span class="badge badge-light"><?= esc($o['kategori'] ?? '-') ?></span></td>
                      <td>
                        <?php if ((int)$o['stok'] <= 10): ?>
                          <span class="badge badge-danger"><?= $o['stok'] ?> (Rendah)</span>
                        <?php elseif ((int)$o['stok'] <= 30): ?>
                          <span class="badge badge-warning"><?= $o['stok'] ?></span>
                        <?php else: ?>
                          <span class="badge badge-success"><?= $o['stok'] ?></span>
                        <?php endif; ?>
                      </td>
                      <td>Rp <?= number_format($o['harga'], 0, ',', '.') ?></td>
                      <td>
                        <a href="<?= base_url('obat/edit/'.$o['id_obat']) ?>"
                           class="btn btn-sm btn-outline-warning"><i class="la la-edit"></i></a>
                        <a href="<?= base_url('obat/hapus/'.$o['id_obat']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Hapus obat ini?')"><i class="la la-trash"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data obat.</td></tr>
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
