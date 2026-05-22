<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Obat</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Obat</li>
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

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
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
                    <th>Kode</th>
                    <th>Nama Obat</th>
                    <th>Kandungan</th>
                    <th>Satuan</th>
                    <th>Stok</th>
                    <th>Tgl Kadaluarsa</th>
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
                      <td><strong><?= esc($o['nama_obat']) ?></strong></td>
                      <td><?= esc($o['kandungan'] ?: '-') ?></td>
                      <td><span class="badge badge-light-secondary"><?= esc($o['satuan']) ?></span></td>
                      <td>
                        <?php 
                        $stok = (int)$o['stok'];
                        $min = (int)($o['stok_minimum'] ?? 10);
                        if ($stok <= $min): 
                        ?>
                          <span class="badge badge-danger"><?= $stok ?> (Rendah)</span>
                        <?php else: ?>
                          <span class="badge badge-success"><?= $stok ?></span>
                        <?php endif; ?>
                      </td>
                      <td><?= $o['tgl_expired'] ? date('d/m/Y', strtotime($o['tgl_expired'])) : '-' ?></td>
                      <td>Rp <?= number_format($o['harga'], 0, ',', '.') ?></td>
                      <td>
                        <a href="<?= base_url('obat/edit/'.$o['kode_obat']) ?>"
                           class="btn btn-sm btn-outline-warning" title="Edit"><i class="la la-edit"></i> Edit</a>
                        <a href="<?= base_url('obat/hapus/'.$o['kode_obat']) ?>"
                           class="btn btn-sm btn-outline-danger" title="Hapus"
                           onclick="return confirm('Hapus obat ini?')"><i class="la la-trash"></i> Hapus</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="9" class="text-center text-muted py-3">Belum ada data obat.</td></tr>
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
