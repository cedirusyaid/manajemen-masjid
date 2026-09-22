<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/pembangunan', 'Home::pembangunan');
$routes->get('/kepanitiaan', 'Home::pembangunan');
$routes->get('/kepanitiaan/(:segment)', 'Home::pembangunan/$1');

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
    $routes->post('ajax-add-petugas', 'JadwalJumatController::ajaxAddPetugas');
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
    
    // Detail Route
    $routes->get('detail/(:segment)', 'KepengurusanController::detail/$1');
    
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
    
    // Detail Route
    $routes->get('detail/(:segment)', 'KepanitiaanController::detail/$1');
    
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

    // Kelompok Routes
    $routes->get('kelompok/create', 'KepanitiaanController::createKelompok');
    $routes->post('kelompok/store', 'KepanitiaanController::storeKelompok');
    $routes->get('kelompok/edit/(:segment)', 'KepanitiaanController::editKelompok/$1');
    $routes->post('kelompok/update/(:segment)', 'KepanitiaanController::updateKelompok/$1');
    $routes->get('kelompok/delete/(:segment)', 'KepanitiaanController::deleteKelompok/$1');
    
    // Anggota Kelompok Routes
    $routes->get('kelompok/anggota/(:segment)', 'KepanitiaanController::kelolaAnggotaKelompok/$1');
    $routes->post('kelompok/anggota/store', 'KepanitiaanController::storeAnggotaKelompok');
    $routes->get('kelompok/anggota/delete/(:segment)', 'KepanitiaanController::deleteAnggotaKelompok/$1');

    // Bantuan Material / Barang Routes
    $routes->post('material/store', 'KepanitiaanController::storeMaterial');
    $routes->post('material/update/(:segment)', 'KepanitiaanController::updateMaterial/$1');
    $routes->get('material/delete/(:segment)', 'KepanitiaanController::deleteMaterial/$1');

    // Cetak / Export LPJ Proyek
    $routes->get('lpj/(:segment)', 'KepanitiaanController::lpj/$1');
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

// Rute CRUD Master Layanan & Transaksi Pelayanan Jamaah
$routes->group('dashboard/layanan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'LayananController::index');
    $routes->get('create', 'LayananController::create');
    $routes->post('store', 'LayananController::store');
    $routes->get('edit/(:segment)', 'LayananController::edit/$1');
    $routes->post('update/(:segment)', 'LayananController::update/$1');
    $routes->get('delete/(:segment)', 'LayananController::delete/$1');
});

$routes->group('dashboard/pelayanan', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'LayananController::pelayananIndex');
    $routes->get('create', 'LayananController::createPelayanan');
    $routes->post('store', 'LayananController::storePelayanan');
    $routes->get('edit/(:segment)', 'LayananController::editPelayanan/$1');
    $routes->post('update/(:segment)', 'LayananController::updatePelayanan/$1');
    $routes->get('delete/(:segment)', 'LayananController::deletePelayanan/$1');
    $routes->get('cetak/(:segment)', 'LayananController::cetakPelayanan/$1');
});

// Rute CRUD Master Jadwal Waktu Shalat
$routes->group('dashboard/jadwal-sholat', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'JadwalSholatController::index');
    $routes->get('create', 'JadwalSholatController::create');
    $routes->post('store', 'JadwalSholatController::store');
    $routes->get('edit/(:segment)', 'JadwalSholatController::edit/$1');
    $routes->post('update/(:segment)', 'JadwalSholatController::update/$1');
    $routes->get('delete/(:segment)', 'JadwalSholatController::delete/$1');
    $routes->get('reset-tahunan', 'JadwalSholatController::resetTahunan');
    $routes->post('save-blank-settings', 'JadwalSholatController::saveDisplayBlankSettings');
});

// Rute CRUD Ayat Pilihan Display
$routes->group('dashboard/ayat', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'AyatPilihanController::index');
    $routes->get('create', 'AyatPilihanController::create');
    $routes->post('store', 'AyatPilihanController::store');
    $routes->get('edit/(:segment)', 'AyatPilihanController::edit/$1');
    $routes->post('update/(:segment)', 'AyatPilihanController::update/$1');
    $routes->get('toggle-status/(:segment)', 'AyatPilihanController::toggleStatus/$1');
    $routes->get('delete/(:segment)', 'AyatPilihanController::delete/$1');
});

// Rute CRUD Manajemen Pengguna Sistem (Users)
$routes->group('dashboard/users', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('create', 'UserController::create');
    $routes->post('store', 'UserController::store');
    $routes->get('edit/(:segment)', 'UserController::edit/$1');
    $routes->post('update/(:segment)', 'UserController::update/$1');
    $routes->get('toggle-status/(:segment)', 'UserController::toggleStatus/$1');
    $routes->get('delete/(:segment)', 'UserController::delete/$1');
});


// Rute REST API & TV Display Masjid
$routes->get('/api/display', 'Api\DisplayController::index');
$routes->get('/api/display/data', 'Api\DisplayController::index');
$routes->get('/display', function() {
    return redirect()->to(base_url('display/index.html'));
});
$routes->get('/display/(:any)', function($sub = '') {
    return redirect()->to(base_url('display/' . $sub));
});

