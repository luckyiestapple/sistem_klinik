<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Dashboard</h3>
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

  <!-- ── Stat Cards ───────────────────────────── -->
  <div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-12">
      <div class="card pull-up">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="align-self-center">
                <i class="la la-users font-large-2 info"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Pasien</h5>
                <h3 class="text-bold-600"><?= $total_pasien ?? 0 ?></h3>
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
                <i class="la la-user-md font-large-2 success"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Total Dokter</h5>
                <h3 class="text-bold-600"><?= $total_dokter ?? 0 ?></h3>
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
                <i class="la la-stethoscope font-large-2 warning"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Periksa Hari Ini</h5>
                <h3 class="text-bold-600"><?= $rekmed_hari_ini ?? 0 ?></h3>
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
                <i class="la la-clipboard font-large-2 danger"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Resep Menunggu</h5>
                <h3 class="text-bold-600"><?= $resep_menunggu ?? 0 ?></h3>
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
                             src="<?= base_url('app-assets/images/portrait/small/avatar-s-4.png') ?>"
                             alt="Avatar">
                      </div>
                    </td>
                    <td class="text-truncate pl-0">
                      <div class="name"><?= esc($d['nama_dokter']) ?></div>
                      <div class="designation text-light font-small-2"><?= esc($d['spesialisasi']) ?></div>
                    </td>
                    <td class="text-right">
                      <a href="<?= base_url('rekam_medis/tambah') ?>"
                         class="btn btn-sm btn-outline-success">Input Rekam Medis</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr><td colspan="3" class="text-center text-muted">Belum ada data dokter.</td></tr>
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
                  <th class="border-top-0">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($rekmed_terbaru)): ?>
                  <?php foreach (array_slice($rekmed_terbaru, 0, 5) as $r): ?>
                  <tr class="pull-up">
                    <td class="text-truncate"><?= esc($r['nama_pasien']) ?></td>
                    <td class="text-truncate"><?= esc($r['nama_dokter']) ?></td>
                    <td>
                      <button type="button" class="btn btn-sm btn-outline-info round">
                        <?= esc($r['spesialisasi']) ?>
                      </button>
                    </td>
                    <td class="text-truncate">
                      <?= date('d/m/Y H:i', strtotime($r['tanggal_periksa'])) ?>
                    </td>
                    <td>
                      <?php if ($r['status'] === 'selesai'): ?>
                        <span class="badge badge-success">Selesai</span>
                      <?php else: ?>
                        <span class="badge badge-warning">Periksa</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center text-muted py-3">
                      Belum ada rekam medis hari ini.
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

