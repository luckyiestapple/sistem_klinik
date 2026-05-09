<?= $this->extend('templates/template') ?>

<?= $this->section('konten') ?>
<div class="content-header row mb-2">
  <div class="col-12">
    <h2 class="content-header-title">Dashboard Dokter</h2>
    <p>Halo, dr. <strong><?= session()->get('username'); ?></strong>. Berikut jadwal dan antrian Anda.</p>
  </div>
</div>
<div class="content-body">
  <div class="row match-height">
    <!-- Appointment Table -->
    <div id="recent-appointments" class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Antrian Pemeriksaan (Kunjungan Terbaru)</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content mt-1">
          <div class="table-responsive">
            <table id="recent-orders-doctors" class="table table-hover table-xl mb-0">
              <thead>
                <tr>
                  <th class="border-top-0">Pasien</th>
                  <th class="border-top-0">Keluhan / Diagnosa Awal</th>
                  <th class="border-top-0">Waktu</th>
                  <th class="border-top-0">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr class="pull-up">
                  <td class="text-truncate">
                    <span class="avatar avatar-sm avatar-online rounded-circle"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-4.png') ?>" alt="avatar"><i></i></span>
                    Maman Suherman
                  </td>
                  <td class="text-truncate p-1">Demam dan Pusing</td>
                  <td class="text-truncate">Hari ini, 09:00 A.M.</td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-info round">Mulai Periksa</button>
                  </td>
                </tr>
                <tr class="pull-up">
                  <td class="text-truncate">
                    <span class="avatar avatar-sm avatar-busy rounded-circle"><img src="<?= base_url('app-assets/images/portrait/small/avatar-s-11.png') ?>" alt="avatar"><i></i></span>
                    Siti Aminah
                  </td>
                  <td class="text-truncate p-1">Sakit Perut</td>
                  <td class="text-truncate">Hari ini, 09:30 A.M.</td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-info round">Mulai Periksa</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
