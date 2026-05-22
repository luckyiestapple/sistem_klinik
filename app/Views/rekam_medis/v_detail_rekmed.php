<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Detail Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('rekam_medis') ?>">Rekam Medis</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-10 offset-md-1 col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
          <h4 class="card-title">Rincian Rekam Medis: #<?= $rekam_medis['id_rekam_medis'] ?></h4>
          <div class="heading-elements">
            <a href="<?= base_url('resep/tambah/'.$rekam_medis['id_rekam_medis']) ?>" class="btn btn-success font-weight-bold">
              <i class="la la-plus-circle"></i> Buat Resep Obat
            </a>
            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-secondary font-weight-bold ml-1">
              <i class="la la-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            
            <!-- Grid Identitas Pasien & Dokter -->
            <div class="row mb-3">
              <div class="col-md-6 col-12">
                <h5 class="text-info border-bottom pb-1"><i class="la la-user"></i> Informasi Pasien</h5>
                <table class="table table-sm table-borderless">
                  <tr>
                    <th width="140">Nama Pasien</th>
                    <td>: <strong><?= esc($rekam_medis['nama_pasien']) ?></strong></td>
                  </tr>
                  <tr>
                    <th>Gender / Umur</th>
                    <td>: 
                      <?= $rekam_medis['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?> / 
                      <?php 
                        if (!empty($rekam_medis['tgl_lahir'])) {
                            $birthDate = new \DateTime($rekam_medis['tgl_lahir']);
                            $today = new \DateTime();
                            $age = $today->diff($birthDate)->y;
                            echo $age . ' Tahun';
                        } else {
                            echo '-';
                        }
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <th>No. Telepon</th>
                    <td>: <?= esc($rekam_medis['no_telp'] ?? '-') ?></td>
                  </tr>
                  <tr>
                    <th>Golongan Darah</th>
                    <td>: <span class="badge badge-light-danger"><?= esc($rekam_medis['gol_darah'] ?? '-') ?></span></td>
                  </tr>
                  <tr>
                    <th>Alergi Obat</th>
                    <td>: <span class="text-danger font-weight-bold"><?= esc($rekam_medis['alergi_obat'] ?? 'Tidak Ada Alergi') ?></span></td>
                  </tr>
                </table>
              </div>
              <div class="col-md-6 col-12">
                <h5 class="text-info border-bottom pb-1"><i class="la la-user-md"></i> Informasi Pemeriksa</h5>
                <table class="table table-sm table-borderless">
                  <tr>
                    <th width="140">Nama Dokter</th>
                    <td>: <strong><?= esc($rekam_medis['nama_dokter']) ?></strong></td>
                  </tr>
                  <tr>
                    <th>Poli / Spesialisasi</th>
                    <td>: <span class="badge badge-info">Poli <?= esc($rekam_medis['spesialisasi']) ?></span></td>
                  </tr>
                  <tr>
                    <th>Tanggal Periksa</th>
                    <td>: <?= date('d F Y - H:i', strtotime($rekam_medis['tgl_periksa'])) ?> WIB</td>
                  </tr>
                </table>
              </div>
            </div>

            <!-- Tanda-Tanda Vital (Vitals) -->
            <h5 class="text-info border-bottom pb-1 mb-2"><i class="la la-heartbeat"></i> Tanda-Tanda Vital (Vitals)</h5>
            <div class="row mb-3 text-center">
              <div class="col-md-2 col-6 mb-2">
                <div class="bg-light p-2 rounded">
                  <span class="d-block text-muted font-small-3">Tekanan Darah</span>
                  <strong class="font-medium-3"><?= esc($rekam_medis['tensi'] ?: '-') ?></strong>
                </div>
              </div>
              <div class="col-md-2 col-6 mb-2">
                <div class="bg-light p-2 rounded">
                  <span class="d-block text-muted font-small-3">Nadi</span>
                  <strong class="font-medium-3"><?= esc($rekam_medis['nadi'] ?: '-') ?></strong>
                </div>
              </div>
              <div class="col-md-2 col-6 mb-2">
                <div class="bg-light p-2 rounded">
                  <span class="d-block text-muted font-small-3">Suhu Tubuh</span>
                  <strong class="font-medium-3"><?= esc($rekam_medis['suhu'] ?: '-') ?></strong>
                </div>
              </div>
              <div class="col-md-3 col-6 mb-2">
                <div class="bg-light p-2 rounded">
                  <span class="d-block text-muted font-small-3">Berat Badan</span>
                  <strong class="font-medium-3"><?= esc($rekam_medis['berat_badan'] ? $rekam_medis['berat_badan'] . ' kg' : '-') ?></strong>
                </div>
              </div>
              <div class="col-md-3 col-12 mb-2">
                <div class="bg-light p-2 rounded">
                  <span class="d-block text-muted font-small-3">Tinggi Badan</span>
                  <strong class="font-medium-3"><?= esc($rekam_medis['tinggi_badan'] ? $rekam_medis['tinggi_badan'] . ' cm' : '-') ?></strong>
                </div>
              </div>
            </div>

            <!-- Detail Keluhan, Pemeriksaan, Diagnosa -->
            <h5 class="text-info border-bottom pb-1 mb-2"><i class="la la-paste"></i> Hasil Pemeriksaan</h5>
            <div class="row">
              <div class="col-12 mb-2">
                <label class="font-weight-bold">Keluhan / Gejala Utama:</label>
                <div class="p-2 border rounded bg-light"><?= nl2br(esc($rekam_medis['keluhan'])) ?></div>
              </div>
              <div class="col-12 mb-2">
                <label class="font-weight-bold">Catatan Pemeriksaan Fisik:</label>
                <div class="p-2 border rounded bg-light">
                  <?= $rekam_medis['pemeriksaan_fisik']
                      ? nl2br(esc($rekam_medis['pemeriksaan_fisik']))
                      : '<em class="text-muted">Tidak ada catatan pemeriksaan fisik.</em>' ?>
                </div>
              </div>
              <div class="col-12 mb-2">
                <label class="font-weight-bold text-success">Diagnosa / Hasil Pemeriksaan Akhir:</label>
                <div class="p-2 border border-success rounded bg-light font-weight-bold text-dark">
                  <?= nl2br(esc($rekam_medis['diagnosa'])) ?>
                </div>
              </div>
            </div>

            <!-- Tindak Lanjut -->
            <h5 class="text-info border-bottom pb-1 mb-2 mt-3"><i class="la la-calendar"></i> Rencana Tindak Lanjut</h5>
            <div class="row">
              <div class="col-md-6 col-12">
                <table class="table table-sm table-borderless">
                  <tr>
                    <th width="180">Tanggal Kontrol Kembali</th>
                    <td>: <strong><?= $rekam_medis['tgl_kontrol'] ? date('d F Y', strtotime($rekam_medis['tgl_kontrol'])) : 'Tidak dijadwalkan kontrol' ?></strong></td>
                  </tr>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
