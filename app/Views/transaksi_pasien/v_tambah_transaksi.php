<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Transaksi Baru (Penjualan Obat)</h3>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>

  <form action="<?= base_url('transaksipasien/simpan') ?>" method="POST">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Data Pasien</h4>
            <div class="form-group">
                <label>Nama Pasien</label>
                <input type="text" name="nama_pasien" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Tanggal Transaksi</label>
                <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="is_bpjs" id="is_bpjs" onchange="hitungTotalSemua()">
                    <label class="custom-control-label" for="is_bpjs">Pasien BPJS (Gratis Obat)</label>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Daftar Obat</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Obat</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th width="100">Jumlah</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($obat as $o): ?>
                  <tr>
                    <td><?= $o['nama_obat'] ?></td>
                    <td><?= $o['stok'] ?></td>
                    <td>Rp <span class="harga-satuan"><?= $o['harga'] ?></span></td>
                    <td>
                        <input type="number" name="obat[<?= $o['kode_obat'] ?>]" class="form-control jumlah-obat" min="0" max="<?= $o['stok'] ?>" value="0" data-harga="<?= $o['harga'] ?>" oninput="hitungTotalSemua()">
                    </td>
                    <td>Rp <span class="subtotal-item">0</span></td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                      <th colspan="4" class="text-right">Total Keseluruhan</th>
                      <th><h3 id="total_semua" class="text-danger">Rp 0</h3></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <div class="text-right mt-2">
                <button type="submit" class="btn btn-primary btn-lg">Simpan Transaksi</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<script>
function hitungTotalSemua() {
    let is_bpjs = document.getElementById('is_bpjs').checked;
    let total = 0;
    
    document.querySelectorAll('.jumlah-obat').forEach(function(input) {
        let jumlah = parseInt(input.value) || 0;
        let harga = parseFloat(input.getAttribute('data-harga')) || 0;
        let subtotal = jumlah * harga;
        
        if (is_bpjs) {
            subtotal = 0;
        }
        
        input.parentElement.nextElementSibling.querySelector('.subtotal-item').innerText = formatRupiah(subtotal);
        total += subtotal;
    });
    
    document.getElementById('total_semua').innerText = 'Rp ' + formatRupiah(total);
}

function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
}
</script>

<?= $this->endSection() ?>
