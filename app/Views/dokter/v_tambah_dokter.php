<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Tambah Dokter</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dokter') ?>">Dokter</a></li>
      <li class="breadcrumb-item active">Tambah</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Tambah Dokter</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('dokter/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Nama Dokter <span class="text-danger">*</span></label>
                <input type="text" name="nama_dokter" class="form-control" placeholder="dr. Nama Lengkap" required>
              </div>
              <div class="form-group">
                <label>Spesialisasi <span class="text-danger">*</span></label>
                <select name="spesialisasi" class="form-control" required>
                  <option value="">-- Pilih Spesialisasi --</option>
                  <option value="Umum">Umum</option>
                  <option value="Anak">Anak</option>
                  <option value="Gigi">Gigi</option>
                  <option value="Kandungan">Kandungan</option>
                  <option value="Jantung">Jantung</option>
                  <option value="Kulit">Kulit</option>
                  <option value="Mata">Mata</option>
                  <option value="THT">THT</option>
                  <option value="Ortopedi">Ortopedi</option>
                  <option value="Syaraf">Syaraf</option>
                </select>
              </div>
              <div class="form-group">
                <label>No. Telepon</label>
                <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx">
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" placeholder="Alamat dokter..."></textarea>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan</button>
                <a href="<?= base_url('dokter') ?>" class="btn btn-secondary ml-1">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
