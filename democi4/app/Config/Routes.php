<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');
$routes->get('/login', 'Home::login');
$routes->post('/ceklogin', 'Home::ceklogin');
$routes->get('/logout', 'Home::logout');

$routes->get('/homepage', 'Home::homepage');
$routes->get('/halamandepan', 'Home::halamandepan');
$routes->get('/content', 'Home::content');

$routes->get('/kirimdata', 'Home::terimadata');
$routes->post('/kirimdata', 'Home::terimadatamethodpost');

$routes->get('/biodata', 'MahasiswaController::index');
$routes->post('/formbiodata', 'MahasiswaController::savebiodata');

$routes->get('/login', 'LoginController::index');
$routes->post('/formlogin', 'LoginController::savelogin');

$routes->get('/register', 'LoginController::index');
$routes->post('/cekdata', 'LoginController::cekdata');

$routes->get('/jurusan', 'JurusanController::index');
$routes->get('/prodi', 'ProdiController::index');

$routes->get('/jurusan', 'JurusanController::index');
$routes->post('/simpan', 'JurusanController::simpandata');
$routes->post('/updatedatajurusan', 'JurusanController::updatedata');
$routes->post('/hapusdatajurusan', 'JurusanController::hapusdata');

$routes->get('/prodi', 'ProdiController::index');
$routes->post('/simpanprodi', 'ProdiController::simpandata');
$routes->post('/updatedataprodi', 'ProdiController::updatedata');
$routes->post('/hapusdataprodi', 'ProdiController::hapusdata');

$routes->get('/mahasiswa', 'MahasiswaController::index');
$routes->post('/simpandatamahasiswa', 'MahasiswaController::simpandata');
$routes->post('/updatedatamahasiswa', 'MahasiswaController::updatedata');
$routes->post('/hapusdatamahasiswa', 'MahasiswaController::hapusdata');