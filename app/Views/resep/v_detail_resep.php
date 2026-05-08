<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>
<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Detail Resep</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('resep') ?>">Resep</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </div>
</div>
<div class="content-body">
  <div class="row">
    <div class="col-md-10 offset-md-1">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Resep No. <strong>RSP-<?= str_pad($resep['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></h4>
          <div class="heading-elements">
            <?php $badge=['menunggu'=>'warning','diproses'=>'info','selesai'=>'success']; ?>
            <?php $label=['menunggu'=>'Menunggu','diproses'=>'Diproses','selesai'=>'Selesai']; ?>
            <span class="badge badge-<?= $badge[$resep['status']] ?>"><?= $label[$resep['status']] ?></span>
            <a href="<?= base_url('resep') ?>" class="btn btn-secondary btn-sm ml-1">Kembali</a>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-3"><strong>Pasien</strong><br><?= esc($resep['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Dokter</strong><br><?= esc($resep['nama_dokter']) ?></div>
            <div class="col-md-3"><strong>Tgl Periksa</strong><br><?= date('d/m/Y H:i', strtotime($resep['tanggal_periksa'])) ?></div>
            <div class="col-md-3"><strong>Tgl Resep</strong><br><?= date('d/m/Y H:i', strtotime($resep['tanggal_resep'])) ?></div>
          </div>
          <div class="row mb-2">
            <div class="col-md-6"><strong>Keluhan:</strong><br><?= esc($resep['keluhan']) ?></div>
            <div class="col-md-6"><strong>Diagnosa:</strong><br><?= esc($resep['hasil_pemeriksaan'] ?? '-') ?></div>
          </div>
          <?php if ($resep['catatan']): ?>
          <div class="alert alert-info"><strong>Catatan Apoteker:</strong> <?= esc($resep['catatan']) ?></div>
          <?php endif; ?>
        </div>
      </div>
      <div class="card">
        <div class="card-header"><h4 class="card-title">Daftar Obat</h4></div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered mb-0">
              <thead class="thead-light">
                <tr>
                  <th>#</th><th>Nama Obat</th><th>Dosis</th>
                  <th class="text-center">Jumlah</th>
                  <th class="text-right">Harga Satuan</th>
                  <th class="text-right">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                <?php $no=1; foreach ($detail as $d): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= esc($d['nama_obat']) ?></td>
                  <td><?= esc($d['dosis'] ?? '-') ?></td>
                  <td class="text-center"><?= $d['jumlah'] ?></td>
                  <td class="text-right">Rp <?= number_format($d['harga_satuan'],0,',','.') ?></td>
                  <td class="text-right">Rp <?= number_format($d['subtotal'],0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" class="text-right font-weight-bold">Total:</td>
                  <td class="text-right font-weight-bold text-success">Rp <?= number_format($resep['total_harga'],0,',','.') ?></td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
