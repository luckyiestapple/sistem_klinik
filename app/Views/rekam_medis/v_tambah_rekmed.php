<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

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
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger mx-2">
      <?= session()->getFlashdata('error') ?>
  </div>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-10 offset-md-1 col-12">
      <div class="card">
        <div class="card-header"><h4 class="card-title">Form Rekam Medis Pasien</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('rekam_medis/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              
              <!-- Hidden input for id_antrean if prefilled -->
              <?php if (!empty($prefilledAntrean)): ?>
                <input type="hidden" name="id_antrean" value="<?= $prefilledAntrean['id_antrean'] ?>">
              <?php endif; ?>

              <!-- Bagian 1: Identitas & Tanggal -->
              <h5 class="form-section text-info"><i class="la la-user"></i> 1. Informasi Kunjungan</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Pasien <span class="text-danger">*</span></label>
                    <select name="id_pasien" class="form-control" required>
                      <option value="">-- Pilih Pasien --</option>
                      <?php foreach ($pasien as $p): ?>
                        <?php 
                        $selected = '';
                        if (!empty($prefilledAntrean) && $prefilledAntrean['id_pasien'] == $p['id_pasien']) {
                            $selected = 'selected';
                        } elseif (request()->getGet('id_pasien') == $p['id_pasien']) {
                            $selected = 'selected';
                        }
                        ?>
                        <option value="<?= $p['id_pasien'] ?>" <?= $selected ?>>
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
                        <?php 
                        $selected = '';
                        if (!empty($prefilledAntrean) && $prefilledAntrean['id_dokter'] == $d['id_dokter']) {
                            $selected = 'selected';
                        } elseif (session()->get('id_level') == 3 && session()->get('id_referensi') == $d['id_dokter']) {
                            $selected = 'selected';
                        }
                        ?>
                        <option value="<?= $d['id_dokter'] ?>" <?= $selected ?>>
                          <?= esc($d['nama']) ?> — Poli <?= esc($d['spesialisasi']) ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Tanggal & Jam Periksa <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="tanggal_periksa" class="form-control" value="<?= date('Y-m-d\TH:i') ?>" required>
                  </div>
                </div>
              </div>

              <!-- Bagian 2: Tanda-tanda Vital -->
              <h5 class="form-section text-info mt-3"><i class="la la-heartbeat"></i> 2. Tanda-Tanda Vital (Vitals)</h5>
              <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tekanan Darah (Tensi)</label>
                    <input type="text" name="tensi" class="form-control" placeholder="Contoh: 120/80 mmHg" value="<?= old('tensi') ?>">
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Nadi</label>
                    <input type="text" name="nadi" class="form-control" placeholder="Contoh: 80 x/menit" value="<?= old('nadi') ?>">
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Suhu Tubuh</label>
                    <input type="text" name="suhu" class="form-control" placeholder="Contoh: 36.5 °C" value="<?= old('suhu') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Berat Badan (kg)</label>
                    <input type="text" name="berat_badan" class="form-control" placeholder="Contoh: 65" value="<?= old('berat_badan') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                  <div class="form-group">
                    <label>Tinggi Badan (cm)</label>
                    <input type="text" name="tinggi_badan" class="form-control" placeholder="Contoh: 170" value="<?= old('tinggi_badan') ?>">
                  </div>
                </div>
              </div>

              <!-- Bagian 3: Keluhan & Diagnosa -->
              <h5 class="form-section text-info mt-3"><i class="la la-paste"></i> 3. Pemeriksaan Klinis</h5>
              <div class="form-group">
                <label>Keluhan / Gejala Utama <span class="text-danger">*</span></label>
                <textarea name="keluhan" class="form-control" rows="3" placeholder="Deskripsikan keluhan pasien..." required><?php 
                  if (!empty($prefilledAntrean)) {
                      echo esc($prefilledAntrean['keluhan'] ?? '');
                  } else {
                      echo old('keluhan');
                  }
                ?></textarea>
              </div>
              <div class="form-group">
                <label>Catatan Pemeriksaan Fisik</label>
                <textarea name="pemeriksaan_fisik" class="form-control" rows="3" placeholder="Hasil pemeriksaan fisik secara detail..."><?= old('pemeriksaan_fisik') ?></textarea>
              </div>
              <div class="form-group">
                <label>Hasil Pemeriksaan / Diagnosa <span class="text-danger">*</span></label>
                <textarea name="hasil_pemeriksaan" class="form-control" rows="4" placeholder="Hasil diagnosa dokter..." required><?= old('hasil_pemeriksaan') ?></textarea>
              </div>

              <!-- Bagian 4: Resep Obat -->
              <h5 class="form-section text-info mt-3"><i class="la la-clipboard"></i> 4. Resep Obat (Opsional)</h5>
              <div class="form-group">
                <label>Resep / Aturan Pakai Obat</label>
                <textarea name="resep_obat" class="form-control" rows="3" placeholder="Contoh: Paracetamol 500mg (3x1 tablet setelah makan), Amoxicillin 500mg (3x1 tablet, habiskan)..."><?= old('resep_obat') ?></textarea>
              </div>

              <!-- Bagian 5: Rencana & Kontrol Kembali -->
              <h5 class="form-section text-info mt-3"><i class="la la-calendar"></i> 5. Tindak Lanjut</h5>
              <div class="form-group">
                <label>Tanggal Kontrol Kembali (Opsional)</label>
                <input type="date" name="tgl_kontrol" class="form-control" value="<?= old('tgl_kontrol') ?>">
              </div>

              <div class="form-group mt-3 border-top pt-3">
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
