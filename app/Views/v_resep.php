<?= $this->extend('templates/template') ?>
<?= $this->section('css') ?>
<style>
@media print {
  .no-print, .sidebar, .header-navbar, .content-header, nav, .breadcrumb,
  .btn, form, .heading-elements, .card-header .heading-elements, .main-menu { display: none !important; }
  .card { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 0 !important; }
  .card-header { background: none !important; color: #000 !important; border: none !important; }
  body { font-size: 12px; background-color: #fff !important; }
  .print-header { display: block !important; }
  .table-responsive { display: block !important; width: 100% !important; overflow-x: visible !important; }
  table th:last-child, table td:last-child { display: none !important; } /* Hide Action column */
  .app-content { margin-left: 0 !important; padding: 0 !important; }
  .content-wrapper { padding: 0 !important; }
  
  /* Hide rows that are not 'selesai' during print */
  .not-selesai { display: none !important; }
  
  /* Reset row numbering so they are sequential in print */
  table {
    counter-reset: rowNumber;
  }
  table tbody tr:not(.not-selesai) {
    counter-increment: rowNumber;
  }
  table tbody tr:not(.not-selesai) td:first-child {
    font-size: 0;
  }
  table tbody tr:not(.not-selesai) td:first-child::before {
    content: counter(rowNumber);
    font-size: 12px;
  }
  
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
    <h3 class="content-header-title">Daftar Resep</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item">Klinik</li>
      <li class="breadcrumb-item active">Resep</li>
    </ol>
  </div>
</div>

<!-- Print Header (hanya muncul saat print) -->
<div class="print-header text-center mb-3">
  <h3 class="font-weight-bold">KLINIK SEHAT</h3>
  <p class="mb-0">Jl. Kesehatan No. 1 | Telp: (021) 000-0000</p>
  <hr>
  <h4 class="font-weight-bold">LAPORAN TRANSAKSI & RESEP OBAT</h4>
  <p class="mb-0">
    Periode: 
    <?php
    $namaBulan = [1=>'Januari', 2=>'Februari', 3=>'Maret', 4=>'April', 5=>'Mei', 6=>'Juni', 7=>'Juli', 8=>'Agustus', 9=>'September', 10=>'Oktober', 11=>'November', 12=>'Desember'];
    $periode = [];
    if (!empty($filter_tanggal)) $periode[] = $filter_tanggal;
    if (!empty($filter_bulan)) $periode[] = $namaBulan[$filter_bulan] ?? $filter_bulan;
    if (!empty($filter_tahun)) $periode[] = $filter_tahun;
    echo !empty($periode) ? implode(' ', $periode) : 'Semua Waktu';
    ?>
  </p>
  <p class="mb-0">Tanggal Cetak: <?= date('d F Y') ?></p>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show no-print" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>

  <div class="row no-print mb-2">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form action="" method="GET" class="row">
                <div class="col-md-3">
                    <label>Tanggal</label>
                    <select name="tanggal" class="form-control">
                        <option value="">Semua Tanggal</option>
                        <?php for($i=1; $i<=31; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($filter_tanggal) && $filter_tanggal == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Bulan</label>
                    <select name="bulan" class="form-control">
                        <option value="">Semua Bulan</option>
                        <?php foreach($namaBulan as $k => $v): ?>
                            <option value="<?= $k ?>" <?= (isset($filter_bulan) && $filter_bulan == $k) ? 'selected' : '' ?>><?= $v ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Tahun</label>
                    <select name="tahun" class="form-control">
                        <option value="">Semua Tahun</option>
                        <?php for($i=date('Y')-2; $i<=date('Y')+1; $i++): ?>
                            <option value="<?= $i ?>" <?= (isset($filter_tahun) && $filter_tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100"><i class="la la-filter"></i> Filter</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
          <h4 class="card-title">Manajemen Resep & Pengeluaran Obat</h4>
          <div class="heading-elements d-flex" style="gap:10px; align-items: center;">
            <?php if (isset($total_pemasukan)): ?>
            <div class="badge badge-success font-weight-bold p-1 text-dark" style="font-size: 1rem; border: 1px solid #16d39a; background-color: #d1f7ea !important;">
              Total Pendapatan: Rp <?= number_format($total_pemasukan, 0, ',', '.') ?>
            </div>
            <?php endif; ?>
            <?php if (session()->get('id_level') == 1): // Admin only ?>
            <button onclick="window.print()" class="btn btn-outline-secondary font-weight-bold no-print">
              <i class="la la-print"></i> Cetak Laporan
            </button>
            <?php endif; ?>
            <?php if (session()->get('id_level') == 3): ?>
            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-primary btn-sm font-weight-bold no-print">
              <i class="la la-stethoscope"></i> Input Resep Baru (Dari Rekam Medis)
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover mb-0">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>No. Resep</th>
                    <th>Pasien</th>
                    <th>Dokter Pembuat</th>
                    <th>Tanggal Resep</th>
                    <th>Total Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($resep)): $no = 1; ?>
                    <?php foreach ($resep as $r): 
                      $status = $r['status'] ?? 'menunggu';
                    ?>
                    <tr class="<?= ($status !== 'selesai') ? 'not-selesai' : '' ?>">
                      <td><?= $no++ ?></td>
                      <td><strong>RSP-<?= str_pad($r['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                      <td>
                        <?= esc($r['nama_pasien']) ?>
                        <?php if (strtolower($r['status_bpjs'] ?? '') === 'aktif'): ?>
                          <span class="badge badge-success" style="font-size:.7rem;">BPJS</span>
                        <?php endif; ?>
                      </td>
                      <td><?= esc($r['nama_dokter']) ?></td>
                      <td><?= date('d/m/Y', strtotime($r['tgl_resep'])) ?></td>
                      <td>
                        <?php if (strtolower($r['status_bpjs'] ?? '') === 'aktif'): ?>
                          <span class="badge badge-success">Rp 0 &mdash; Gratis (BPJS)</span>
                        <?php else: ?>
                          Rp <?= number_format($r['total_harga'], 0, ',', '.') ?>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php 
                        $status = $r['status'] ?? 'menunggu';
                        if ($status === 'selesai'): 
                        ?>
                          <span class="badge badge-success" style="color: black !important; font-weight: bold;">Selesai / Diambil</span>
                        <?php elseif ($status === 'diproses'): ?>
                          <span class="badge badge-warning text-white">Sedang Diproses</span>
                        <?php else: ?>
                          <span class="badge badge-danger">Menunggu Apoteker</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="<?= base_url('resep/detail/'.$r['id_resep']) ?>"
                           class="btn btn-sm btn-info text-white mb-1" title="Lihat Detail & Proses">
                           <i class="la la-eye"></i> Detail / Proses
                        </a>
                        <br>
                        <a href="<?= base_url('export/invoicePdf/'.$r['id_resep']) ?>" target="_blank"
                           class="btn btn-sm btn-secondary text-white" title="Cetak Invoice PDF">
                           <i class="la la-file-pdf-o"></i> Cetak Invoice
                        </a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="8" class="text-center text-muted py-3">Belum ada data resep.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
