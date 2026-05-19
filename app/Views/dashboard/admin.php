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

</div>
<?= $this->endSection() ?>
