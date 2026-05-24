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
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger mx-2">
      <?= session()->getFlashdata('error') ?>
  </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-10 offset-md-1 col-12">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Edit Rekam Medis</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('rekam_medis/update/'.$rekam_medis['id_rekam_medis']) ?>" method="POST">
              <?= csrf_field() ?>
              
              <!-- Bagian 1: Identitas & Tanggal -->
              <h5 class="form-section text-info"><i class="la la-user"></i> 1. Informasi Kunjungan</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Pasien <span class="text-danger">*</span></label>
                    <select name="id_pasien" class="form-control" required>
                      <?php foreach ($pasien as $p): ?>
                        <option value="<?= $p['id_pasien'] ?>" <?= $rekam_medis['id_pasien'] == $p['id_pasien'] ? 'selected' : '' ?>>
                          <?= esc($p['nama']) ?> — (<?= $p['id_pasien'] ?>)
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Dokter Pemeriksa <span class="text-danger">*</span></label>
                    <select name="id_dokter" class="form-control" required>
                      <?php foreach ($dokter as $d): ?>
                        <option value="<?= $d['id_dokter'] ?>" <?= $rekam_medis['id_dokter'] == $d['id_dokter'] ? 'selected' : '' ?>>
                          <?= esc($d['nama']) ?> — Poli <?= esc($d['spesialisasi']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Tanggal & Jam Periksa <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tanggal_periksa" class="form-control" 
                           value="<?= date('Y-m-d\TH:i', strtotime($rekam_medis['tgl_periksa'])) ?>" required>
                  </div>
                </div>
              </div>

              <!-- Bagian 2: Tanda-tanda Vital -->
              <h5 class="form-section text-info mt-3"><i class="la la-heartbeat"></i> 2. Tanda-Tanda Vital (Vitals)</h5>
              <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tekanan Darah (Tensi)</label>
                    <input type="text" name="tensi" class="form-control" placeholder="Contoh: 120/80 mmHg" value="<?= esc($rekam_medis['tensi'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nadi</label>
                    <input type="text" name="nadi" class="form-control" placeholder="Contoh: 80 x/menit" value="<?= esc($rekam_medis['nadi'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Suhu Tubuh</label>
                    <input type="text" name="suhu" class="form-control" placeholder="Contoh: 36.5 °C" value="<?= esc($rekam_medis['suhu'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Berat Badan (kg)</label>
                    <input type="text" name="berat_badan" class="form-control" placeholder="Contoh: 65" value="<?= esc($rekam_medis['berat_badan'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tinggi Badan (cm)</label>
                    <input type="text" name="tinggi_badan" class="form-control" placeholder="Contoh: 170" value="<?= esc($rekam_medis['tinggi_badan'] ?? '') ?>">
                  </div>
                </div>
              </div>

              <!-- Bagian 3: Keluhan & Diagnosa -->
              <h5 class="form-section text-info mt-3"><i class="la la-paste"></i> 3. Pemeriksaan Klinis</h5>
              <div class="form-group">
                <label>Keluhan / Gejala Utama <span class="text-danger">*</span></label>
                <textarea name="keluhan" class="form-control" rows="3" required readonly><?= esc($rekam_medis['keluhan']) ?></textarea>
              </div>
              <div class="form-group">
                <label>Catatan Pemeriksaan Fisik</label>
                <textarea name="pemeriksaan_fisik" class="form-control" rows="3"><?= esc($rekam_medis['pemeriksaan_fisik'] ?? '') ?></textarea>
              </div>
              <div class="form-group">
                <label>Hasil Pemeriksaan / Diagnosa <span class="text-danger">*</span></label>
                <textarea name="hasil_pemeriksaan" class="form-control" rows="4" required><?= esc($rekam_medis['diagnosa']) ?></textarea>
              </div>

              <!-- Bagian 4: Rencana & Kontrol Kembali -->
              <h5 class="form-section text-info mt-3"><i class="la la-calendar"></i> 4. Tindak Lanjut</h5>
              <div class="form-group">
                <label>Tanggal Kontrol Kembali (Opsional)</label>
                <input type="date" name="tgl_kontrol" class="form-control" value="<?= $rekam_medis['tgl_kontrol'] ?? '' ?>">
              </div>

              <div class="form-group mt-3 border-top pt-3">
                <button type="submit" class="btn btn-warning text-white"><i class="la la-save"></i> Perbarui Rekam Medis</button>
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
