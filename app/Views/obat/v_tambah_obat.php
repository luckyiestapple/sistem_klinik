<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

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
    <div class="col-md-8 offset-md-2">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Tambah Obat Baru</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('obat/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Kode Obat <span class="text-danger">*</span></label>
                    <input type="text" name="kode_obat" class="form-control" placeholder="Contoh: OBT001" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="nama_obat" class="form-control" placeholder="Nama obat" required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Kandungan Obat (Komposisi)</label>
                    <input type="text" name="kandungan" class="form-control" placeholder="Contoh: Paracetamol 500mg">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Stok Awal <span class="text-danger">*</span></label>
                    <input type="number" name="stok" class="form-control" placeholder="Jumlah stok" min="0" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Harga Satuan <span class="text-danger">*</span></label>
                    <input type="number" name="harga" class="form-control" placeholder="Harga dalam Rupiah" min="0" required>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Satuan</label>
                    <select name="satuan" class="form-control">
                      <option value="tablet">Tablet</option>
                      <option value="kapsul">Kapsul</option>
                      <option value="ml">Ml</option>
                      <option value="botol">Botol</option>
                      <option value="box">Box</option>
                      <option value="tube">Tube</option>
                      <option value="sachet">Sachet</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Stok Minimum (Alert)</label>
                    <input type="number" name="stok_minimum" class="form-control" value="10" min="0">
                  </div>
                </div>
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Tanggal Kadaluarsa</label>
                    <input type="date" name="tgl_expired" class="form-control">
                  </div>
                </div>
              </div>

              <div class="form-group mt-2 border-top pt-3">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan Obat</button>
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
