<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Daftarkan Pasien</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('pasien') ?>">Pasien</a></li>
      <li class="breadcrumb-item active">Daftarkan</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Pendaftaran Pasien</h4></div>
        <div class="card-content">
          <div class="card-body">
            <div class="alert alert-info font-small-3">
              <i class="la la-info-circle"></i>
              Pendaftaran pasien dilakukan oleh <strong>Admin/Petugas</strong>. Pasien tidak dapat mendaftar mandiri.
            </div>
            <form action="<?= base_url('pasien/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_pasien" class="form-control" placeholder="Nama lengkap pasien" required>
              </div>
              <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-control" required>
                  <option value="">-- Pilih --</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control">
              </div>
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat lengkap pasien..."></textarea>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Daftarkan</button>
                <a href="<?= base_url('pasien') ?>" class="btn btn-secondary ml-1">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

