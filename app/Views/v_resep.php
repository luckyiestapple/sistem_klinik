<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Daftar Resep</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Resep</li>
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
          <h4 class="card-title">Manajemen Resep & Pengeluaran Obat</h4>
          <div class="heading-elements">
            <?php if (session()->get('id_level') == 3): ?>
            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-primary btn-sm font-weight-bold">
              <i class="la la-stethoscope"></i> Input Resep Baru (Dari Rekam Medis)
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
                    <th>No. Resep</th>
                    <th>Pasien</th>
                    <th>Dokter Pembuat</th>
                    <th>Tanggal Resep</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($resep)): $no = 1; ?>
                    <?php foreach ($resep as $r): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><strong>RSP-<?= str_pad($r['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                      <td>
                        <?= esc($r['nama_pasien']) ?>
                        <?php if (strtolower($r['status_bpjs'] ?? '') === 'aktif'): ?>
                          <span class="badge badge-success" style="font-size:.7rem;">BPJS</span>
                        <?php endif; ?>
                      </td>
                      <td><?= esc($r['nama_dokter']) ?></td>
                      <td><?= date('d/m/Y', strtotime($r['tgl_resep'])) ?></td>
                      <td>
                        <?php if (strtolower($r['status_bpjs'] ?? '') === 'aktif'): ?>
                          <span class="badge badge-success">Rp 0 &mdash; Gratis (BPJS)</span>
                        <?php else: ?>
                          Rp <?= number_format($r['total_harga'], 0, ',', '.') ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php 
                        $status = $r['status'] ?? 'menunggu';
                        if ($status === 'selesai'): 
                        ?>
                          <span class="badge badge-success">Selesai / Diambil</span>
                        <?php elseif ($status === 'diproses'): ?>
                          <span class="badge badge-warning text-white">Sedang Diproses</span>
                        <?php else: ?>
                          <span class="badge badge-danger">Menunggu Apoteker</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="<?= base_url('resep/detail/'.$r['id_resep']) ?>"
                           class="btn btn-sm btn-info text-white" title="Lihat Detail & Proses">
                           <i class="la la-eye"></i> Detail / Proses
                        </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Belum ada data resep.</td></tr>
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
