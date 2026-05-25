<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
@media print {
  .no-print, .sidebar, .header-navbar, .content-header, nav, .breadcrumb,
  .btn, form, .heading-elements, .card-header .heading-elements { display: none !important; }
  .card { border: none !important; box-shadow: none !important; }
  .card-header { background: none !important; color: #000 !important; }
  body { font-size: 12px; }
  .print-header { display: block !important; }
  
  /* Make status badges solid black on print */
  .badge, .badge-success, .badge-warning, .badge-danger {
    background: none !important;
    color: #000 !important;
    font-weight: bold !important;
    border: none !important;
    padding: 0 !important;
  }
}
.print-header { display: none; }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>

<div class="content-header row no-print">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Detail Resep Obat</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('resep') ?>">Resep</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </div>
</div>

<!-- Print Header (hanya muncul saat print) -->
<div class="print-header text-center mb-3">
  <h3 class="font-weight-bold">KLINIK SEHAT</h3>
  <p class="mb-0">Jl. Kesehatan No. 1 | Telp: (021) 000-0000</p>
  <hr>
  <h5>STRUK RESEP OBAT</h5>
  <p>No. Resep: RSP-<?= str_pad($resep['id_resep'], 4, '0', STR_PAD_LEFT) ?> | Tanggal: <?= date('d F Y', strtotime($resep['tgl_resep'])) ?></p>
</div>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show no-print" role="alert">
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
<?php endif; ?>

<div class="content-body">
  <div class="row">
    <div class="col-md-10 offset-md-1 col-12">
      
      <!-- Card Detail Resep -->
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
          <h4 class="card-title">Resep No. <strong>RSP-<?= str_pad($resep['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></h4>
          <div class="heading-elements no-print d-flex flex-wrap" style="gap:8px;">
            <?php if (!($is_dokter ?? false)): ?>
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm font-weight-bold">
              <i class="la la-print"></i> Cetak Struk
            </button>
            <?php endif; ?>
            <a href="<?= base_url('resep') ?>" class="btn btn-secondary btn-sm font-weight-bold">
              <i class="la la-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            
            <div class="row mb-3">
              <div class="col-md-6 col-12">
                <h5 class="text-info border-bottom pb-1"><i class="la la-user"></i> Informasi Pasien</h5>
                <table class="table table-sm table-borderless">
                  <tr>
                    <th width="140">Nama Pasien</th>
                    <td>: <strong><?= esc($resep['nama_pasien']) ?></strong>
                      <?php if ($is_bpjs): ?>
                        <span class="badge badge-success ml-1"><i class="la la-check-circle"></i> BPJS Aktif</span>
                      <?php else: ?>
                        <span class="badge badge-secondary ml-1">Non-BPJS</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Gender / Umur</th>
                    <td>: 
                      <?= $resep['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?> / 
                      <?php 
                        if (!empty($resep['tgl_lahir'])) {
                            $birthDate = new \DateTime($resep['tgl_lahir']);
                            $today = new \DateTime();
                            echo $today->diff($birthDate)->y . ' Tahun';
                        } else { echo '-'; }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>No. Telepon</th>
                    <td>: <?= esc($resep['no_telp'] ?? '-') ?></td>
                  </tr>
                  <?php if ($is_bpjs && !empty($resep['no_bpjs'])): ?>
                  <tr>
                    <th>No. BPJS</th>
                    <td>: <span class="text-success font-weight-bold"><?= esc($resep['no_bpjs']) ?></span></td>
                  </tr>
                  <?php endif; ?>
                </table>
              </div>
              <div class="col-md-6 col-12">
                <h5 class="text-info border-bottom pb-1"><i class="la la-clipboard"></i> Informasi Resep</h5>
                <table class="table table-sm table-borderless">
                  <tr>
                    <th width="140">Dokter Pembuat</th>
                    <td>: <strong><?= esc($resep['nama_dokter']) ?></strong></td>
                  </tr>
                  <tr>
                    <th>Poli / Spesialisasi</th>
                    <td>: <span class="badge badge-info">Poli <?= esc($resep['spesialisasi']) ?></span></td>
                  </tr>
                  <tr>
                    <th>Tanggal Resep</th>
                    <td>: <?= date('d F Y', strtotime($resep['tgl_resep'])) ?></td>
                  </tr>
                  <tr>
                    <th>Status Resep</th>
                    <td>: 
                      <?php 
                      $status = $resep['status'] ?? 'menunggu';
                      if ($status === 'selesai'): ?>
                        <span class="badge badge-success font-medium-1">Selesai / Diambil</span>
                      <?php elseif ($status === 'diproses'): ?>
                        <span class="badge badge-warning text-white font-medium-1">Sedang Diproses</span>
                      <?php else: ?>
                        <span class="badge badge-danger font-medium-1">Menunggu Apoteker</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                </table>
              </div>
            </div>

            <?php if (session()->get('id_level') == 1): ?>
            <!-- Panel Update Status Resep untuk Apoteker/Admin -->
            <div class="bg-light p-3 rounded mb-4 border border-info no-print">
              <h5 class="text-dark font-weight-bold mb-2"><i class="la la-cog"></i> Proses Resep (Menu Apoteker)</h5>
              <form action="<?= base_url('resep/update_status/'.$resep['id_resep']) ?>" method="POST" class="form-inline">
                <?= csrf_field() ?>
                <label class="mr-2 font-weight-bold" for="status">Update Status:</label>
                <select name="status" class="form-control mr-3" required>
                  <option value="menunggu" <?= $status === 'menunggu' ? 'selected' : '' ?>>Menunggu</option>
                  <option value="diproses" <?= $status === 'diproses' ? 'selected' : '' ?>>Diproses</option>
                  <option value="selesai"  <?= $status === 'selesai'  ? 'selected' : '' ?>>Selesai / Diambil</option>
                </select>
                <button type="submit" class="btn btn-info text-white font-weight-bold">
                  <i class="la la-save"></i> Perbarui Status
                </button>
              </form>
            </div>
            <?php endif; ?>

            <?php if ($is_bpjs): ?>
            <div class="alert border-0 mb-3" style="background:linear-gradient(90deg,#1e7e34 0%,#28a745 100%);color:#fff;border-radius:8px;">
              <i class="la la-check-circle" style="font-size:1.3rem;"></i>
              <strong> Pasien BPJS &mdash; Biaya Ditanggung BPJS.</strong>
              Total tagihan: <strong>Rp 0 (Gratis)</strong>.
            </div>
            <?php endif; ?>

            <!-- Tabel Detail Obat -->
            <h5 class="text-info border-bottom pb-1 mb-2"><i class="la la-medkit"></i> Rincian Obat</h5>
            <div class="table-responsive">
              <table class="table table-bordered mb-0">
                <thead class="thead-light">
                  <tr class="text-center">
                    <th width="50">#</th>
                    <th>Nama Obat</th>
                    <th>Aturan Pakai / Dosis</th>
                    <th width="100">Jumlah</th>
                    <?php if (!($is_dokter ?? false)): ?>
                    <th class="text-right" width="160">Harga Satuan</th>
                    <th class="text-right" width="160">Subtotal</th>
                    <?php endif; ?>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($detail as $d): ?>
                  <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><strong><?= esc($d['nama_obat']) ?></strong></td>
                    <td><?= esc($d['dosis'] ?? '-') ?></td>
                    <td class="text-center"><?= $d['jumlah'] ?></td>
                    <?php if (!($is_dokter ?? false)): ?>
                    <td class="text-right">Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                    <td class="text-right font-weight-bold">
                      <?php if ($is_bpjs): ?>
                        <span class="text-success">Rp 0</span>
                      <?php else: ?>
                        Rp <?= number_format($d['subtotal'], 0, ',', '.') ?>
                      <?php endif; ?>
                    </td>
                    <?php endif; ?>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
                <?php if (!($is_dokter ?? false)): ?>
                <tfoot>
                  <tr>
                    <td colspan="5" class="text-right font-weight-bold h5">Total Biaya Resep:</td>
                    <?php if ($is_bpjs): ?>
                    <td class="text-right h4">
                      <span class="badge badge-success" style="font-size:1.1rem;padding:.5rem .9rem;">
                        <i class="la la-check-circle"></i> Rp 0 &mdash; Gratis (BPJS)
                      </span>
                    </td>
                    <?php else: ?>
                    <td class="text-right font-weight-bold text-success h4">Rp <?= number_format($resep['total_harga'], 0, ',', '.') ?></td>
                    <?php endif; ?>
                  </tr>
                </tfoot>
                <?php endif; ?>
              </table>
            </div>

          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>

<?= $this->endSection() ?>
