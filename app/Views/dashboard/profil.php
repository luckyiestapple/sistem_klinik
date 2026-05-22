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

  <!-- Row untuk Profil Card Info (Atas, Terpusat) -->
  <div class="row justify-content-center mb-3">
    <div class="col-md-6 col-12">
      <div class="card bg-info text-white text-center p-3 box-shadow-2">
        <div class="card-content">
          <div class="card-body">
            <div class="avatar avatar-xl mb-2">
              <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($pasien['nama'] ?? 'Pasien') ?>" class="rounded-circle bg-white img-thumbnail" style="width: 100px; height: 100px;">
            </div>
            <h4 class="text-white text-bold-600 mt-2"><?= esc($pasien['nama'] ?? '') ?></h4>
            <span class="badge badge-pill badge-warning px-3 py-1 mt-1">ID Pasien: <?= esc($pasien['id_pasien'] ?? '') ?></span>
            
            <!-- Box info abu-abu di bagian bawah card biru (hanya menampilkan data statis) -->
            <div class="mt-4 p-3 bg-light text-dark rounded text-center font-medium-1" style="opacity: 0.95;">
              <strong>Tanggal Lahir:</strong> <?= esc($pasien['tgl_lahir'] ?? '-') ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Row untuk Form input dan Ganti Password -->
  <div class="row">
    <!-- Card Ubah Kontak & BPJS (Kiri) -->
    <div class="col-md-6 col-12 mb-3">
      <div class="card h-100">
        <div class="card-header">
          <h4 class="card-title text-bold-600"><i class="ft-edit-2 mr-1"></i> Ubah Nomor Telepon</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('profil_pasien/update_info') ?>" method="POST">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label>Nomor Telepon <span class="text-danger">*</span></label>
                <input type="text" name="no_telp" class="form-control" value="<?= esc($pasien['no_telp'] ?? '') ?>" required>
                <small class="form-text text-muted">Gunakan nomor telepon aktif Anda.</small>
              </div>

              <div class="form-group">
                <label>Nomor BPJS / JKN (Terkunci)</label>
                <input type="text" class="form-control" value="<?= esc($pasien['no_bpjs'] ?: 'Tidak Ada BPJS') ?>" readonly>
                <small class="form-text text-muted">Nomor BPJS/JKN terdaftar tidak dapat diubah.</small>
              </div>

              <div class="form-group mt-4 border-top pt-3">
                <button type="submit" class="btn btn-info text-white font-weight-bold">
                  <i class="la la-save"></i> Simpan Nomor Baru
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Ganti Password (Kanan) -->
    <div class="col-md-6 col-12 mb-3">
      <div class="card h-100">
        <div class="card-header">
          <h4 class="card-title text-bold-600"><i class="ft-lock mr-1"></i> Ganti Password</h4>
        </div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('profil_pasien/update_password') ?>" method="POST">
              <?= csrf_field() ?>
              
              <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" value="<?= esc($user['username'] ?? '') ?>" readonly>
                <small class="form-text text-muted">Username login tidak dapat diubah.</small>
              </div>

              <div class="form-group">
                <label>Password Baru <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" placeholder="Password minimal 6 karakter" required>
              </div>

              <div class="form-group">
                <label>Konfirmasi Password Baru <span class="text-danger">*</span></label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password baru" required>
              </div>

              <div class="form-group mt-4 border-top pt-3">
                <button type="submit" class="btn btn-warning text-white font-weight-bold">
                  <i class="la la-key"></i> Simpan Password Baru
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
