<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Rekam Medis</li>
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
          <h4 class="card-title">Riwayat Berobat Pasien</h4>
          <div class="heading-elements">
            <a href="<?= base_url('rekam_medis/tambah') ?>" class="btn btn-primary font-weight-bold">
              <i class="la la-plus"></i> Input Rekam Medis
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
                    <th>Pasien</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Spesialisasi</th>
                    <th>Tanggal Periksa</th>
                    <th>Keluhan Utama</th>
                    <th>Diagnosa</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($rekam_medis)): $no = 1; ?>
                    <?php foreach ($rekam_medis as $r): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><strong><?= esc($r['nama_pasien']) ?></strong></td>
                      <td><?= esc($r['nama_dokter']) ?></td>
                      <td><span class="badge badge-light-info text-dark">Poli <?= esc($r['spesialisasi']) ?></span></td>
                      <td><?= date('d/m/Y', strtotime($r['tgl_periksa'])) ?></td>
                      <td class="text-truncate" style="max-width:180px;"><?= esc($r['keluhan']) ?></td>
                      <td class="font-weight-bold text-success"><?= esc($r['diagnosa']) ?></td>
                      <td>
                        <div class="btn-group btn-group-sm">
                          <a href="<?= base_url('rekam_medis/detail/'.$r['id_rekam_medis']) ?>"
                             class="btn btn-info text-white" title="Detail"><i class="la la-eye"></i> Detail</a>
                          <a href="<?= base_url('rekam_medis/edit/'.$r['id_rekam_medis']) ?>"
                             class="btn btn-warning text-white" title="Edit"><i class="la la-edit"></i> Edit</a>
                          <?php if (session()->get('id_level') == 1): ?>
                            <a href="<?= base_url('rekam_medis/hapus/'.$r['id_rekam_medis']) ?>"
                               class="btn btn-danger" title="Hapus"
                               onclick="return confirm('Hapus rekam medis ini?')"><i class="la la-trash"></i> Hapus</a>
                          <?php endif; ?>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Belum ada data rekam medis.</td></tr>
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
