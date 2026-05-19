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

// ── Dashboard ─────────────────────────────────────────────
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/dashboard_pasien', 'DashboardPasien::index');
$routes->get('/dashboard_dokter', 'DashboardDokter::index');

// ── Data Dokter ───────────────────────────────────────────
$routes->get('/dokter',            'Dokter::index');
$routes->get('/dokter/tambah',     'Dokter::tambah');
$routes->post('/dokter/simpan',    'Dokter::simpan');
$routes->get('/dokter/edit/(:any)', 'Dokter::edit/$1');
$routes->post('/dokter/update/(:any)', 'Dokter::update/$1');
$routes->get('/dokter/hapus/(:any)', 'Dokter::hapus/$1');

// ── Data Pasien ───────────────────────────────────────────
$routes->get('/pasien',            'Pasien::index');
$routes->get('/pasien/tambah',     'Pasien::tambah');
$routes->post('/pasien/simpan',    'Pasien::simpan');
$routes->get('/pasien/edit/(:any)', 'Pasien::edit/$1');
$routes->post('/pasien/update/(:any)', 'Pasien::update/$1');
$routes->get('/pasien/hapus/(:any)', 'Pasien::hapus/$1');

// ── Rekam Medis ───────────────────────────────────────────
$routes->get('/rekam_medis',              'RekamMedis::index');
$routes->get('/rekam_medis/tambah',       'RekamMedis::tambah');
$routes->post('/rekam_medis/simpan',      'RekamMedis::simpan');
$routes->get('/rekam_medis/detail/(:any)', 'RekamMedis::detail/$1');
$routes->get('/rekam_medis/edit/(:any)',   'RekamMedis::edit/$1');
$routes->post('/rekam_medis/update/(:any)', 'RekamMedis::update/$1');
$routes->get('/rekam_medis/hapus/(:any)', 'RekamMedis::hapus/$1');

// ── Resep ─────────────────────────────────────────────────
$routes->get('/resep',                     'Resep::index');
$routes->get('/resep/tambah/(:any)',        'Resep::tambah/$1'); // (:any) = id_rekam_medis
$routes->post('/resep/simpan',             'Resep::simpan');
$routes->get('/resep/detail/(:any)',        'Resep::detail/$1');
$routes->post('/resep/update_status/(:any)', 'Resep::updateStatus/$1');

// ── Data Obat ─────────────────────────────────────────────
$routes->get('/obat',            'Obat::index');
$routes->get('/obat/tambah',     'Obat::tambah');
$routes->post('/obat/simpan',    'Obat::simpan');
$routes->get('/obat/edit/(:any)', 'Obat::edit/$1');
$routes->post('/obat/update/(:any)', 'Obat::update/$1');
$routes->get('/obat/hapus/(:any)', 'Obat::hapus/$1');
