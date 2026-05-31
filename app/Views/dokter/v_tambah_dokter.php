<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Tambah Dokter</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('dokter') ?>">Dokter</a></li>
      <li class="breadcrumb-item active">Tambah</li>
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
        <div class="card-header"><h4 class="card-title">Form Tambah Dokter Baru</h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('dokter/simpan') ?>" method="POST">
              <?= csrf_field() ?>
              
              <h5 class="form-section text-info"><i class="la la-user-md"></i> 1. Profil Dokter</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="nama_dokter" class="form-control" placeholder="dr. Nama Lengkap, Sp.X" value="<?= old('nama_dokter') ?>" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Spesialisasi <span class="text-danger">*</span></label>
                    <select name="spesialisasi" class="form-control" required>
                      <option value="">-- Pilih Spesialisasi --</option>
                      <option value="Umum" <?= old('spesialisasi') === 'Umum' ? 'selected' : '' ?>>Umum</option>
                      <option value="Anak" <?= old('spesialisasi') === 'Anak' ? 'selected' : '' ?>>Anak</option>
                      <option value="Gigi" <?= old('spesialisasi') === 'Gigi' ? 'selected' : '' ?>>Gigi</option>
                      <option value="Kandungan" <?= old('spesialisasi') === 'Kandungan' ? 'selected' : '' ?>>Kandungan</option>
                      <option value="Jantung" <?= old('spesialisasi') === 'Jantung' ? 'selected' : '' ?>>Jantung</option>
                      <option value="Kulit" <?= old('spesialisasi') === 'Kulit' ? 'selected' : '' ?>>Kulit</option>
                      <option value="Mata" <?= old('spesialisasi') === 'Mata' ? 'selected' : '' ?>>Mata</option>
                      <option value="THT" <?= old('spesialisasi') === 'THT' ? 'selected' : '' ?>>THT</option>
                      <option value="Ortopedi" <?= old('spesialisasi') === 'Ortopedi' ? 'selected' : '' ?>>Ortopedi</option>
                      <option value="Syaraf" <?= old('spesialisasi') === 'Syaraf' ? 'selected' : '' ?>>Syaraf</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. SIP / STR (Opsional)</label>
                    <input type="text" name="sip_str" class="form-control" placeholder="SIP.XXX.XXXXX" value="<?= old('sip_str') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Status Aktif</label>
                    <select name="status_aktif" class="form-control">
                      <option value="aktif" <?= old('status_aktif') === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                      <option value="nonaktif" <?= old('status_aktif') === 'nonaktif' ? 'selected' : '' ?>>Non-Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. Telepon / HP</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="08xxxxxxxxxx" value="<?= old('no_telp') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Email (Opsional)</label>
                    <input type="email" name="email" class="form-control" placeholder="dokter@klinik.com" value="<?= old('email') ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2" placeholder="Alamat lengkap dokter..."><?= old('alamat') ?></textarea>
                  </div>
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-clock-o"></i> 2. Jadwal Praktek Sederhana</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Hari Praktek</label>
                    <input type="text" name="hari_praktek" class="form-control" placeholder="Contoh: Senin - Jumat" value="<?= old('hari_praktek') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Jam Praktek</label>
                    <input type="text" name="jam_praktek" class="form-control" placeholder="Contoh: 08:00 - 14:00" value="<?= old('jam_praktek') ?>">
                  </div>
                </div>
              </div>

              <h5 class="form-section text-info mt-3"><i class="la la-key"></i> 3. Akun Login Dokter</h5>
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
                      <div class="input-group">
                        <input type="password" name="password" id="password_field" class="form-control" placeholder="Password min 6 karakter, angka, simbol" pattern="(?=.*\d)(?=.*[^a-zA-Z0-9]).{6,}" title="Minimal 6 karakter, mengandung angka, dan simbol">
                        <div class="input-group-append">
                          <span class="input-group-text" style="cursor: pointer;" onclick="const pf = document.getElementById('password_field'); const icon = this.querySelector('i'); if(pf.type === 'password') { pf.type = 'text'; icon.className = 'la la-eye-slash'; } else { pf.type = 'password'; icon.className = 'la la-eye'; }">
                            <i class="la la-eye"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group mt-3 border-top pt-3 d-flex" style="gap:10px;">
                <button type="submit" class="btn btn-primary"><i class="la la-save"></i> Simpan Dokter</button>
                <a href="<?= base_url('dokter') ?>" class="btn btn-secondary">Batal</a>
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
