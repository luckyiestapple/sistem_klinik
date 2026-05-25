<?= $this->extend('templates/template') ?>
<?= $this->section('css') ?>
<style>
@media print {
  .no-print, .sidebar, .header-navbar, .content-header, nav, .breadcrumb,
  .btn, form, .heading-elements, .card-header .heading-elements, .main-menu { display: none !important; }
  .card { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
  .card-header { background: none !important; color: #000 !important; border: none !important; }
  body { font-size: 12px; background-color: #fff !important; }
  .print-header { display: block !important; }
  .table-responsive { display: block !important; width: 100% !important; overflow-x: visible !important; }
  table th:last-child, table td:last-child { display: none !important; } /* Hide Action column */
  .app-content { margin-left: 0 !important; padding: 0 !important; }
  .content-wrapper { padding: 0 !important; }
}
.print-header { display: none; }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-header row no-print">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Rekam Medis</li>
    </ol>
  </div>
</div>

<!-- Print Header (hanya muncul saat print) -->
<div class="print-header text-center mb-3">
  <h3 class="font-weight-bold">KLINIK SEHAT</h3>
  <p class="mb-0">Jl. Kesehatan No. 1 | Telp: (021) 000-0000</p>
  <hr>
  <h4 class="font-weight-bold">LAPORAN HARIAN REKAM MEDIS</h4>
  <p class="mb-0">Tanggal Cetak: <?= date('d F Y') ?></p>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
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
          <div class="heading-elements d-flex" style="gap:10px;">
            <?php if (session()->get('id_level') == 1): // Admin only ?>
            <button onclick="window.print()" class="btn btn-outline-secondary font-weight-bold no-print">
              <i class="la la-print"></i> Cetak Laporan Harian
            </button>
            <?php endif; ?>
            <?php if (session()->get('id_level') == 3): ?>
            <a href="<?= base_url('rekam_medis/tambah') ?>" class="btn btn-primary font-weight-bold no-print">
              <i class="la la-plus"></i> Input Rekam Medis
            </a>
            <?php endif; ?>
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
                        <div class="d-flex flex-wrap" style="gap:5px;">
                          <a href="<?= base_url('rekam_medis/detail/'.$r['id_rekam_medis']) ?>"
                             class="btn btn-sm btn-info text-white" title="Detail"><i class="la la-eye"></i> Detail</a>
                          <a href="<?= base_url('rekam_medis/edit/'.$r['id_rekam_medis']) ?>"
                             class="btn btn-sm btn-warning text-white" title="Edit"><i class="la la-edit"></i> Edit</a>
                          <?php if (session()->get('id_level') == 1): ?>
                            <a href="<?= base_url('rekam_medis/hapus/'.$r['id_rekam_medis']) ?>"
                               class="btn btn-sm btn-danger" title="Hapus"
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
