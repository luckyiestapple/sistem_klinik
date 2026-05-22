<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Data Pasien</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Pasien</li>
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

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
          <h4 class="card-title">Daftar Pasien</h4>
          <div class="card-title-actions mt-1 mt-md-0">
            <a href="<?= base_url('pasien/tambah') ?>" class="btn btn-primary font-weight-bold">
              <i class="ft-plus"></i> Tambah Pasien
            </a>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            
            <!-- Search Filter Form -->
            <form action="<?= base_url('pasien') ?>" method="GET" class="mb-3">
              <div class="input-group col-md-4 pl-0">
                <input type="text" name="keyword" class="form-control" placeholder="Cari Nama Pasien atau ID..." value="<?= esc($keyword ?? '') ?>">
                <div class="input-group-append">
                  <button class="btn btn-info" type="submit"><i class="ft-search"></i> Cari</button>
                  <?php if (!empty($keyword)): ?>
                    <a href="<?= base_url('pasien') ?>" class="btn btn-secondary">Reset</a>
                  <?php endif; ?>
                </div>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>ID Pasien</th>
                    <th>Nama Pasien</th>
                    <th>Jenis Kelamin</th>
                    <th>Tanggal Lahir</th>
                    <th>No. Telepon</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($pasien)): $no = 1; ?>
                    <?php foreach ($pasien as $p): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><span class="badge badge-info"><?= $p['id_pasien'] ?></span></td>
                      <td><strong><?= esc($p['nama']) ?></strong></td>
                      <td><?= $p['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                      <td><?= $p['tgl_lahir'] ? date('d/m/Y', strtotime($p['tgl_lahir'])) : '-' ?></td>
                      <td><?= esc($p['no_telp'] ?? '-') ?></td>
                      <td>
                        <a href="<?= base_url('pasien/edit/'.$p['id_pasien']) ?>"
                           class="btn btn-sm btn-outline-warning" title="Edit"><i class="la la-edit"></i> Edit</a>
                        <a href="<?= base_url('pasien/hapus/'.$p['id_pasien']) ?>"
                           class="btn btn-sm btn-outline-danger" title="Hapus"
                           onclick="return confirm('Hapus pasien ini? Semua data rekam medis dan akun login terkait akan ikut terhapus.')">
                           <i class="la la-trash"></i> Hapus
                        </a>
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
