<?= $this->extend('template/template'); ?> <?= $this->section('konten'); ?>

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">Dashboard Admin & Apoteker</h3>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="med ia d-flex">
                                <div class="media-body text-left">
                                    <h3 class="info"><?= $total_pasien ?></h3>
                                    <h6>Total Pasien</h6>
                                </div>
                                <div><i class="ft-users info font-large-2 float-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="warning"><?= $total_obat ?></h3>
                                    <h6>Stok Obat Rendah</h6>
                                </div>
                                <div><i class="ft-package warning font-large-2 float-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="success"><?= $total_resep ?></h3>
                                    <h6>Resep Selesai</h6>
                                </div>
                                <div><i class="ft-file-text success font-large-2 float-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="danger">Rp <?= $pendapatan ?></h3>
                                    <h6>Pendapatan Hari Ini</h6>
                                </div>
                                <div><i class="ft-trending-up danger font-large-2 float-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Manajemen Stok Obat</h4>
                        <div class="heading-elements">
                            <button class="btn btn-primary btn-sm"><i class="ft-plus"></i> Tambah Obat</button>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Kode Obat</th>
                                        <th>Nama Obat</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>OBT-001</td>
                                        <td>Paracetamol 500mg</td>
                                        <td>Analgesik</td>
                                        <td><span class="badge badge-success">100 Box</span></td>
                                        <td>Rp 15.000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-warning"><i class="ft-edit"></i></button>
                                            <button class="btn btn-sm btn-outline-danger"><i class="ft-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-body text-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-separate pagination-round pagination-flat justify-content-center">
                                    <li class="page-item"><a class="page-link" href="#">Prev</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>  