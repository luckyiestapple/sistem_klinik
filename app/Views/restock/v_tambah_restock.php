<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Tambah Restock Obat</h3>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <form action="<?= base_url('restock/simpan') ?>" method="POST">
            <div class="form-group">
                <label>Obat</label>
                <select name="kode_obat" class="form-control" required>
                    <option value="">-- Pilih Obat --</option>
                    <?php foreach($obat as $o): ?>
                        <option value="<?= $o['kode_obat'] ?>"><?= $o['nama_obat'] ?> (Stok: <?= $o['stok'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal Restock</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <label>Keterangan (Supplier/Toko)</label>
                <input type="text" name="keterangan" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Jumlah Beli</label>
                <input type="number" name="jumlah" id="jumlah" class="form-control" required oninput="hitungTotal()">
            </div>
            <div class="form-group">
                <label>Harga Beli per Unit (Rp)</label>
                <input type="number" name="harga_beli" id="harga_beli" class="form-control" required oninput="hitungTotal()">
            </div>
            <div class="form-group">
                <label>Total Biaya (Rp)</label>
                <input type="number" name="total_biaya" id="total_biaya" class="form-control" readonly>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Restock</button>
            <a href="<?= base_url('restock') ?>" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function hitungTotal() {
    let jumlah = document.getElementById('jumlah').value || 0;
    let harga = document.getElementById('harga_beli').value || 0;
    document.getElementById('total_biaya').value = jumlah * harga;
}
</script>

<?= $this->endSection() ?>
