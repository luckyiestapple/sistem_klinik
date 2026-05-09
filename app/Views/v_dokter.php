<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Dokter</h3>
    <ol class="breadcrumb"><li class="breadcrumb-item">Klinik</li><li class="breadcrumb-item active">Dokter</li></ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Daftar Dokter</h4>
          <div class="heading-elements">
            <a href="<?= base_url('dokter/tambah') ?>" class="btn btn-primary btn-sm">
              <i class="la la-plus"></i> Tambah Dokter
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
                    <th>ID Dokter</th>
                    <th>Nama Dokter</th>
                    <th>Spesialisasi</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($dokter)): $no = 1; ?>
                    <?php foreach ($dokter as $d): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><span class="badge badge-info"><?= $d['id_dokter'] ?></span></td>
                      <td><?= esc($d['nama']) ?></td>
                      <td><span class="badge badge-light"><?= esc($d['spesialisasi']) ?></span></td>
                      <td><?= esc($d['alamat'] ?? '-') ?></td>
                      <td>
                        <a href="<?= base_url('dokter/edit/'.$d['id_dokter']) ?>"
                           class="btn btn-sm btn-outline-warning" title="Edit"><i class="la la-edit"></i></a>
                        <a href="<?= base_url('dokter/hapus/'.$d['id_dokter']) ?>"
                           class="btn btn-sm btn-outline-danger" title="Hapus"
                           onclick="return confirm('Hapus dokter ini?')"><i class="la la-trash"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="6" class="text-center text-muted py-3">Belum ada data dokter.</td></tr>
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
