<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>
<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Obat</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('obat') ?>">Obat</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </div>
</div>
<div class="content-body">
  <div class="row">
    <div class="col-md-7 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Obat</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('obat/update/'.$obat['id_obat']) ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Kode Obat <span class="text-danger">*</span></label>
                <input type="text" name="kode_obat" class="form-control" value="<?= esc($obat['kode_obat']) ?>" required>
              </div>
              <div class="form-group">
                <label>Nama Obat <span class="text-danger">*</span></label>
                <input type="text" name="nama_obat" class="form-control" value="<?= esc($obat['nama_obat']) ?>" required>
              </div>
              <div class="form-group">
                <label>Kategori</label>
                <?php $kats = ['Analgesik','Antibiotik','Antasid','Antihistamin','Vitamin','Antihipertensi','Antidiabetik','Lainnya']; ?>
                <select name="kategori" class="form-control">
                  <option value="">-- Pilih --</option>
                  <?php foreach ($kats as $k): ?>
                  <option <?= ($obat['kategori'] ?? '') === $k ? 'selected' : '' ?>><?= $k ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Stok <span class="text-danger">*</span></label>
                  <input type="number" name="stok" class="form-control" value="<?= $obat['stok'] ?>" min="0" required>
                </div>
                <div class="form-group col-md-6">
                  <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                  <input type="number" name="harga" class="form-control" value="<?= $obat['harga'] ?>" min="0" step="0.01" required>
                </div>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-warning"><i class="la la-save"></i> Update</button>
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

