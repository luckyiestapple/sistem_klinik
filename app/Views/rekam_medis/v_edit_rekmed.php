<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('rekam_medis') ?>">Rekam Medis</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-9 offset-md-1">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Rekam Medis</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('rekam_medis/update/'.$rekam_medis['id_rekam_medis']) ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Pasien <span class="text-danger">*</span></label>
                  <select name="id_pasien" class="form-control" required>
                    <?php foreach ($pasien as $p): ?>
                    <option value="<?= $p['id_pasien'] ?>"
                      <?= $rekam_medis['id_pasien'] == $p['id_pasien'] ? 'selected' : '' ?>>
                      <?= esc($p['nama']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Dokter Pemeriksa <span class="text-danger">*</span></label>
                  <select name="id_dokter" class="form-control" required>
                    <?php foreach ($dokter as $d): ?>
                    <option value="<?= $d['id_dokter'] ?>"
                      <?= $rekam_medis['id_dokter'] == $d['id_dokter'] ? 'selected' : '' ?>>
                      <?= esc($d['nama']) ?> — <?= esc($d['spesialisasi']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Tanggal & Jam Periksa</label>
                <input type="datetime-local" name="tanggal_periksa" class="form-control"
                       value="<?= date('Y-m-d\TH:i', strtotime($rekam_medis['tgl_periksa'])) ?>">
              </div>
              <div class="form-group">
                <label>Keluhan / Gejala <span class="text-danger">*</span></label>
                <textarea name="keluhan" class="form-control" rows="3" required><?= esc($rekam_medis['keluhan']) ?></textarea>
              </div>
              <div class="form-group">
                <label>Hasil Pemeriksaan / Diagnosa</label>
                <textarea name="hasil_pemeriksaan" class="form-control" rows="4"><?= esc($rekam_medis['diagnosa'] ?? '') ?></textarea>
              </div>

              <div class="form-group mt-2">
                <button type="submit" class="btn btn-warning"><i class="la la-save"></i> Update</button>
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

