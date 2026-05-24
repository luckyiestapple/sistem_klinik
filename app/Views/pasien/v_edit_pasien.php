<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Edit Data Pasien</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('pasien') ?>">Pasien</a></li>
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
        <div class="card-header"><h4 class="card-title">Form Edit Data Pasien: <?= esc($pasien['nama']) ?></h4></div>
        <div class="card-content">
          <div class="card-body">
            <form action="<?= base_url('pasien/update/'.$pasien['id_pasien']) ?>" method="POST">
              <?= csrf_field() ?>
              
              <!-- Bagian 1: Data Identitas Diri -->
              <h5 class="form-section text-info"><i class="la la-user"></i> 1. Identitas Diri</h5>
              
              <div class="row mb-3 align-items-center bg-light p-2 rounded mx-1">
                <div class="col-md-2 col-12 text-center">
                  <?php 
                  if (!empty($pasien['foto'])) {
                      $avatarUrl = base_url('uploads/profile/' . $pasien['foto']);
                  } else {
                      $avatarUrl = 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . urlencode($pasien['nama'] ?? 'Pasien');
                  }
                  ?>
                  <img src="<?= $avatarUrl ?>" class="rounded bg-white img-thumbnail" style="width: 80px; height: 80px; object-fit: cover; aspect-ratio: 1/1; border-radius: 12px;">
                </div>
                <div class="col-md-10 col-12 text-center text-md-left">
                  <h6 class="text-bold-600 mb-0">Foto Profil Pasien</h6>
                  <?php if (!empty($pasien['foto'])): ?>
                    <p class="text-muted font-small-3 mb-1">Foto ini diunggah oleh pasien pada <?= date('d M Y H:i', strtotime($pasien['foto_updated_at'])) ?></p>
                    <a href="<?= base_url('pasien/reset_foto/' . $pasien['id_pasien']) ?>" class="btn btn-danger btn-sm font-weight-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus/reset foto profil pasien ini? Tindakan ini akan mengizinkan pasien untuk mengunggah foto baru.')">
                      <i class="la la-trash"></i> Reset Foto Profil (Izinkan Unggah Ulang)
                    </a>
                  <?php else: ?>
                    <p class="text-muted font-small-3 mb-0">Pasien belum mengunggah foto profil (menggunakan avatar default).</p>
                  <?php endif; ?>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_pasien" class="form-control" value="<?= esc($pasien['nama']) ?>" required>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-control" required>
                      <option value="L" <?= $pasien['jk'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                      <option value="P" <?= $pasien['jk'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= $pasien['tgl_lahir'] ?? '' ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. Telepon / HP</label>
                    <input type="text" name="no_telp" class="form-control" value="<?= esc($pasien['no_telp'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= esc($pasien['alamat'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>

              <!-- Bagian 2: Informasi Medis -->
              <h5 class="form-section text-info mt-3"><i class="la la-heartbeat"></i> 2. Informasi Medis & Alergi</h5>
              <div class="row">
                <div class="col-md-4 col-12">
                  <div class="form-group">
                    <label>Golongan Darah</label>
                    <select name="gol_darah" class="form-control">
                      <option value="">-- Pilih --</option>
                      <option value="A" <?= $pasien['gol_darah'] === 'A' ? 'selected' : '' ?>>A</option>
                      <option value="B" <?= $pasien['gol_darah'] === 'B' ? 'selected' : '' ?>>B</option>
                      <option value="AB" <?= $pasien['gol_darah'] === 'AB' ? 'selected' : '' ?>>AB</option>
                      <option value="O" <?= $pasien['gol_darah'] === 'O' ? 'selected' : '' ?>>O</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-8 col-12">
                  <div class="form-group">
                    <label>Alergi Obat (Kosongkan jika tidak ada)</label>
                    <input type="text" name="alergi_obat" class="form-control" value="<?= esc($pasien['alergi_obat'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label>Riwayat Penyakit Penting</label>
                    <textarea name="riwayat_penyakit" class="form-control" rows="2"><?= esc($pasien['riwayat_penyakit'] ?? '') ?></textarea>
                  </div>
                </div>
              </div>

              <!-- Bagian 3: Data BPJS Kesehatan -->
              <h5 class="form-section text-info mt-3"><i class="la la-credit-card"></i> 3. BPJS Kesehatan</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nomor BPJS</label>
                    <input type="text" name="no_bpjs" class="form-control" value="<?= esc($pasien['no_bpjs'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Status Kepesertaan BPJS</label>
                    <select name="status_bpjs" class="form-control">
                      <option value="Tidak Aktif" <?= $pasien['status_bpjs'] === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif / Non-BPJS</option>
                      <option value="Aktif" <?= $pasien['status_bpjs'] === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Faskes Tingkat Pertama (FKTP)</label>
                    <input type="text" name="faskes" class="form-control" value="<?= esc($pasien['faskes'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Kelas Rawat</label>
                    <select name="kelas_rawat" class="form-control">
                      <option value="">-- Pilih Kelas --</option>
                      <option value="Kelas 1" <?= $pasien['kelas_rawat'] === 'Kelas 1' ? 'selected' : '' ?>>Kelas 1</option>
                      <option value="Kelas 2" <?= $pasien['kelas_rawat'] === 'Kelas 2' ? 'selected' : '' ?>>Kelas 2</option>
                      <option value="Kelas 3" <?= $pasien['kelas_rawat'] === 'Kelas 3' ? 'selected' : '' ?>>Kelas 3</option>
                    </select>
                  </div>
                </div>
              </div>

              <!-- Bagian 4: Kontak Darurat -->
              <h5 class="form-section text-info mt-3"><i class="la la-phone-square"></i> 4. Kontak Darurat</h5>
              <div class="row">
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>Nama Kontak Darurat</label>
                    <input type="text" name="kontak_darurat_nama" class="form-control" value="<?= esc($pasien['kontak_darurat_nama'] ?? '') ?>">
                  </div>
                </div>
                <div class="col-md-6 col-12">
                  <div class="form-group">
                    <label>No. HP Kontak Darurat</label>
                    <input type="text" name="kontak_darurat_telp" class="form-control" value="<?= esc($pasien['kontak_darurat_telp'] ?? '') ?>">
                  </div>
                </div>
              </div>

              <!-- Bagian 5: Akun Login Pasien -->
              <h5 class="form-section text-info mt-3"><i class="la la-key"></i> 5. Akun Portal Pasien</h5>
              <?php if ($has_account): ?>
                <div class="alert alert-success font-small-3">
                  <i class="la la-check-circle"></i>
                  Pasien ini telah terdaftar memiliki akun portal pasien dengan Username: <strong><?= esc($account['username']) ?></strong>.
                </div>
              <?php else: ?>
                <div class="form-group">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="buat_akun" name="buat_akun" value="1" onchange="toggleAccountFields(this)">
                    <label class="custom-control-label font-weight-bold" for="buat_akun">Buatkan Akun Login Portal Pasien</label>
                  </div>
                </div>

                <div id="account_fields" style="display: none;" class="bg-light p-3 rounded mb-3 border">
                  <div class="row">
                    <div class="col-md-6 col-12">
                      <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username_field" class="form-control" placeholder="Username untuk portal pasien">
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
                <button type="submit" class="btn btn-warning text-white"><i class="la la-save"></i> Perbarui Data Pasien</button>
                <a href="<?= base_url('pasien') ?>" class="btn btn-secondary ml-1">Batal</a>
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
