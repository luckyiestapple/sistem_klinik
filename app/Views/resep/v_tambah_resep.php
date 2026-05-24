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
            <div class="col-md-3">
              <strong>Pasien:</strong><br>
              <?= esc($rekam_medis['nama_pasien']) ?>
              <?php if ($is_bpjs): ?>
                <span class="badge badge-success ml-1"><i class="la la-check-circle"></i> BPJS Aktif</span>
              <?php else: ?>
                <span class="badge badge-secondary ml-1">Non-BPJS</span>
              <?php endif; ?>
            </div>
            <div class="col-md-3"><strong>Dokter:</strong><br><?= esc($rekam_medis['nama_dokter']) ?></div>
            <div class="col-md-3"><strong>Tgl Periksa:</strong><br><?= date('d/m/Y', strtotime($rekam_medis['tgl_periksa'])) ?></div>
            <div class="col-md-3"><strong>Keluhan:</strong><br><?= esc($rekam_medis['keluhan']) ?></div>
          </div>
        </div>
      </div>

      <?php if ($is_bpjs): ?>
      <div class="alert alert-success border-0 mb-2" style="background:linear-gradient(90deg,#1e7e34 0%,#28a745 100%);color:#fff;border-radius:8px;">
        <i class="la la-check-circle" style="font-size:1.3rem;"></i>
        <strong> Pasien BPJS &mdash; Biaya Obat Ditanggung BPJS.</strong>
        Subtotal resep ini akan otomatis <strong>Rp 0 (Gratis)</strong>.
      </div>
      <?php endif; ?>

      <!-- Form Resep -->
      <div class="card">
        <div class="card-header"><h4 class="card-title">
          <?php if ($is_dokter ?? false): ?>
            <i class="la la-pills"></i> Form Resep Obat (Dokter)
          <?php else: ?>
            <i class="la la-pills"></i> Form Resep Obat (Apoteker / Admin)
          <?php endif; ?>
        </h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('resep/simpan') ?>" method="POST" id="formResep">
              <?= csrf_field() ?>
              <input type="hidden" name="id_rekam_medis" value="<?= $rekam_medis['id_rekam_medis'] ?>">

              <!-- Tabel Detail Obat -->
              <div class="table-responsive mb-2">
                <table class="table table-bordered table-striped" id="tabelObat">
                  <thead class="bg-light">
                    <tr class="text-center">
                      <th>Obat</th>
                      <th width="100">Jumlah</th>
                      <th width="200">Dosis / Aturan Pakai</th>
                      <?php if (!($is_dokter ?? false)): ?>
                      <th width="150">Harga Satuan (Rp)</th>
                      <th width="150">Subtotal</th>
                      <?php endif; ?>
                      <th width="60">Aksi</th>
                    </tr>
                  </thead>
                  <tbody id="bodyObat">
                    <tr class="row-obat">
                      <td>
                        <select name="id_obat[]" class="form-control sel-obat" required>
                          <option value="">-- Pilih Obat --</option>
                          <?php foreach ($obat as $o): ?>
                          <option value="<?= $o['kode_obat'] ?>" data-harga="<?= $o['harga'] ?>">
                            <?= esc($o['nama_obat']) ?> (Stok: <?= $o['stok'] ?>)
                          </option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                      <td><input type="number" name="jumlah[]" class="form-control text-center inp-jumlah" value="1" min="1" required></td>
                      <td><input type="text" name="dosis[]" class="form-control" placeholder="Contoh: 3 x 1 tablet"></td>
                      <?php if (!($is_dokter ?? false)): ?>
                      <td><input type="number" name="harga_satuan[]" class="form-control text-right inp-harga" value="0" step="0.01" required></td>
                      <td class="text-right align-middle font-weight-bold td-subtotal-text">Rp 0</td>
                      <?php else: ?>
                      <input type="hidden" name="harga_satuan[]" value="0" class="inp-harga">
                      <?php endif; ?>
                      <td class="text-center align-middle">
                        <button type="button" class="btn btn-sm btn-danger btn-hapus-baris" title="Hapus"><i class="la la-trash"></i></button>
                      </td>
                    </tr>
                  </tbody>
                  <?php if (!($is_dokter ?? false)): ?>
                  <tfoot>
                    <tr>
                      <td colspan="4" class="text-right font-weight-bold h5">TOTAL KESELURUHAN:</td>
                      <?php if ($is_bpjs): ?>
                      <td class="text-right font-weight-bold text-success h5" id="totalHargaText">
                        <span class="badge badge-success" style="font-size:1rem;">Rp 0 <small>(Ditanggung BPJS)</small></span>
                      </td>
                      <?php else: ?>
                      <td class="text-right font-weight-bold text-primary h5" id="totalHargaText">Rp 0</td>
                      <?php endif; ?>
                      <td></td>
                    </tr>
                  </tfoot>
                  <?php endif; ?>
                </table>
              </div>

              <button type="button" class="btn btn-outline-primary btn-sm mb-3 mr-1" id="btnTambahBaris">
                <i class="la la-plus"></i> Tambah Obat
              </button>

              <div class="form-group mt-2 d-flex flex-wrap" style="gap:8px;">
                <button type="submit" class="btn btn-success"><i class="la la-save"></i> Simpan Resep</button>
                <a href="<?= base_url('rekam_medis') ?>" class="btn btn-secondary"><i class="la la-arrow-left"></i> Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
