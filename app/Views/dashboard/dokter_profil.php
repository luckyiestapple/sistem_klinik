<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row mb-3">
  <div class="col-12">
    <h3 class="content-header-title text-bold-700">Profil Saya</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard_dokter') ?>">Dashboard</a></li>
      <li class="breadcrumb-item active">Profil</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <?php if(session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('success') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>
  <?php if(session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <?php endif; ?>

  <?php 
  // Determine profile image URL
  if (!empty($dokter['foto'])) {
      $avatarUrl = base_url('uploads/profile/' . $dokter['foto']);
  } else {
      $avatarUrl = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($dokter['nama'] ?? 'Dokter');
  }
  ?>

  <div class="row justify-content-center">
    <div class="col-md-8 col-12">
      
      <!-- 1. Header Banner (Biru) -->
      <div class="card text-white mb-3" style="background: linear-gradient(135deg, #0099ff, #0066cc); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
          <div class="card-body py-3 px-3">
              <div class="row align-items-center">
                  <div class="col-md-auto col-12 text-center text-md-left mb-2 mb-md-0">
                      <img src="<?= $avatarUrl ?>" class="bg-white rounded-circle" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid #fff; aspect-ratio: 1/1;">
                  </div>
                  <div class="col-md col-12 text-center text-md-left">
                      <!-- Capitalize doctor name as shown in the mockup -->
                      <h3 class="text-white text-bold-700 mb-1" style="font-size: 1.8rem;"><?= strtoupper(esc($dokter['nama'])) ?></h3>
                      <h5 class="text-white opacity-90 mb-0"><?= esc($dokter['sip_str']) ?></h5>
                      
                      <?php if (!$can_update_foto): ?>
                          <div class="mt-2">
                              <span class="badge badge-success text-white font-small-3 py-2 px-3" style="border-radius: 6px; white-space: normal; text-align: left; background-color: #28a745; border: none; font-weight: 600;">
                                  <i class="la la-lock font-medium-1 align-middle mr-1"></i>
                                  Foto Profil Terkunci (Hanya 1 kali pengisian)
                              </span>
                          </div>
                      <?php else: ?>
                          <div class="mt-2">
                              <form action="<?= base_url('dokter/profil/update_foto') ?>" method="POST" enctype="multipart/form-data">
                                  <?= csrf_field() ?>
                                  <div class="d-flex align-items-center flex-wrap justify-content-center justify-content-md-start">
                                      <div class="custom-file mr-md-2 mb-2 mb-md-0" style="width: 250px; max-width: 100%;">
                                          <input type="file" name="foto" class="custom-file-input" id="uploadFotoInput" required onchange="document.getElementById('upload-label').innerText = this.files[0].name">
                                          <label class="custom-file-label text-left text-muted" for="uploadFotoInput" id="upload-label" style="font-size: 0.85rem;">Pilih foto...</label>
                                      </div>
                                      <button type="submit" class="btn btn-warning btn-sm font-weight-bold py-1 px-3 text-dark" style="background-color: #ffc107; border: none; border-radius: 6px;">
                                          <i class="la la-upload"></i> Unggah Foto
                                      </button>
                                  </div>
                              </form>
                          </div>
                      <?php endif; ?>
                  </div>
              </div>
          </div>
      </div>

      <!-- 2. Card DATA PROFIL DOKTER -->
      <div class="card mb-3 box-shadow-1">
          <div class="card-header border-bottom py-2">
              <h4 class="card-title text-bold-600 mb-0">DATA PROFIL DOKTER</h4>
          </div>
          <div class="card-content">
              <div class="card-body">
                  <form action="<?= base_url('dokter/profil/update') ?>" method="POST">
                      <?= csrf_field() ?>
                      
                      <!-- Hidden inputs to preserve other fields required by DashboardDokter::profilUpdate -->
                      <input type="hidden" name="nama" value="<?= esc($dokter['nama']) ?>">
                      <input type="hidden" name="alamat" value="<?= esc($dokter['alamat']) ?>">
                      <input type="hidden" name="no_telp" value="<?= esc($dokter['no_telp']) ?>">
                      <input type="hidden" name="email" value="<?= esc($dokter['email'] ?? '') ?>">
                      <input type="hidden" name="sip_str" value="<?= esc($dokter['sip_str'] ?? '') ?>">
                      <input type="hidden" name="hari_praktek" value="<?= esc($dokter['hari_praktek'] ?? '') ?>">
                      <input type="hidden" name="jam_praktek" value="<?= esc($dokter['jam_praktek'] ?? '') ?>">

                      <!-- Nama -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Nama <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="Dokter <?= esc(preg_replace('/^dr\.\s+/i', '', $dokter['nama'])) ?>" readonly>
                          </div>
                      </div>

                      <!-- Spesialisasi -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Spesialisasi <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($dokter['spesialisasi']) ?>" readonly>
                          </div>
                      </div>

                      <!-- No. Telp -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">No. Telp <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($dokter['no_telp'] ?? '-') ?>" readonly>
                          </div>
                      </div>

                      <!-- Username -->
                      <div class="form-group row align-items-center mb-3">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Username <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="dokter <?= esc($user['username'] ?? '') ?>" readonly>
                          </div>
                      </div>

                      <!-- Ganti Password Trigger & Collapse Form -->
                      <div class="form-group mb-0">
                          <button class="btn text-white btn-block font-weight-bold font-medium-1 py-1 mb-2" type="button" data-toggle="collapse" data-target="#collapsePassword" aria-expanded="false" aria-controls="collapsePassword" style="background-color: #2b6cb0; border: none; border-radius: 6px;">
                              Ganti Password
                          </button>

                          <div class="collapse" id="collapsePassword">
                              <div class="card card-body border box-shadow-0 p-2 mb-0">
                                  <div class="form-group row align-items-center mb-3">
                                      <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Password Baru</label>
                                      <div class="col-sm-8 col-12">
                                          <input type="password" name="password" class="form-control" placeholder="Password minimal 6 karakter" required>
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="offset-sm-4 col-sm-8 col-12">
                                          <button type="submit" class="btn btn-success btn-block font-weight-bold font-medium-1 py-1" style="border-radius: 6px;">
                                              Simpan Perubahan
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>

                  </form>
              </div>
          </div>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
