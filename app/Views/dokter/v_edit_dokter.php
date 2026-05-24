<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Dokter</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dokter') ?>">Dokter</a></li>
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
        <div class="card-header"><h4 class="card-title">Form Edit Dokter: <?= esc($dokter['nama']) ?></h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('dokter/update/'.$dokter['id_dokter']) ?>" method="POST">
              <?= csrf_field() ?>
              
              <h5 class="form-section text-info"><i class="la la-user-md"></i> 1. Profil Dokter</h5>
              
              <div class="row mb-3 align-items-center bg-light p-2 rounded mx-1">
                <div class="col-md-2 col-12 text-center">
                  <?php 
                  if (!empty($dokter['foto'])) {
                      $avatarUrl = base_url('uploads/profile/' . $dokter['foto']);
                  } else {
                      $avatarUrl = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($dokter['nama'] ?? 'Dokter');
                  }
                  ?>
                  <img src="<?= $avatarUrl ?>" class="rounded-circle bg-white img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; aspect-ratio: 1/1;">
                </div>
                <div class="col-md-10 col-12 text-center text-md-left">
                  <h6 class="text-bold-600 mb-0">Foto Profil Dokter</h6>
                  <?php if (!empty($dokter['foto'])): ?>
                    <p class="text-muted font-small-3 mb-1">Foto ini diunggah oleh dokter pada <?= date('d M Y H:i', strtotime($dokter['foto_updated_at'])) ?></p>
                    <a href="<?= base_url('dokter/reset_foto/' . $dokter['id_dokter']) ?>" class="btn btn-danger btn-sm font-weight-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus/reset foto profil dokter ini? Tindakan ini akan mengizinkan dokter untuk mengunggah foto baru.')">
                      <i class="la la-trash"></i> Reset Foto Profil (Izinkan Unggah Ulang)
                    </a>
                  <?php else: ?>
                    <p class="text-muted font-small-3 mb-0">Dokter belum mengunggah foto profil (menggunakan avatar default).</p>
                  <?php endif; ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dokter" class="form-control" value="<?= esc($dokter['nama']) ?>" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Spesialisasi <span class="text-danger">*</span></label>
                    <select name="spesialisasi" class="form-control" required>
                      <?php $specs = ['Umum','Anak','Gigi','Kandungan','Jantung','Kulit','Mata','THT','Ortopedi','Syaraf']; ?>
                      <?php foreach ($specs as $s): ?>
                      <option value="<?= $s ?>" <?= $dokter['spesialisasi'] === $s ? 'selected' : '' ?>><?= $s ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. SIP / STR (Opsional)</label>
                    <input type="text" name="sip_str" class="form-control" value="<?= esc($dokter['sip_str'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="status_aktif" class="form-control">
                      <option value="aktif" <?= ($dokter['status_aktif'] ?? 'aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= ($dokter['status_aktif'] ?? 'aktif') === 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. Telepon / HP</label>
                    <input type="text" name="no_telp" class="form-control" value="<?= esc($dokter['no_telp'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Email (Opsional)</label>
                    <input type="email" name="email" class="form-control" value="<?= esc($dokter['email'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= esc($dokter['alamat'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-clock-o"></i> 2. Jadwal Praktek Sederhana</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Hari Praktek</label>
                    <input type="text" name="hari_praktek" class="form-control" value="<?= esc($dokter['hari_praktek'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Jam Praktek</label>
                    <input type="text" name="jam_praktek" class="form-control" value="<?= esc($dokter['jam_praktek'] ?? '') ?>">
                  </div>
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-key"></i> 3. Akun Login Dokter</h5>
              <?php if ($has_account): ?>
                <div class="alert alert-success font-small-3">
                  <i class="la la-check-circle"></i>
                  Dokter ini telah terdaftar memiliki akun login Dokter dengan Username: <strong><?= esc($account['username']) ?></strong>.
                </div>
              <?php else: ?>
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="buat_akun" name="buat_akun" value="1" onchange="toggleAccountFields(this)">
                    <label class="custom-control-label font-weight-bold" for="buat_akun">Buatkan Akun Login Dokter</label>
                  </div>
                </div>

                <div id="account_fields" style="display: none;" class="bg-light p-3 rounded mb-3 border">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username_field" class="form-control" placeholder="Username untuk login dokter">
                      </div>
                    </div>
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label>Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password_field" class="form-control" placeholder="Password minimal 6 karakter">
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>

              <div class="form-group mt-3 border-top pt-3">
                <button type="submit" class="btn btn-warning text-white"><i class="la la-save"></i> Perbarui Dokter</button>
                <a href="<?= base_url('dokter') ?>" class="btn btn-secondary ml-1">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
function toggleAccountFields(checkbox) {
    var fields = document.getElementById('account_fields');
    var username = document.getElementById('username_field');
    var password = document.getElementById('password_field');
    if (checkbox.checked) {
        fields.style.display = 'block';
        username.required = true;
        password.required = true;
    } else {
        fields.style.display = 'none';
        username.required = false;
        password.required = false;
    }
}
</script>
<?= $this->endSection() ?>
