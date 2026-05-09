<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Buat Resep</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('resep') ?>">Resep</a></li>
      <li class="breadcrumb-item active">Buat Resep</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-12">

      <!-- Info Rekam Medis -->
      <div class="card border-info mb-2">
        <div class="card-header bg-info white"><h5 class="mb-0"><i class="la la-stethoscope"></i> Data Rekam Medis</h5></div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-3"><strong>Pasien:</strong><br><?= esc($rekam_medis['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Dokter:</strong><br><?= esc($rekam_medis['nama_dokter']) ?></div>
            <div class="col-md-3"><strong>Tgl Periksa:</strong><br><?= date('d/m/Y H:i', strtotime($rekam_medis['tanggal_periksa'])) ?></div>
            <div class="col-md-3"><strong>Keluhan:</strong><br><?= esc($rekam_medis['keluhan']) ?></div>
          </div>
        </div>
      </div>

      <!-- Form Resep -->
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Resep Obat</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('resep/simpan') ?>" method="POST" id="formResep">
              <?= csrf_field() ?>
              <input type="hidden" name="id_rekam_medis" value="<?= $rekam_medis['id_rekam_medis'] ?>">

              <!-- Tabel Detail Obat -->
              <div class="table-responsive mb-2">
                <table class="table table-bordered" id="tabelObat">
                  <thead class="thead-light">
                    <tr>
                      <th>Obat</th>
                      <th width="90">Jumlah</th>
                      <th width="150">Dosis</th>
                      <th width="130">Harga Satuan</th>
                      <th width="130">Subtotal</th>
                      <th width="50">#</th>
                    </tr>
                  </thead>
                  <tbody id="bodyObat">
                    <tr class="row-obat">
                      <td>
                        <select name="id_obat[]" class="form-control sel-obat" required>
                          <option value="">-- Pilih Obat --</option>
                          <?php foreach ($obat as $o): ?>
                          <option value="<?= $o['id_obat'] ?>" data-harga="<?= $o['harga'] ?>">
                            <?= esc($o['nama_obat']) ?> (Stok: <?= $o['stok'] ?>)
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                      <td><input type="number" name="jumlah[]" class="form-control inp-jumlah" value="1" min="1" required></td>
                      <td><input type="text" name="dosis[]" class="form-control" placeholder="3x1 tablet"></td>
                      <td><input type="number" name="harga_satuan[]" class="form-control inp-harga" value="0" step="0.01" required></td>
                      <td><input type="text" class="form-control td-subtotal" value="0" readonly></td>
                      <td class="text-center">
                        <button type="button" class="btn btn-sm btn-danger btn-hapus-baris"><i class="la la-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="4" class="text-right font-weight-bold">Total:</td>
                      <td><input type="text" id="totalHarga" class="form-control font-weight-bold" value="0" readonly></td>
                      <td></td>
                    </tr>
                  </tfoot>
                </table>
              </div>

              <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="btnTambahBaris">
                <i class="la la-plus"></i> Tambah Obat
              </button>

              <div class="form-group mt-2">
                <button type="submit" class="btn btn-success"><i class="la la-save"></i> Simpan Resep</button>
                <a href="<?= base_url('rekam_medis') ?>" class="btn btn-secondary ml-1">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const obatData = <?= json_encode($obat) ?>;

function formatRp(n) {
  return 'Rp ' + parseFloat(n).toLocaleString('id-ID', {minimumFractionDigits: 0});
}

function hitungSubtotal(row) {
  const jumlah = parseFloat(row.querySelector('.inp-jumlah').value) || 0;
  const harga  = parseFloat(row.querySelector('.inp-harga').value)  || 0;
  const sub    = jumlah * harga;
  row.querySelector('.td-subtotal').value = formatRp(sub);
  return sub;
}

function hitungTotal() {
  let total = 0;
  document.querySelectorAll('.row-obat').forEach(row => { total += hitungSubtotal(row); });
  document.getElementById('totalHarga').value = formatRp(total);
}

function bindRowEvents(row) {
  row.querySelector('.sel-obat').addEventListener('change', function() {
    const opt = this.options[this.selectedIndex];
    const harga = opt.dataset.harga || 0;
    row.querySelector('.inp-harga').value = harga;
    hitungTotal();
  });
  row.querySelector('.inp-jumlah').addEventListener('input', hitungTotal);
  row.querySelector('.inp-harga').addEventListener('input', hitungTotal);
  row.querySelector('.btn-hapus-baris').addEventListener('click', function() {
    if (document.querySelectorAll('.row-obat').length > 1) {
      row.remove(); hitungTotal();
    }
  });
}

// Bind baris pertama
bindRowEvents(document.querySelector('.row-obat'));

document.getElementById('btnTambahBaris').addEventListener('click', function() {
  const tbody = document.getElementById('bodyObat');
  const newRow = document.querySelector('.row-obat').cloneNode(true);
  newRow.querySelector('.sel-obat').value = '';
  newRow.querySelector('.inp-jumlah').value = 1;
  newRow.querySelector('.inp-harga').value = 0;
  newRow.querySelector('.td-subtotal').value = 0;
  tbody.appendChild(newRow);
  bindRowEvents(newRow);
});
</script>
<?= $this->endSection() ?>

