<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row mb-3">
  <div class="col-12">
    <h3 class="content-header-title text-bold-700">Profil Saya</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dashboard_pasien') ?>">Dashboard</a></li>
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
  if (!empty($pasien['foto'])) {
      $avatarUrl = base_url('uploads/profile/' . $pasien['foto']);
  } else {
      $avatarUrl = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($pasien['nama'] ?? 'Pasien');
  }
  ?>

  <!-- 1. Header Banner (Biru) -->
  <div class="card text-white mb-3" style="background: linear-gradient(135deg, #0099ff, #0066cc); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
      <div class="card-body py-3 px-3">
          <div class="row align-items-center">
              <div class="col-md-auto col-12 text-center text-md-left mb-2 mb-md-0">
                  <img src="<?= $avatarUrl ?>" class="bg-white" style="width: 100px; height: 100px; border-radius: 12px; object-fit: cover; border: 3px solid #fff; aspect-ratio: 1/1;">
              </div>
              <div class="col-md col-12 text-center text-md-left">
                  <h3 class="text-white text-bold-700 mb-1" style="font-size: 1.8rem;"><?= esc($pasien['nama']) ?></h3>
                  <h5 class="text-white opacity-90 mb-0">ID Pasien: <?= esc($pasien['id_pasien']) ?></h5>
                  
                  <?php if (!$can_update_foto): ?>
                      <div class="mt-2">
                          <span class="badge badge-warning text-dark font-small-3 py-2 px-3" style="border-radius: 6px; white-space: normal; text-align: left; background-color: #ffd800; border: none;">
                              <i class="la la-info-circle font-medium-1 align-middle mr-1"></i>
                              Foto dapat diubah kembali dalam <strong><?= $days_remaining ?></strong> hari (Terakhir diperbarui: <?= date('Y-m-d', strtotime($pasien['foto_updated_at'])) ?>)
                          </span>
                      </div>
                  <?php else: ?>
                      <div class="mt-2">
                          <form action="<?= base_url('profil_pasien/update_foto') ?>" method="POST" enctype="multipart/form-data">
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

  <!-- 2. Grid Layout untuk Data & Form Edit -->
  <div class="row">
      <!-- Kolom Kiri -->
      <div class="col-md-6 col-12">
          <!-- Card BIODATA & KONTAK -->
          <div class="card mb-3 box-shadow-1">
              <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center">
                  <h4 class="card-title text-bold-600 mb-0">BIODATA & KONTAK</h4>
                  <i class="la la-lock text-muted font-medium-2"></i>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <!-- Nama Lengkap -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Nama Lengkap <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['nama']) ?>" readonly>
                          </div>
                      </div>
                      <!-- ID Pasien -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">ID Pasien <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['id_pasien']) ?>" readonly>
                          </div>
                      </div>
                      <!-- Jenis Kelamin -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Jenis Kelamin <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['jk'] === 'L' ? 'Laki-laki' : ($pasien['jk'] === 'P' ? 'Perempuan' : $pasien['jk'])) ?>" readonly>
                          </div>
                      </div>
                      <!-- Tanggal Lahir -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Tanggal Lahir <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['tgl_lahir'] ?? '-') ?>" readonly>
                          </div>
                      </div>
                      <!-- No. Telp -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">No. Telp <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['no_telp'] ?? '-') ?>" readonly>
                          </div>
                      </div>
                      <!-- Alamat -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Alamat <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['alamat'] ?? '-') ?>" readonly>
                          </div>
                      </div>
                      <!-- Golongan Darah -->
                      <div class="form-group row align-items-center mb-0">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Golongan Darah <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['gol_darah'] ?: '-') ?>" readonly>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Card UBAH NOMOR TELEPON -->
          <div class="card mb-3 box-shadow-1">
              <div class="card-header border-bottom py-2">
                  <h4 class="card-title text-bold-600 mb-0">UBAH NOMOR TELEPON</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form action="<?= base_url('profil_pasien/update_info') ?>" method="POST">
                          <?= csrf_field() ?>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Nama <i class="la la-lock text-muted ml-1"></i></label>
                              <div class="col-sm-8 col-12">
                                  <input type="text" class="form-control bg-light" value="<?= esc($pasien['nama']) ?>" readonly>
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">No. Telp <i class="la la-phone text-muted ml-1"></i></label>
                              <div class="col-sm-8 col-12">
                                  <input type="text" name="no_telp" class="form-control" value="<?= esc($pasien['no_telp'] ?? '') ?>" required>
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="offset-sm-4 col-sm-8 col-12">
                                  <button type="submit" class="btn text-white btn-block font-weight-bold" style="background-color: #2b6cb0; border: none; border-radius: 6px;">Simpan Perubahan</button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

      <!-- Kolom Kanan -->
      <div class="col-md-6 col-12">
          <!-- Card STATUS & JAMINAN KESEHATAN -->
          <div class="card mb-3 box-shadow-1">
              <div class="card-header border-bottom py-2 d-flex justify-content-between align-items-center">
                  <h4 class="card-title text-bold-600 mb-0">STATUS & JAMINAN KESEHATAN</h4>
                  <i class="la la-lock text-muted font-medium-2"></i>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <!-- Status BPJS -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Status BPJS</label>
                          <div class="col-sm-8 col-12">
                              <?php if (strtolower($pasien['status_bpjs'] ?? '') === 'aktif'): ?>
                                  <span class="badge badge-success px-2 py-1" style="font-size: 0.9rem; border-radius: 6px;"><i class="la la-check-circle"></i> Aktif</span>
                              <?php else: ?>
                                  <span class="badge badge-danger px-2 py-1" style="font-size: 0.9rem; border-radius: 6px;"><i class="la la-times-circle"></i> Tidak Aktif</span>
                              <?php endif; ?>
                          </div>
                      </div>
                      <!-- No. BPJS -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">No. BPJS <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['no_bpjs'] ?: '-') ?>" readonly>
                          </div>
                      </div>
                      <!-- Faskes Tingkat I -->
                      <div class="form-group row align-items-center">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Faskes Tingkat I <i class="la la-lock text-muted ml-1"></i></label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['faskes'] ?: '-') ?>" readonly>
                          </div>
                      </div>
                      <!-- Kelas Rawat -->
                      <div class="form-group row align-items-center mb-0">
                          <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Kelas Rawat</label>
                          <div class="col-sm-8 col-12">
                              <input type="text" class="form-control bg-light" value="<?= esc($pasien['kelas_rawat'] ?: '-') ?>" readonly>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Card MINTA PERUBAHAN DATA KE ADMIN -->
          <div class="card text-white text-center py-2 px-3 mb-3 box-shadow-1" style="background-color: #2b6cb0; border-radius: 10px; border: none;">
              <h5 class="text-white text-bold-700 mb-1" style="letter-spacing: 0.5px;">MINTA PERUBAHAN DATA KE ADMIN</h5>
              <p class="mb-0 font-small-3 opacity-90">Hanya Admin yang dapat merubah data profil. Silakan hubungi admin di 0821-xxxx-xxxx.</p>
          </div>

          <!-- Card GANTI PASSWORD -->
          <div class="card mb-3 box-shadow-1">
              <div class="card-header border-bottom py-2">
                  <h4 class="card-title text-bold-600 mb-0">GANTI PASSWORD</h4>
              </div>
              <div class="card-content">
                  <div class="card-body">
                      <form action="<?= base_url('profil_pasien/update_password') ?>" method="POST">
                          <?= csrf_field() ?>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Ganti Password <i class="la la-lock text-muted ml-1"></i></label>
                              <div class="col-sm-8 col-12">
                                  <input type="password" name="password" class="form-control" placeholder="Password Baru" required>
                              </div>
                          </div>
                          <div class="form-group row align-items-center">
                              <label class="col-sm-4 col-12 text-bold-600 text-muted pr-0 mb-0">Ganti Password <i class="la la-lock text-muted ml-1"></i></label>
                              <div class="col-sm-8 col-12">
                                  <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
                              </div>
                          </div>
                          <div class="form-group row mb-0">
                              <div class="offset-sm-4 col-sm-8 col-12">
                                  <button type="submit" class="btn text-white btn-block font-weight-bold" style="background-color: #2b6cb0; border: none; border-radius: 6px;">Simpan Perubahan</button>
                              </div>
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- Modal Cropper -->
<div class="modal fade text-left" id="cropperModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header bg-info text-white py-2">
                <h5 class="modal-title text-white text-bold-600"><i class="la la-crop"></i> Potong Foto Profil</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" id="btnCancelCrop">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-3 text-center">
                <div style="max-height: 380px; width: 100%; display: flex; justify-content: center; align-items: center; background-color: #f8f9fa; border-radius: 8px; overflow: hidden;">
                    <img id="cropperImageSrc" style="max-width: 100%; max-height: 360px;">
                </div>
                <small class="text-muted mt-2 d-block">Geser atau sesuaikan kotak potong agar pas di bagian wajah Anda.</small>
            </div>
            <div class="modal-footer d-flex justify-content-between py-2">
                <button type="button" class="btn btn-secondary btn-sm font-weight-bold" data-dismiss="modal" id="btnCancelCrop2">Batal</button>
                <button type="button" class="btn btn-warning btn-sm font-weight-bold text-dark" id="btnDoCrop" style="background-color: #ffc107; border: none;">
                    <i class="la la-check"></i> Potong & Unggah
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<style>
  /* Enforce circular cropper box for beautiful circle avatar alignment */
  .cropper-view-box,
  .cropper-face {
    border-radius: 50%;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
      const uploadInput = document.getElementById('uploadFotoInput');
      const cropperModal = $('#cropperModal');
      const cropperImageSrc = document.getElementById('cropperImageSrc');
      const btnDoCrop = document.getElementById('btnDoCrop');
      const btnCancelCrop = document.getElementById('btnCancelCrop');
      const btnCancelCrop2 = document.getElementById('btnCancelCrop2');
      let cropperInstance = null;
      let photoForm = null;

      if (uploadInput) {
          photoForm = uploadInput.closest('form');
          
          // Add hidden input to hold base64 cropped image data
          const hiddenInput = document.createElement('input');
          hiddenInput.type = 'hidden';
          hiddenInput.name = 'foto_cropped';
          hiddenInput.id = 'fotoCroppedInput';
          photoForm.appendChild(hiddenInput);

          uploadInput.addEventListener('change', function(e) {
              const files = e.target.files;
              if (files && files.length > 0) {
                  const file = files[0];
                  
                  // Simple check for image format
                  if (!file.type.startsWith('image/')) {
                      alert('Format berkas harus berupa gambar.');
                      uploadInput.value = '';
                      return;
                  }

                  const reader = new FileReader();
                  reader.onload = function(evt) {
                      cropperImageSrc.src = evt.target.result;
                      
                      // Show the modal
                      cropperModal.modal('show');
                  };
                  reader.readAsDataURL(file);
              }
          });

          // Initialize cropper after modal is fully shown
          cropperModal.on('shown.bs.modal', function() {
              cropperInstance = new Cropper(cropperImageSrc, {
                  aspectRatio: 1,
                  viewMode: 1,
                  autoCropArea: 0.9,
                  dragMode: 'move',
                  cropBoxResizable: true,
                  cropBoxMovable: true
              });
          });

          // Destroy cropper when modal is hidden
          cropperModal.on('hidden.bs.modal', function() {
              if (cropperInstance) {
                  cropperInstance.destroy();
                  cropperInstance = null;
              }
              uploadInput.value = '';
              const uploadLabel = document.getElementById('upload-label');
              if (uploadLabel) uploadLabel.innerText = 'Pilih foto...';
          });

          // Handle crop action
          btnDoCrop.addEventListener('click', function() {
              if (cropperInstance) {
                  const canvas = cropperInstance.getCroppedCanvas({
                      width: 400,
                      height: 400
                  });

                  if (canvas) {
                      const croppedBase64 = canvas.toDataURL('image/jpeg', 0.9);
                      document.getElementById('fotoCroppedInput').value = croppedBase64;
                      
                      // Hide modal and submit form automatically
                      cropperModal.modal('hide');
                      
                      // Add loading indicator
                      btnDoCrop.innerHTML = '<i class="la la-spinner la-spin"></i> Memproses...';
                      btnDoCrop.disabled = true;

                      photoForm.submit();
                  }
              }
          });
      }
  });
</script>
<?= $this->endSection() ?>
