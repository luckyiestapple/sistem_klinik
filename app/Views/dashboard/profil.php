<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
    .rounded-2xl { border-radius: 1rem !important; }
    .card-modern {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .text-teal { color: #0d9488 !important; }
    .bg-teal-light { background-color: #ccfbf1 !important; }
    .bg-teal { background-color: #0d9488 !important; color: white !important; }
    .profile-header {
        background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%);
        color: white;
        border-radius: 1rem 1rem 0 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <div class="row">
        <div class="col-lg-8 col-md-10 col-12 mx-auto">
            <div class="card card-modern rounded-2xl">
                <div class="profile-header p-4 text-center">
                    <div class="mb-2">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($pasien['nama']) ?>" alt="Avatar" class="rounded-circle bg-white" style="width: 100px; height: 100px; padding: 5px;">
                    </div>
                    <h3 class="text-white font-weight-bold mb-1"><?= esc($pasien['nama']) ?></h3>
                    <span class="badge badge-light text-teal font-weight-bold px-3 py-2 rounded-pill">ID Pasien: <?= esc($pasien['id_pasien']) ?></span>
                </div>
                <div class="card-body p-4">
                    <h5 class="font-weight-bold mb-3 border-bottom pb-2"><i class="ft-user"></i> Data Pribadi Pasien</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Nama Lengkap</div>
                        <div class="col-sm-8 text-dark font-weight-bold"><?= esc($pasien['nama']) ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Jenis Kelamin</div>
                        <div class="col-sm-8 text-dark"><?= $pasien['jk'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Tanggal Lahir</div>
                        <div class="col-sm-8 text-dark"><?= date('d F Y', strtotime($pasien['tgl_lahir'])) ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">No. Telepon / HP</div>
                        <div class="col-sm-8 text-dark"><?= esc($pasien['no_telp']) ?></div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Alamat</div>
                        <div class="col-sm-8 text-dark"><?= esc($pasien['alamat']) ?></div>
                    </div>

                    <h5 class="font-weight-bold mb-3 border-bottom pb-2 mt-4"><i class="ft-shield"></i> Data Kepesertaan JKN / BPJS</h5>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Status Kepesertaan</div>
                        <div class="col-sm-8"><span class="badge badge-success px-2 py-1">Aktif</span></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Faskes Tingkat I</div>
                        <div class="col-sm-8 text-dark">Klinik Utama Sehat</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Kelas Rawat</div>
                        <div class="col-sm-8 text-dark">Kelas I</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
