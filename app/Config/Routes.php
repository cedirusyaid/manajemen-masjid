<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Rute Autentikasi Pengurus (Native & Google Auth)
$routes->get('/login', 'AuthController::login');
$routes->post('/login/process', 'AuthController::loginProcess');
$routes->get('/auth/google/callback', 'AuthController::googleCallback');
$routes->get('/logout', 'AuthController::logout');

// Rute Dashboard Admin Pengurus (Protected)
$routes->get('/dashboard', 'DashboardController::index');

// Rute CRUD Jadwal Jumat
$routes->group('dashboard/jadwal-jumat', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'JadwalJumatController::index');
    $routes->get('create', 'JadwalJumatController::create');
    $routes->post('store', 'JadwalJumatController::store');
    $routes->get('edit/(:segment)', 'JadwalJumatController::edit/$1');
    $routes->post('update/(:segment)', 'JadwalJumatController::update/$1');
    $routes->get('delete/(:segment)', 'JadwalJumatController::delete/$1');
});

// Rute CRUD Berita & Pengumuman
$routes->group('dashboard/berita', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'BeritaController::index');
    $routes->get('create', 'BeritaController::create');
    $routes->post('store', 'BeritaController::store');
    $routes->get('edit/(:segment)', 'BeritaController::edit/$1');
    $routes->post('update/(:segment)', 'BeritaController::update/$1');
    $routes->get('delete/(:segment)', 'BeritaController::delete/$1');
});

// Rute CRUD Kas Keuangan (Buku Kas Umum)
$routes->group('dashboard/keuangan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'KeuanganController::index');
    $routes->get('create', 'KeuanganController::create');
    $routes->post('store', 'KeuanganController::store');
    $routes->get('edit/(:segment)', 'KeuanganController::edit/$1');
    $routes->post('update/(:segment)', 'KeuanganController::update/$1');
    $routes->get('delete/(:segment)', 'KeuanganController::delete/$1');
});

// Rute CRUD Kepengurusan (Periode & Anggota)
$routes->group('dashboard/kepengurusan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'KepengurusanController::index');
    
    // Periode Routes
    $routes->get('periode/create', 'KepengurusanController::createPeriode');
    $routes->post('periode/store', 'KepengurusanController::storePeriode');
    $routes->get('periode/edit/(:segment)', 'KepengurusanController::editPeriode/$1');
    $routes->post('periode/update/(:segment)', 'KepengurusanController::updatePeriode/$1');
    $routes->get('periode/delete/(:segment)', 'KepengurusanController::deletePeriode/$1');
    
    // Jabatan Routes
    $routes->get('jabatan/create', 'KepengurusanController::createJabatan');
    $routes->post('jabatan/store', 'KepengurusanController::storeJabatan');
    $routes->get('jabatan/edit/(:segment)', 'KepengurusanController::editJabatan/$1');
    $routes->post('jabatan/update/(:segment)', 'KepengurusanController::updateJabatan/$1');
    $routes->get('jabatan/delete/(:segment)', 'KepengurusanController::deleteJabatan/$1');
    
    // Pengurus Routes
    $routes->get('pengurus/create', 'KepengurusanController::createPengurus');
    $routes->post('pengurus/store', 'KepengurusanController::storePengurus');
    $routes->get('pengurus/edit/(:segment)', 'KepengurusanController::editPengurus/$1');
    $routes->post('pengurus/update/(:segment)', 'KepengurusanController::updatePengurus/$1');
    $routes->get('pengurus/delete/(:segment)', 'KepengurusanController::deletePengurus/$1');
});

// Rute CRUD Kepanitiaan (Kegiatan & Anggota Panitia)
$routes->group('dashboard/kepanitiaan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'KepanitiaanController::index');
    
    // Kegiatan Routes
    $routes->get('kegiatan/create', 'KepanitiaanController::createKegiatan');
    $routes->post('kegiatan/store', 'KepanitiaanController::storeKegiatan');
    $routes->get('kegiatan/edit/(:segment)', 'KepanitiaanController::editKegiatan/$1');
    $routes->post('kegiatan/update/(:segment)', 'KepanitiaanController::updateKegiatan/$1');
    $routes->get('kegiatan/delete/(:segment)', 'KepanitiaanController::deleteKegiatan/$1');
    
    // Jabatan Routes
    $routes->get('jabatan/create', 'KepanitiaanController::createJabatan');
    $routes->post('jabatan/store', 'KepanitiaanController::storeJabatan');
    $routes->get('jabatan/edit/(:segment)', 'KepanitiaanController::editJabatan/$1');
    $routes->post('jabatan/update/(:segment)', 'KepanitiaanController::updateJabatan/$1');
    $routes->get('jabatan/delete/(:segment)', 'KepanitiaanController::deleteJabatan/$1');
    
    // Panitia Routes
    $routes->get('panitia/create', 'KepanitiaanController::createPanitia');
    $routes->post('panitia/store', 'KepanitiaanController::storePanitia');
    $routes->get('panitia/edit/(:segment)', 'KepanitiaanController::editPanitia/$1');
    $routes->post('panitia/update/(:segment)', 'KepanitiaanController::updatePanitia/$1');
    $routes->get('panitia/delete/(:segment)', 'KepanitiaanController::deletePanitia/$1');
});

// Rute CRUD Master Personil (Unified Personnel)
$routes->group('dashboard/personil', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'PersonilController::index');
    $routes->get('create', 'PersonilController::create');
    $routes->post('store', 'PersonilController::store');
    $routes->post('ajax-store', 'PersonilController::ajaxStore');
    $routes->get('edit/(:segment)', 'PersonilController::edit/$1');
    $routes->post('update/(:segment)', 'PersonilController::update/$1');
    $routes->get('delete/(:segment)', 'PersonilController::delete/$1');
});

// Rute CRUD Jadwal Pengajian (Agenda)
$routes->group('dashboard/agenda', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'AgendaController::index');
    $routes->get('create', 'AgendaController::create');
    $routes->post('store', 'AgendaController::store');
    $routes->get('edit/(:segment)', 'AgendaController::edit/$1');
    $routes->post('update/(:segment)', 'AgendaController::update/$1');
    $routes->get('delete/(:segment)', 'AgendaController::delete/$1');
});

// Rute CRUD Rekening & Metode Infaq
$routes->group('dashboard/rekening', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'RekeningController::index');
    $routes->get('create', 'RekeningController::create');
    $routes->post('store', 'RekeningController::store');
    $routes->get('edit/(:segment)', 'RekeningController::edit/$1');
    $routes->post('update/(:segment)', 'RekeningController::update/$1');
    $routes->get('delete/(:segment)', 'RekeningController::delete/$1');
});

