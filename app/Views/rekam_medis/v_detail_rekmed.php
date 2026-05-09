<?= $this->extend('templates/template') ?>
<?= $this->section('konten') ?>

<div class="content-header row">
  <div class="content-header-left col-12 mb-2">
    <h3 class="content-header-title">Detail Rekam Medis</h3>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('rekam_medis') ?>">Rekam Medis</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </div>
</div>

<div class="content-body">
  <div class="row">
    <div class="col-md-9 offset-md-1">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Rincian Rekam Medis</h4>
          <div class="heading-elements">
            <a href="<?= base_url('resep/tambah/'.$rekam_medis['id_rekam_medis']) ?>"
               class="btn btn-success btn-sm">
              <i class="la la-clipboard"></i> Buat Resep
            </a>
            <a href="<?= base_url('rekam_medis') ?>" class="btn btn-secondary btn-sm ml-1">Kembali</a>
          </div>
        </div>
        <div class="card-content">
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <table class="table table-borderless">
                  <tr>
                    <th width="150">Pasien</th>
                    <td>: <?= esc($rekam_medis['nama_pasien']) ?></td>
                  </tr>
                  <tr>
                    <th>Dokter</th>
                    <td>: <?= esc($rekam_medis['nama_dokter']) ?></td>
                  </tr>
                  <tr>
                    <th>Spesialisasi</th>
                    <td>: <span class="badge badge-info"><?= esc($rekam_medis['spesialisasi']) ?></span></td>
                  </tr>
                  <tr>
                    <th>Tgl Periksa</th>
                    <td>: <?= date('d F Y', strtotime($rekam_medis['tgl_periksa'])) ?></td>
                  </tr>

                </table>
              </div>
            </div>
            <hr>
            <div class="form-group">
              <label class="font-weight-bold">Keluhan / Gejala</label>
              <div class="p-2 bg-light rounded"><?= nl2br(esc($rekam_medis['keluhan'])) ?></div>
            </div>
            <div class="form-group">
              <label class="font-weight-bold">Hasil Pemeriksaan / Diagnosa</label>
              <div class="p-2 bg-light rounded">
                <?= $rekam_medis['diagnosa']
                    ? nl2br(esc($rekam_medis['diagnosa']))
                    : '<em class="text-muted">Belum diisi.</em>' ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

