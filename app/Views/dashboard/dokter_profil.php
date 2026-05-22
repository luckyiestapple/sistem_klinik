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

  <div class="row">
    <div class="col-md-8 col-12">
      <!-- Card Edit Profil -->
      <div class="card">
        <div class="card-header"><h4 class="card-title text-bold-600">Update Profil Dokter</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('dokter/profil/update') ?>" method="POST">
              <?= csrf_field() ?>
              
              <h5 class="form-section text-info"><i class="la la-user"></i> Data Pribadi & STR</h5>
              <div class="row">
                <div class="col-md-6 col-12 form-group">
                  <label>Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama" class="form-control" value="<?= esc($dokter['nama']) ?>" required>
                </div>
                <div class="col-md-6 col-12 form-group">
                  <label>Poli Spesialisasi (Hanya dibaca)</label>
                  <input type="text" class="form-control" value="Poli <?= esc($dokter['spesialisasi']) ?>" readonly>
                </div>
                <div class="col-md-6 col-12 form-group">
                  <label>No. SIP / STR (Nomor Surat Izin)</label>
                  <input type="text" name="sip_str" class="form-control" value="<?= esc($dokter['sip_str'] ?? '') ?>">
                </div>
                <div class="col-md-6 col-12 form-group">
                  <label>No. Telepon / HP <span class="text-danger">*</span></label>
                  <input type="text" name="no_telp" class="form-control" value="<?= esc($dokter['no_telp'] ?? '') ?>" required>
                </div>
                <div class="col-12 form-group">
                  <label>Email Korespodensi</label>
                  <input type="email" name="email" class="form-control" value="<?= esc($dokter['email'] ?? '') ?>">
                </div>
                <div class="col-12 form-group">
                  <label>Alamat Lengkap Tempat Tinggal</label>
                  <textarea name="alamat" class="form-control" rows="2"><?= esc($dokter['alamat'] ?? '') ?></textarea>
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-clock-o"></i> Jadwal Praktik Mandiri</h5>
              <div class="row">
                <div class="col-md-6 col-12 form-group">
                  <label>Hari Praktik</label>
                  <input type="text" name="hari_praktek" class="form-control" placeholder="Contoh: Senin - Jumat" value="<?= esc($dokter['hari_praktek'] ?? '') ?>">
                </div>
                <div class="col-md-6 col-12 form-group">
                  <label>Jam Praktik</label>
                  <input type="text" name="jam_praktek" class="form-control" placeholder="Contoh: 08:00 - 15:00" value="<?= esc($dokter['jam_praktek'] ?? '') ?>">
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-key"></i> Keamanan & Ganti Password</h5>
              <div class="row">
                <div class="col-md-6 col-12 form-group">
                  <label>Username Login (Hanya dibaca)</label>
                  <input type="text" class="form-control" value="<?= esc($user['username'] ?? '') ?>" readonly>
                </div>
                <div class="col-md-6 col-12 form-group">
                  <label>Password Baru (Kosongkan jika tidak diganti)</label>
                  <input type="password" name="password" class="form-control" placeholder="Password minimal 6 karakter">
                </div>
              </div>

              <div class="form-group mt-3 border-top pt-3">
                <button type="submit" class="btn btn-warning text-white font-weight-bold">
                  <i class="la la-save"></i> Perbarui Profil & Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Profil Card Info -->
    <div class="col-md-4 col-12">
      <div class="card bg-info text-white text-center p-3 box-shadow-2">
        <div class="card-body">
          <div class="avatar avatar-xl mb-2">
            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($dokter['nama']) ?>" class="rounded-circle bg-white img-thumbnail" style="width: 100px; height: 100px;">
          </div>
          <h4 class="text-white text-bold-600 mt-2"><?= esc($dokter['nama']) ?></h4>
          <p class="text-white opacity-8">Spesialisasi Poli: <strong><?= esc($dokter['spesialisasi']) ?></strong></p>
          <div class="mt-3 p-2 bg-light text-dark rounded text-left font-small-3">
            <strong>ID Dokter:</strong> <?= esc($dokter['id_dokter']) ?><br>
            <strong>Jadwal:</strong> <?= esc($dokter['hari_praktek'] ?: 'Belum diisi') ?> (<?= esc($dokter['jam_praktek'] ?: '-') ?>)
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
