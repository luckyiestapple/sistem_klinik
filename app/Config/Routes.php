<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Landing Page / Main ───────────────────────────────────
$routes->get('/',       'Home::index');

// ── Auth ──────────────────────────────────────────────────
$routes->get('/login',  'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');
$routes->get('/lupa_password', 'Auth::lupaPassword');
$routes->post('/lupa_password', 'Auth::processLupaPassword');

// ── Dashboard ─────────────────────────────────────────────
// (Dipindahkan ke group filter masing-masing)

// ── Admin-only Routes (Level 1) ───────────────────────────
$routes->group('', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Data Dokter
    $routes->get('/dokter',            'Dokter::index');
    $routes->get('/dokter/tambah',     'Dokter::tambah');
    $routes->post('/dokter/simpan',    'Dokter::simpan');
    $routes->get('/dokter/edit/(:any)', 'Dokter::edit/$1');
    $routes->post('/dokter/update/(:any)', 'Dokter::update/$1');
    $routes->get('/dokter/hapus/(:any)', 'Dokter::hapus/$1');

    // Data Pasien
    $routes->get('/pasien',            'Pasien::index');
    $routes->get('/pasien/tambah',     'Pasien::tambah');
    $routes->post('/pasien/simpan',    'Pasien::simpan');
    $routes->get('/pasien/edit/(:any)', 'Pasien::edit/$1');
    $routes->post('/pasien/update/(:any)', 'Pasien::update/$1');
    $routes->get('/pasien/hapus/(:any)', 'Pasien::hapus/$1');

    // Data Obat
    $routes->get('/obat',            'Obat::index');
    $routes->get('/obat/tambah',     'Obat::tambah');
    $routes->post('/obat/simpan',    'Obat::simpan');
    $routes->get('/obat/edit/(:any)', 'Obat::edit/$1');
    $routes->post('/obat/update/(:any)', 'Obat::update/$1');
    $routes->get('/obat/hapus/(:any)', 'Obat::hapus/$1');

    // Antrian (Admin)
    $routes->get('/admin/antrian', 'Dashboard::antrian');
    $routes->post('/admin/antrian/update_status/(:any)', 'Dashboard::updateAntrianStatus/$1');
});

// ── Dokter-only Routes (Level 4) ──────────────────────────
$routes->group('', ['filter' => 'dokterAuth'], function($routes) {
    $routes->get('/dashboard_dokter', 'DashboardDokter::index');
    $routes->get('/dokter/antrian', 'DashboardDokter::antrian');
    $routes->post('/dokter/antrian/panggil/(:any)', 'DashboardDokter::panggilAntrian/$1');
    $routes->post('/dokter/antrian/selesai/(:any)', 'DashboardDokter::selesaiAntrian/$1');
    $routes->get('/dokter/profil', 'DashboardDokter::profil');
    $routes->post('/dokter/profil/update', 'DashboardDokter::profilUpdate');
    $routes->post('/dokter/profil/update_foto', 'DashboardDokter::updateFoto');

    // Rekam Medis (Input/Edit hanya Dokter)
    $routes->get('/rekam_medis/tambah',       'RekamMedis::tambah');
    $routes->post('/rekam_medis/simpan',      'RekamMedis::simpan');
    $routes->get('/rekam_medis/edit/(:any)',   'RekamMedis::edit/$1');
    $routes->post('/rekam_medis/update/(:any)', 'RekamMedis::update/$1');

    // Resep (Input hanya Dokter)
    $routes->get('/resep/tambah/(:any)',        'Resep::tambah/$1');
    $routes->post('/resep/simpan',             'Resep::simpan');
});

// ── Pasien-only Routes (Level 2) ──────────────────────────
$routes->group('', ['filter' => 'pasienAuth'], function($routes) {
    $routes->get('/dashboard_pasien', 'DashboardPasien::index');
    $routes->get('/profil_pasien', 'DashboardPasien::profil');
    $routes->post('/profil_pasien/update_info', 'DashboardPasien::updateInfo');
    $routes->post('/profil_pasien/update_password', 'DashboardPasien::updatePassword');
    $routes->post('/profil_pasien/update_foto', 'DashboardPasien::updateFoto');
    $routes->get('/antrian', 'DashboardPasien::antrian');
    $routes->post('/antrian/simpan', 'DashboardPasien::simpanAntrian');
    $routes->get('/resep_pasien', 'DashboardPasien::resep');
    $routes->get('/resep_pasien/detail/(:any)', 'DashboardPasien::resepDetail/$1');
    $routes->post('/resep_pasien/konfirmasi/(:any)', 'DashboardPasien::konfirmasiPengambilan/$1');
    $routes->get('/rekam_medis_pasien', 'DashboardPasien::rekamMedis');
    $routes->get('/rekam_medis_pasien/detail/(:any)', 'DashboardPasien::rekamMedisDetail/$1');
});

// ── Shared (Admin & Dokter - Level 1 & 3) ──────────────────
$routes->group('', ['filter' => 'adminOrDokterAuth'], function($routes) {
    // Rekam Medis (Lihat & Hapus untuk Admin+Dokter)
    $routes->get('/rekam_medis',              'RekamMedis::index');
    $routes->get('/rekam_medis/detail/(:any)', 'RekamMedis::detail/$1');
    $routes->get('/rekam_medis/hapus/(:any)', 'RekamMedis::hapus/$1');

    // Resep (Lihat & Proses untuk Admin+Dokter)
    $routes->get('/resep',                     'Resep::index');
    $routes->get('/resep/detail/(:any)',        'Resep::detail/$1');
    $routes->post('/resep/update_status/(:any)', 'Resep::updateStatus/$1');
});
