<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>
<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Tambah Obat</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('obat') ?>">Obat</a></li>
      <li class="breadcrumb-item active">Tambah</li>
    </ol>
  </div>
</div>
<div class="content-body">
  <div class="row">
    <div class="col-md-7 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Tambah Obat</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('obat/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Kode Obat <span class="text-danger">*</span></label>
                <input type="text" name="kode_obat" class="form-control" placeholder="OBT-006" required>
              </div>
              <div class="form-group">
                <label>Nama Obat <span class="text-danger">*</span></label>
                <input type="text" name="nama_obat" class="form-control" placeholder="Nama obat" required>
              </div>
              <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control">
                  <option value="">-- Pilih Kategori --</option>
                  <option>Analgesik</option><option>Antibiotik</option>
                  <option>Antasid</option><option>Antihistamin</option>
                  <option>Vitamin</option><option>Antihipertensi</option>
                  <option>Antidiabetik</option><option>Lainnya</option>
                </select>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Stok <span class="text-danger">*</span></label>
                  <input type="number" name="stok" class="form-control" value="0" min="0" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                  <input type="number" name="harga" class="form-control" value="0" min="0" step="0.01" required>
                </div>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan</button>
                <a href="<?= base_url('obat') ?>" class="btn btn-secondary ml-1">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
