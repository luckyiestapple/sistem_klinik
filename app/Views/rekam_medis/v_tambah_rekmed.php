<?= $this->extend('templates/index') ?>
<?= $this->section('content') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Input Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('rekam_medis') ?>">Rekam Medis</a></li>
      <li class="breadcrumb-item active">Input</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-9 offset-md-1">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Rekam Medis Pasien</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('rekam_medis/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label>Pasien <span class="text-danger">*</span></label>
                  <select name="id_pasien" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    <?php foreach ($pasien as $p): ?>
                    <option value="<?= $p['id_pasien'] ?>"
                      <?= (isset($_GET['id_pasien']) && $_GET['id_pasien'] == $p['id_pasien']) ? 'selected' : '' ?>>
                      <?= esc($p['nama_pasien']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Dokter Pemeriksa <span class="text-danger">*</span></label>
                  <select name="id_dokter" class="form-control" required>
                    <option value="">-- Pilih Dokter --</option>
                    <?php foreach ($dokter as $d): ?>
                    <option value="<?= $d['id_dokter'] ?>">
                      <?= esc($d['nama_dokter']) ?> — <?= esc($d['spesialisasi']) ?>
                    </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Tanggal & Jam Periksa <span class="text-danger">*</span></label>
                <input type="datetime-local" name="tanggal_periksa" class="form-control"
                       value="<?= date('Y-m-d\TH:i') ?>" required>
              </div>
              <div class="form-group">
                <label>Keluhan / Gejala <span class="text-danger">*</span></label>
                <textarea name="keluhan" class="form-control" rows="3"
                          placeholder="Deskripsikan keluhan pasien..." required></textarea>
              </div>
              <div class="form-group">
                <label>Hasil Pemeriksaan / Diagnosa</label>
                <textarea name="hasil_pemeriksaan" class="form-control" rows="4"
                          placeholder="Hasil pemeriksaan dan diagnosa dokter..."></textarea>
              </div>
              <div class="form-group mt-2">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan Rekam Medis</button>
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
