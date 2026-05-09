<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Daftar Resep</h3>
    <ol class="breadcrumb"><li class="breadcrumb-item">Klinik</li><li class="breadcrumb-item active">Resep</li></ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Manajemen Resep</h4>
          <div class="heading-elements">
            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-outline-primary btn-sm">
              <i class="la la-stethoscope"></i> Ke Rekam Medis
            </a>
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
                    <th>Dokter</th>
                    <th>Tgl Resep</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($resep)): $no = 1; ?>
                    <?php foreach ($resep as $r): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><strong>RSP-<?= str_pad($r['id_resep'], 4, '0', STR_PAD_LEFT) ?></strong></td>
                      <td><?= esc($r['nama_pasien']) ?></td>
                      <td><?= esc($r['nama_dokter']) ?></td>
                      <td><?= date('d/m/Y H:i', strtotime($r['tanggal_resep'])) ?></td>
                      <td>Rp <?= number_format($r['total_harga'], 0, ',', '.') ?></td>
                      <td>
                        <?php
                          $badge = ['menunggu' => 'warning', 'diproses' => 'info', 'selesai' => 'success'];
                          $label = ['menunggu' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai'];
                        ?>
                        <span class="badge badge-<?= $badge[$r['status']] ?? 'secondary' ?>">
                          <?= $label[$r['status']] ?? $r['status'] ?>
                        </span>
                      </td>
                      <td>
                        <a href="<?= base_url('resep/detail/'.$r['id_resep']) ?>"
                           class="btn btn-sm btn-outline-info" title="Detail"><i class="la la-eye"></i></a>
                        <?php if ($r['status'] !== 'selesai'): ?>
                        <button class="btn btn-sm btn-outline-success"
                                onclick="updateStatus(<?= $r['id_resep'] ?>, '<?= $r['status'] ?>')"
                                title="Update Status"><i class="la la-check"></i></button>
                        <?php endif; ?>
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

<!-- Modal Update Status -->
<div class="modal fade" id="modalStatus" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="formStatus">
      <?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header"><h5 class="modal-title">Update Status Resep</h5></div>
        <div class="modal-body">
          <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control" id="selectStatus">
              <option value="menunggu">Menunggu</option>
              <option value="diproses">Diproses</option>
              <option value="selesai">Selesai</option>
            </select>
          </div>
          <div class="form-group">
            <label>Catatan Apoteker</label>
            <textarea name="catatan" class="form-control" rows="3" placeholder="Opsional..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function updateStatus(id, currentStatus) {
  document.getElementById('formStatus').action = '<?= base_url('resep/update_status/') ?>' + id;
  document.getElementById('selectStatus').value = currentStatus;
  $('#modalStatus').modal('show');
}
</script>
<?= $this->endSection() ?>

