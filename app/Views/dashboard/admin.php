<?= $this->extend('templates/template') ?>

<?= $this->section('konten') ?>
<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Dashboard Admin & Apoteker</h3>
    <div class="row breadcrumbs-top">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Sistem Informasi Klinik</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>

  <!-- Welcome Banner -->
  <div class="card bg-info text-white box-shadow-2 mb-4">
      <div class="card-body">
          <h4 class="text-white mt-0">Halo, Selamat Datang <strong><?= esc(session()->get('username')); ?></strong>!</h4>
          <p class="mb-0">Ini adalah halaman dashboard panel sistem informasi klinik. Di sini Anda bisa mengelola seluruh data dari mulai pendaftaran pasien hingga pengeluaran resep serta obat.</p>
      </div>
  </div>

  <!-- ── Stat Cards ───────────────────────────── -->
  <div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="align-self-center">
                <i class="ft-users font-large-2 info"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Pasien</h5>
                <h3 class="text-bold-600"><?= $total_pasien ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="align-self-center">
                <i class="ft-user font-large-2 success"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Dokter</h5>
                <h3 class="text-bold-600"><?= $total_dokter ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="align-self-center">
                <i class="ft-package font-large-2 warning"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Stok Obat Rendah</h5>
                <h3 class="text-bold-600 text-danger"><?= $stok_rendah ?> <small style="font-size: 1rem;">Obat</small></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="align-self-center">
                <i class="ft-clipboard font-large-2 danger"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Resep Menunggu</h5>
                <h3 class="text-bold-600"><?= $resep_menunggu ?></h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>


  <!-- ── End Stat Cards ──────────────────────── -->

  <!-- ── Tables ──────────────────────────────── -->
  <div class="row match-height">

    <!-- Daftar Dokter -->
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Dokter Tersedia</h4>
          <div class="heading-elements">
            <a href="<?= base_url('dokter') ?>" class="btn btn-sm btn-outline-info">Lihat Semua</a>
          </div>
        </div>
        <div class="card-content">
          <div class="table-responsive">
            <table class="table table-hover table-xl mb-0">
              <tbody>
                <?php if (!empty($daftar_dokter)): ?>
                  <?php foreach ($daftar_dokter as $d): ?>
                  <tr>
                    <td class="text-truncate p-1">
                      <div class="avatar avatar-md">
                        <img class="media-object rounded-circle"
                             src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($d['nama']) ?>"
                             alt="Avatar" style="width:35px;height:35px;">
                      </div>
                    </td>
                    <td class="text-truncate pl-0">
                      <div class="name font-weight-bold text-dark"><?= esc($d['nama']) ?></div>
                      <div class="designation text-muted font-small-2">Poli <?= esc($d['spesialisasi']) ?></div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="2" class="text-center text-muted">Belum ada data dokter.</td></tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Rekam Medis Terbaru -->
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Rekam Medis Terbaru</h4>
          <div class="heading-elements">
            <a href="<?= base_url('rekam_medis') ?>"
               class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right">
              Lihat Semua
            </a>
          </div>
        </div>
        <div class="card-content mt-1">
          <div class="table-responsive">
            <table class="table table-hover table-xl mb-0">
              <thead>
                <tr>
                  <th class="border-top-0">Pasien</th>
                  <th class="border-top-0">Dokter</th>
                  <th class="border-top-0">Spesialisasi</th>
                  <th class="border-top-0">Tgl Periksa</th>
                  <th class="border-top-0">Diagnosa</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($rekmed_terbaru)): ?>
                  <?php foreach ($rekmed_terbaru as $r): ?>
                  <tr class="pull-up">
                    <td class="text-truncate font-weight-bold text-dark"><?= esc($r['nama_pasien']) ?></td>
                    <td class="text-truncate"><?= esc($r['nama_dokter']) ?></td>
                    <td>
                      <span class="badge badge-light-info text-dark">
                        <?= esc($r['spesialisasi']) ?>
                      </span>
                    </td>
                    <td class="text-truncate">
                      <?= date('d/m/Y', strtotime($r['tgl_periksa'])) ?>
                    </td>
                    <td class="text-truncate font-weight-bold text-success">
                      <?= esc($r['diagnosa']) ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                      Belum ada data rekam medis.
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!-- ── End Tables ──────────────────────────── -->

</div>
<?= $this->endSection() ?>
