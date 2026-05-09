<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Data Pasien</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('pasien') ?>">Pasien</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Pasien</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('pasien/update/'.$pasien['id_pasien']) ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_pasien" class="form-control"
                       value="<?= esc($pasien['nama_pasien']) ?>" required>
              </div>
              <div class="form-group">
                <label>Jenis Kelamin <span class="text-danger">*</span></label>
                <select name="jenis_kelamin" class="form-control" required>
                  <option value="L" <?= $pasien['jenis_kelamin']==='L' ? 'selected' : '' ?>>Laki-laki</option>
                  <option value="P" <?= $pasien['jenis_kelamin']==='P' ? 'selected' : '' ?>>Perempuan</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control"
                       value="<?= $pasien['tanggal_lahir'] ?? '' ?>">
              </div>
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" value="<?= esc($pasien['no_telp'] ?? '') ?>">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= esc($pasien['alamat'] ?? '') ?></textarea>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-warning"><i class="la la-save"></i> Update</button>
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

