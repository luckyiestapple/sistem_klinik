<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Dokter</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dokter') ?>">Dokter</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Dokter</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('dokter/update/'.$dokter['id_dokter']) ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-group">
                <label>Nama Dokter <span class="text-danger">*</span></label>
                <input type="text" name="nama_dokter" class="form-control"
                       value="<?= esc($dokter['nama']) ?>" required>
              </div>
              <div class="form-group">
                <label>Spesialisasi <span class="text-danger">*</span></label>
                <select name="spesialisasi" class="form-control" required>
                  <?php $specs = ['Umum','Anak','Gigi','Kandungan','Jantung','Kulit','Mata','THT','Ortopedi','Syaraf']; ?>
                  <?php foreach ($specs as $s): ?>
                  <option value="<?= $s ?>" <?= $dokter['spesialisasi'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3"><?= esc($dokter['alamat'] ?? '') ?></textarea>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-warning"><i class="la la-save"></i> Update</button>
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

