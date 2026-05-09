<?= $this->extend('templates/template') ?>

<?= $this->section('konten') ?>
<div class="content-header row mb-2">
  <div class="col-12">
    <h2 class="content-header-title">Dashboard Administrator</h2>
  </div>
</div>
<div class="content-body">
  <!-- Welcome Banner -->
  <div class="card bg-info text-white box-shadow-2">
      <div class="card-body">
          <h4 class="text-white mt-0">Halo, Selamat Datang <strong><?= session()->get('username'); ?></strong>!</h4>
          <p class="mb-0">Ini adalah halaman dashboard panel sistem informasi klinik. Di sini Anda bisa mengelola seluruh data dari mulai pendaftaran pasien hingga pengeluaran resep serta obat.</p>
      </div>
  </div>
  <!-- Hospital Info cards -->
  <div class="row">
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
                <h3 class="text-bold-600">12</h3>
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
                <i class="la la-users font-large-2 warning"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Pasien Terdaftar</h5>
                <h3 class="text-bold-600">345</h3>
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
                <i class="la la-calendar-check-o font-large-2 info"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Kunjungan Hari Ini</h5>
                <h3 class="text-bold-600">24</h3>
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
                <i class="la la-bed font-large-2 danger"></i>
              </div>
              <div class="media-body text-right">
                <h5 class="text-muted text-bold-500">Antrian Rawat</h5>
                <h3 class="text-bold-600">4</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Hospital Info cards Ends -->
</div>
<?= $this->endSection() ?>
