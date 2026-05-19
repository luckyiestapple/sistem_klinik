<?= $this->extend('templates/template') ?>

<?= $this->section('css') ?>
<style>
    .dashboard-pasien {
        font-family: 'Inter', sans-serif;
        color: #334155;
    }
    .rounded-2xl { border-radius: 1rem !important; }
    .card-modern {
        border: none;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .text-teal { color: #0d9488 !important; }
    .bg-teal-light { background-color: #ccfbf1 !important; }
    .bg-teal { background-color: #0d9488 !important; color: white !important; }
    .btn-teal { background-color: #0d9488 !important; border-color: #0d9488 !important; color: white !important; }
    .btn-teal:hover { background-color: #0f766e !important; color: white !important; }
    .btn-outline-teal { color: #0d9488 !important; border-color: #0d9488 !important; }
    .btn-outline-teal:hover { background-color: #0d9488 !important; color: white !important; }
    
    .text-blue { color: #2563eb !important; }
    .bg-blue-light { background-color: #dbeafe !important; }
    
    .text-orange { color: #ea580c !important; }
    .bg-orange-light { background-color: #ffedd5 !important; }
    
    .icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 1.5rem;
    }
    
    .highlight-card {
        background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%);
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('konten') ?>
<div class="content-body dashboard-pasien">
    <!-- Header / Sapaan -->
    <div class="row mb-3 mt-2">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h2 class="font-weight-bold mb-0">Halo, Budi Santoso 👋</h2>
                <p class="text-muted">Semoga hari Anda menyenangkan dan sehat selalu.</p>
            </div>
        </div>
    </div>

    <!-- Health Summary Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-orange-light text-orange mr-3">
                            <i class="ft-heart"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Tekanan Darah</p>
                            <h4 class="mb-0 font-weight-bold">120/80 <small>mmHg</small></h4>
                        </div>
                    </div>
                    <div class="mt-2 text-success font-small-2"><i class="ft-check-circle"></i> Normal (terakhir 2 hari lalu)</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-blue-light text-blue mr-3">
                            <i class="ft-droplet"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Gula Darah (Puasa)</p>
                            <h4 class="mb-0 font-weight-bold">95 <small>mg/dL</small></h4>
                        </div>
                    </div>
                    <div class="mt-2 text-success font-small-2"><i class="ft-check-circle"></i> Normal (terakhir 1 bln lalu)</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-teal-light text-teal mr-3">
                            <i class="ft-shield"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Status JKN/BPJS</p>
                            <h4 class="mb-0 font-weight-bold text-success">AKTIF</h4>
                        </div>
                    </div>
                    <div class="mt-2 text-muted font-small-2">Kelas 1 - Klinik Sehat Bersama</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-teal text-white mr-3">
                            <i class="ft-star"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted font-small-3">Program Prolanis</p>
                            <h4 class="mb-0 font-weight-bold">Diabetes</h4>
                        </div>
                    </div>
                    <div class="mt-2 text-info font-small-2"><i class="ft-info"></i> Skrining berikutnya: 10 Jun</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Highlight Card & Resep -->
        <div class="col-lg-8 col-12">
            <!-- Highlight Card: Jadwal Kontrol -->
            <div class="card card-modern highlight-card rounded-2xl mb-4">
                <div class="card-body p-4">
                    <h5 class="text-white mb-3"><i class="ft-calendar"></i> Jadwal Kontrol Berikutnya</h5>
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="text-white font-weight-bold">Dr. Andini, Sp.PD</h3>
                            <p class="mb-1"><i class="ft-map-pin"></i> RS. Siloam - Poli Penyakit Dalam</p>
                            <p class="mb-0"><i class="ft-clock"></i> 25 Mei 2026 • 09:00 - 11:00 WIB</p>
                        </div>
                        <div class="col-md-4 text-center mt-3 mt-md-0">
                            <div class="bg-white text-teal rounded p-2 mb-2 d-inline-block">
                                <span class="d-block font-small-2 font-weight-bold text-uppercase">No. Antrean</span>
                                <h2 class="mb-0 font-weight-bold">A12</h2>
                            </div>
                            <button class="btn btn-light btn-block btn-sm rounded-pill font-weight-bold">Lihat Tiket Antrean</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Prescriptions -->
            <h5 class="font-weight-bold mb-3 mt-2">Obat & Resep Aktif</h5>
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush rounded-2xl">
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-teal-light text-teal mr-3" style="width:40px;height:40px;font-size:1.2rem;">
                                    <i class="ft-box"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold">Metformin 500mg</h6>
                                    <span class="text-muted font-small-3">3x Sehari sesudah makan</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-warning">Sisa 5 hari</span>
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-blue-light text-blue mr-3" style="width:40px;height:40px;font-size:1.2rem;">
                                    <i class="ft-box"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 font-weight-bold">Amlodipine 10mg</h6>
                                    <span class="text-muted font-small-3">1x Sehari pagi hari</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="badge badge-warning">Sisa 5 hari</span>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-white border-top-0 text-center rounded-2xl pb-3">
                    <button class="btn btn-outline-teal btn-sm rounded-pill px-3">Lihat Semua Resep</button>
                    <button class="btn btn-teal btn-sm rounded-pill px-3 ml-2">Minta Obat Ulang</button>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-lg-4 col-12">
            <!-- Self Screening -->
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body text-center p-4">
                    <div class="icon-box bg-teal-light text-teal mx-auto mb-3" style="width:60px;height:60px;font-size:2rem;">
                        <i class="ft-activity"></i>
                    </div>
                    <h5 class="font-weight-bold">Skrining Riwayat Kesehatan</h5>
                    <p class="text-muted font-small-3">Cegah penyakit sejak dini dengan mengetahui risiko kesehatan Anda.</p>
                    <button class="btn btn-teal btn-block rounded-pill font-weight-bold mb-3">Cek Risiko Kesehatan Mandiri</button>
                    <small class="text-success"><i class="ft-check-circle"></i> Skrining terakhir: 3 bulan lalu (Risiko Rendah)</small>
                </div>
            </div>

            <!-- Health Tips -->
            <div class="card card-modern rounded-2xl mb-4">
                <div class="card-body">
                    <h6 class="font-weight-bold mb-3"><i class="ft-sun text-warning"></i> Tips Kesehatan Hari Ini</h6>
                    <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Healthy Food" class="img-fluid rounded mb-3" style="height:120px;width:100%;object-fit:cover;border-radius:0.75rem;">
                    <h6 class="font-weight-bold">Menjaga Kadar Gula Darah Stabil</h6>
                    <p class="text-muted font-small-3 mb-2">Kurangi konsumsi karbohidrat sederhana dan perbanyak serat dari sayuran hijau...</p>
                    <a href="#" class="text-teal font-small-3 font-weight-bold">Baca selengkapnya &rarr;</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-6 pr-2">
                    <button class="btn btn-outline-primary btn-block py-3 card-modern" style="border-radius: 1rem; border-color:#dbeafe; background-color:white;">
                        <i class="ft-message-circle d-block mb-1 text-primary" style="font-size:1.5rem;"></i>
                        <span class="font-small-2 text-dark font-weight-bold">Chat Dokter</span>
                    </button>
                </div>
                <div class="col-6 pl-2">
                    <button class="btn btn-outline-danger btn-block py-3 card-modern" style="border-radius: 1rem; border-color:#fee2e2; background-color:white;">
                        <i class="ft-phone-call d-block mb-1 text-danger" style="font-size:1.5rem;"></i>
                        <span class="font-small-2 text-dark font-weight-bold">Darurat</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
