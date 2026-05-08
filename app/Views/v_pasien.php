<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Pasien</h3>
    <ol class="breadcrumb"><li class="breadcrumb-item">Klinik</li><li class="breadcrumb-item active">Pasien</li></ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Daftar Pasien</h4>
          <div class="heading-elements">
            <a href="<?= base_url('pasien/tambah') ?>" class="btn btn-primary btn-sm">
              <i class="la la-plus"></i> Daftarkan Pasien
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
                    <th>Nama Pasien</th>
                    <th>JK</th>
                    <th>Tgl Lahir</th>
                    <th>No. Telepon</th>
                    <th>Tgl Daftar</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($pasien)): $no = 1; ?>
                    <?php foreach ($pasien as $p): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= esc($p['nama_pasien']) ?></td>
                      <td><?= $p['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                      <td><?= $p['tanggal_lahir'] ? date('d/m/Y', strtotime($p['tanggal_lahir'])) : '-' ?></td>
                      <td><?= esc($p['no_telp'] ?? '-') ?></td>
                      <td><?= $p['created_at'] ? date('d/m/Y', strtotime($p['created_at'])) : '-' ?></td>
                      <td>
                        <a href="<?= base_url('rekam_medis/tambah?id_pasien='.$p['id_pasien']) ?>"
                           class="btn btn-sm btn-outline-success" title="Input Rekam Medis">
                          <i class="la la-stethoscope"></i>
                        </a>
                        <a href="<?= base_url('pasien/edit/'.$p['id_pasien']) ?>"
                           class="btn btn-sm btn-outline-warning"><i class="la la-edit"></i></a>
                        <a href="<?= base_url('pasien/hapus/'.$p['id_pasien']) ?>"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Hapus pasien ini?')"><i class="la la-trash"></i></a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="7" class="text-center text-muted py-3">Belum ada data pasien.</td></tr>
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