$(document).ready(function() {
    var isBpjs   = <?= ($is_bpjs ?? false) ? 'true' : 'false' ?>;
    var isDokter = <?= ($is_dokter ?? false) ? 'true' : 'false' ?>;

    function formatRp(n) {
        return 'Rp ' + parseFloat(n).toLocaleString('id-ID', {minimumFractionDigits: 0});
    }

    function hit_subtotal(row) {
        if (isDokter) return; // Dokter: tidak hitung subtotal di UI
        if (isBpjs) {
            row.find('.td-subtotal-text').html('<span class="text-success font-weight-bold">Rp 0</span>');
            hitung_total();
            return;
        }
        const jml = parseFloat(row.find('.inp-jumlah').val()) || 0;
        const hrg = parseFloat(row.find('.inp-harga').val())  || 0;
        const sub = jml * hrg;
        row.find('.td-subtotal-text').text(formatRp(sub));
        hitung_total();
    }

    function hitung_total() {
        if (isDokter) return;
        if (isBpjs) {
            $('#totalHargaText').html('<span class="badge badge-success" style="font-size:1rem;">Rp 0 <small>(Ditanggung BPJS)</small></span>');
            return;
        }
        let total = 0;
        $('.row-obat').each(function() {
            const jml = parseFloat($(this).find('.inp-jumlah').val()) || 0;
            const hrg = parseFloat($(this).find('.inp-harga').val())  || 0;
            total += (jml * hrg);
        });
        $('#totalHargaText').text(formatRp(total));
    }

    // Auto-fill harga saat pilih obat (khusus admin)
    $(document).on('change', '.sel-obat', function() {
        const opt = $(this).find(':selected');
        const hrg = opt.data('harga') || 0;
        const row = $(this).closest('tr');
        if (!isDokter) {
            row.find('.inp-harga').val(hrg);
        }
        hit_subtotal(row);
    });

    $(document).on('input', '.inp-jumlah, .inp-harga', function() {
        hit_subtotal($(this).closest('tr'));
    });

    // Tambah Baris
    $('#btnTambahBaris').click(function() {
        const tbody = document.getElementById('bodyObat');
        const firstRow = $('.row-obat').first();
        const newRow  = firstRow.clone();

        newRow.find('select').val('');
        newRow.find('.inp-jumlah').val(1);
        newRow.find('.inp-harga').val(0);
        if (!isDokter) newRow.find('.td-subtotal-text').text('Rp 0');
        if (isBpjs && !isDokter) newRow.find('.td-subtotal-text').html('<span class="text-success font-weight-bold">Rp 0</span>');

        $(tbody).append(newRow);
    });

    // Hapus Baris
    $(document).on('click', '.btn-hapus-baris', function() {
        if ($('.row-obat').length > 1) {
            $(this).closest('tr').remove();
            hitung_total();
        } else {
            alert('Minimal harus ada 1 obat dalam resep.');
        }
    });

    hitung_total();
    if (isBpjs && !isDokter) {
        $('.row-obat').each(function() { hit_subtotal($(this)); });
    }
});
</script>
<?= $this->endSection() ?>
