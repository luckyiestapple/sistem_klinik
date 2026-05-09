<?= $this->extend('templates/template') ?>

<?= $this->section('konten') ?>
<div class="content-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h4 class="card-title text-white">Dashboard Pasien</h4>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <h4 class="card-text">Halo Pasien <strong><?= session()->get('username'); ?></strong>,</h4>
                        <p>Selamat datang di portal informasi Sistem Klinik. Di sini Anda bisa melihat rekam medis dan resep obat Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
