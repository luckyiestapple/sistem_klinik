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
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Obat: <?= esc($obat['nama_obat']) ?></h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('obat/update/'.$obat['kode_obat']) ?>" method="POST">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Kode Obat <span class="text-danger">*</span></label>
                    <input type="text" name="kode_obat" class="form-control" value="<?= esc($obat['kode_obat']) ?>" readonly>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="nama_obat" class="form-control" value="<?= esc($obat['nama_obat']) ?>" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Kandungan Obat (Komposisi)</label>
                    <input type="text" name="kandungan" class="form-control" value="<?= esc($obat['kandungan'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Stok <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control" value="<?= $obat['stok'] ?>" min="0" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Harga Satuan (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga" class="form-control" value="<?= $obat['harga'] ?>" min="0" required>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" class="form-control">
                      <?php $units = ['tablet', 'kapsul', 'ml', 'botol', 'box', 'tube', 'sachet']; ?>
                      <?php foreach ($units as $u): ?>
                        <option value="<?= $u ?>" <?= ($obat['satuan'] ?? 'tablet') === $u ? 'selected' : '' ?>><?= ucfirst($u) ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Stok Minimum (Alert)</label>
                    <input type="number" name="stok_minimum" class="form-control" value="<?= $obat['stok_minimum'] ?? 10 ?>" min="0">
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="tgl_expired" class="form-control" value="<?= $obat['tgl_expired'] ?? '' ?>">
                  </div>
                </div>
              </div>

              <div class="form-group mt-2 border-top pt-3">
                <button type="submit" class="btn btn-warning text-white"><i class="la la-save"></i> Perbarui Obat</button>
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
