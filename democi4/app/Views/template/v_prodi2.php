<?=  $this->extend ('template/template'); ?>
<?=  $this->section ('konten'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Informasi</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <!-- <li class="breadcrumb-item"><a href="#">Layout</a></li>
                <li class="breadcrumb-item active">Fixed Navbar Layout</li> -->
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-12">
                <!-- Default box -->
                <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Program Studi</h3>

                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                <?php
                    echo session()->getFlashdata('pesan');
                    if(validation_errors()){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">&times:</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i>
                        <?= validation_list_errors() ?> </h5>
                    </div>
                <?php }?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-prodi">
                    <i class="fas fa-plus nav-icon"></i> Tambah
                </button>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                        <th width='5%'>No</th>
                        <th width='15%'>Kode Prodi</th>
                        <th width='15%'>Kode Jurusan</th>
                        <th width='45%'>Nama Prodi</th>
                        <th width='20%' class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $nom=1; foreach ($data as $dt) { 
                        ?>
                        <tr>
                        <td><?= $nom++ ?></td>
                        <td><?= $dt['kode_prodi'] ?></td>
                        <td><?= $dt['kode_jur'] ?></td>
                        <td><?= $dt['prodi'] ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-warning edit-data" data-toggle="modal" 
                            data-target="#modal-editprodi"
                            data-kode_prodi="<?= $dt['kode_prodi'] ?>" 
                            data-kode_jur="<?= $dt['kode_jur'] ?>"
                            data-prodi="<?= $dt['prodi'] ?>">
                            <i class="fas fa-edit"></i>
                            </button>

                            <button class="btn btn-sm btn-danger hapus-data" data-toggle="modal"
                            data-target="#modal-hapusprodi"
                            data-kode_prodi="<?= $dt['kode_prodi'] ?>"
                            data-kode_jur="<?= $dt['kode_jur'] ?>"
                            data-prodi="<?= $dt['prodi'] ?>">
                            <i class="fas fa-trash"></i>
                            </button>
                        </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
                <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
            </div>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
            <div class="modal fade" id="modal-prodi">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Input Data Prodi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <?= form_open('/simpanprodi') ?>
                        <div class="modal-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Kode Prodi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="kode_prodi" placeholder="Kode Prodi">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Kode Jurusan</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="kode_jur" placeholder="Kode Jurusan">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Prodi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="prodi" placeholder="Nama Prodi">
                            </div>
                        </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-editprodi">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title">Edit Data Prodi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <?= form_open('/updatedataprodi') ?>
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="inputkode" class="col-sm-4 col-form-label">Kode Prodi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kode_prodi" name="kode_prodi" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputkode" class="col-sm-4 col-form-label">Kode Jurusan</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kode_jur" name="kode_jur" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="inputprodi" class="col-sm-4 col-form-label">Nama Prodi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Nama Prodi">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-warning"><i class="fa fa-save"></i> Update</button>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
            
            <div class="modal fade" id="modal-hapusprodi">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Data Prodi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('/hapusdataprodi') ?>
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="kode_prodix" name="kode_prodi" readonly>
                    <p>Apakah Anda Yakin Ingin Menghapus Data Prodi Ini?</p>
                </div>
                <div class="modal-footer justify-content-between">
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                </div>
                <?= form_close() ?>
                </div>

            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
<?= $this->endSection() ?>

<?= $this->section ('script') ?>
    <script>
        $(document).on("click", ".edit-data", function(){
        var Kode = $(this).data('kode_prodi');
        var Jur = $(this).data('kode_jur');
        var Prodi = $(this).data('prodi');
        $(".modal-body #kode_prodi").val(Kode);
        $(".modal-body #kode_jur").val(Jur);
        $(".modal-body #prodi").val(Prodi);
        });

        $(document).on("click", ".hapus-data", function(){
        var Kode = $(this).data('kode_prodi');
        $(".modal-body #kode_prodix").val(Kode);
        });
    </script>
<?= $this->endSection() ?>
