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
                <h3 class="card-title">Data Jurusan</h3>

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
              <?= session()->getFlashData('pesan'); ?>

                <?php if (validation_errors()) { ?>
                    <div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert">&times;</button>
                      <h5><i class="icon fas fa-exclamation-triangle"></i>
                        <?= validation_list_errors(); ?>
                      </h5>
                    </div>
                  <?php } ?>
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-jurusan">
                <i class="fas fa-plus nav-icon"></i> Tambah
              </button>
              <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th width='5%'>No</th>
                      <th width='10%'>Kode Jurusan</th>
                      <th>Nama Jurusan</th>
                      <th width='12%' class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $nom=1; foreach ($data as $dt) { 
                    ?>
                    <tr>
                      <td><?= $nom++ ?></td>
                      <td><?= $dt['kode_jur'] ?></td>
                      <td><?= $dt['jurusan'] ?></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-warning edit-data" data-toggle="modal" 
                          data-target="#modal-editjurusan"
                          data-kode_jur="<?= $dt['kode_jur'] ?>" 
                          data-jurusan="<?= $dt['jurusan'] ?>">
                          <i class="fas fa-edit"></i>
                        </button>

                        <button class="btn btn-sm btn-danger hapus-data" data-toggle="modal"
                          data-target="#modal-hapusjurusan"
                          data-kode_jur="<?= $dt['kode_jur'] ?>">
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
        <div class="modal fade" id="modal-jurusan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Input Data Jurusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?= form_open('/simpan') ?>
              <div class="modal-body">
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-4 col-form-label">Kode Jurusan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="kode_jur" placeholder="Kode Jurusan">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputEmail3" class="col-sm-4 col-form-label">Nama Jurusan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="jurusan" placeholder="Nama Jurusan">
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
              </div>
              <?= form_close() ?>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal-editjurusan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Data Jurusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?= form_open('/updatedatajurusan') ?>
              <div class="modal-body">
                <div class="form-group row">
                  <label for="inputkode" class="col-sm-4 col-form-label">Kode Jurusan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="kode_jur" name="kode_jur" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputjurusan" class="col-sm-4 col-form-label">Nama Jurusan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Nama Jurusan">
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
          
        <div class="modal fade" id="modal-hapusjurusan">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Hapus Data Jurusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?= form_open('/hapusdatajurusan') ?>
              <div class="modal-body">
                <input type="hidden" class="form-control" id="kode_jurx" name="kode_jur" readonly>
                <p>Apakah Anda Yakin Ingin Menghapus Data Jurusan Ini?</p>
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
<!-- ./wrapper -->
<?= $this->endSection() ?>

<?= $this->section('script'); ?>
  <script>
    $(document).on("click", ".edit-data", function(){
      var Kode = $(this).data('kode_jur');
      var Jur = $(this).data('jurusan');
      $(".modal-body #kode_jur").val(Kode);
      $(".modal-body #jurusan").val(Jur);
    });

    $(document).on("click", ".hapus-data", function(){
      var Kode = $(this).data('kode_jur');
      $(".modal-body #kode_jurx").val(Kode);
    });
  </script>
<?= $this->endSection() ?>