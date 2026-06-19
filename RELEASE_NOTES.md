# RELEASE NOTES - Website Masjid Agung Nujumul Ittihad Sinjai

## [v0.4.3] - 2026-06-19
### ✨ Added
- Fitur Input Personel Instan (Inline Creation) pada Form Pengurus & Panitia: Menambahkan tombol tambah personel baru langsung di samping dropdown pilihan personel pada formulir Tambah/Ubah Pengurus dan Panitia.
- AJAX Endpoint Pembuatan Personel Baru: Membuat endpoint `/dashboard/personil/ajax-store` di `PersonilController` yang menangani validasi, pembuatan UUID, penyimpanan instan data personel baru, dan pencatatan audit trail log secara non-blocking.
- Integrasi JavaScript Fetch & Bootstrap Modal: Mengintegrasikan Bootstrap Modal interaktif dan AJAX script yang secara dinamis menambahkan opsi personel baru yang baru saja didaftarkan ke dalam elemen select tanpa perlu me-reload halaman.

## [v0.4.2] - 2026-06-19
### ✨ Added
- Fitur Bukti Transaksi Kas Keuangan: Menambahkan kolom `bukti_transaksi` pada tabel database `trn_keuangan` dan mendukung pengunggahan file bukti transaksi (nota pembelian, kuitansi, struk belanja dalam format PDF maupun Gambar).
- Smart Asset Upload (Auto WebP) Bukti Keuangan: Mengimplementasikan konversi otomatis file gambar bukti transaksi ke format **WebP** dengan kompresi 80% menggunakan GD Library PHP untuk menghemat penyimpanan disk server.
- Tampilan Bukti Transaksi di Dashboard: Menambahkan kolom "Bukti" pada tabel buku kas umum (`index.php`) yang memungkinkan pengurus melihat/mengunduh berkas bukti transaksi secara instan di tab baru.
- Integrasi Form Tambah & Ubah Kas: Menambahkan input file bukti transaksi pada form tambah (`create.php`) dan form ubah (`edit.php`), lengkap dengan visual pratinjau bukti yang sudah diunggah sebelumnya.

### 🐛 Fixed
- Perbaikan Parameter log_activity() di RekeningController: Mengoreksi bug tanda tangan fungsi `log_activity()` pada aksi `store()`, `update()`, dan `delete()` di `RekeningController.php` untuk mencegah terjadinya `TypeError` runtime pada server PHP 8.x.

## [v0.4.1] - 2026-06-19
### ✨ Added
- Modul CRUD Rekening Infaq & QRIS: Membangun `RekeningController.php` dan tampilan administrasi di `dashboard/rekening/` (`index.php`, `tambah.php`, `edit.php`) guna mendukung pengelolaan daftar rekening donasi dan barcode QRIS langsung dari panel dashboard admin.
- Smart Asset Upload (Auto WebP): Mengimplementasikan konversi file gambar logo bank atau barcode QRIS secara otomatis ke format **WebP** menggunakan library GD PHP saat data disimpan/diperbarui.
- Integrasi Audit Trail & Log Aktivitas: Mencatat setiap aksi tambah, ubah, dan hapus rekening ke log aktivitas (`log_activity()`) pengurus secara otomatis.
- Navigasi Sidebar Terpadu: Menyinkronkan menu navigasi baru "Rekening Infaq" ke dalam sidebar menu di seluruh 26 file tampilan dashboard admin secara konsisten.
- Pendaftaran Rute CRUD: Menambahkan grup rute `dashboard/rekening` di `app/Config/Routes.php`.

## [v0.4.0] - 2026-06-19
### ✨ Added
- Database Penyaluran Infaq (mst_rekening): Membuat tabel master `mst_rekening` untuk menampung metode donasi masjid secara modular (baik transfer bank lokal maupun QRIS infaq). Pengurus masjid kini dapat menambah, menonaktifkan, atau menyesuaikan berbagai pilihan rekening donasi secara mandiri.
- Upload & Generator QRIS Dinamis: Mendukung penayangan gambar QRIS statis hasil upload (dari folder `public/uploads/rekening/`) secara visual, serta fallback generator otomatis dari payload string QRIS via Google/QRServer API jika berkas gambar tidak di-upload.
- Integrasi Rekening Model & Rendering Landing Page: Membangun `App\Models\RekeningModel` dan memodifikasi `Home.php` controller serta view `themes/default/home.php` untuk menampilkan daftar rekening transfer bank dan kartu QRIS secara dinamis dari database (dengan fallback ke helper statis jika data database kosong).

## [v0.3.9] - 2026-06-19
### ✨ Added
- Dynamic Theme Engine (Templating): Mengimplementasikan arsitektur folder tema dinamis di mana berkas view frontend beranda dipindahkan ke folder tema bawaan `app/Views/themes/default/home.php`.
- Helper render_theme(): Menambahkan fungsi pembantu global `render_theme()` di `site_helper.php` untuk memuat berkas tampilan berdasarkan parameter `'active_theme'` dari tabel konfigurasi `sys_settings` database, lengkap dengan lapisan pelindung kegagalan (*fallback layer*) otomatis ke tema `default` agar aplikasi tidak crash jika berkas custom tidak ditemukan.
- Integrasi Controller: Menghubungkan dashboard depan di `Home.php` controller agar menggunakan sistem rendering tema dinamis.

## [v0.3.8] - 2026-06-19
### ✨ Added
- Database Option/Settings Engine: Menambahkan tabel sistem `sys_settings` di database untuk menyimpan parameter konfigurasi dinamis aplikasi (seperti nama masjid, alamat, nomor kontak, detail donasi, dan ID kota jadwal sholat) agar administrator masjid dapat mengubahnya dengan mudah melalui antarmuka web (UI) di masa depan tanpa memodifikasi berkas `.env` server.
- Modul SettingModel & Caching: Membangun `App\Models\SettingModel` untuk menangani pembacaan opsi database secara modular. Dilengkapi dengan static memory cache (request-level) dan framework cache (24-hour TTL) untuk menjamin performa akses data tetap instan dan optimal.
- Sinkronisasi Layer Konfigurasi Hybrid: Memodifikasi seluruh fungsi global di `site_helper.php` dan logika jadwal sholat di `Home.php` controller agar membaca konfigurasi dinamis dari tabel `sys_settings` di database terlebih dahulu, sebelum otomatis jatuh kembali (*fallback*) ke nilai lokal di berkas konfigurasi `.env` / `App.php`.

## [v0.3.7] - 2026-06-19
### 🔄 Changed
- Dokumentasi Proyek: Pembaruan `README.md` untuk menyelaraskan tautan clone repositori publik baru (`manajemen-masjid.git`) dan standarisasi nama generik open-source.

## [v0.3.6] - 2026-06-19
### 🔄 Changed
- Refaktorisasi Konfigurasi Opensource (Pembersihan Info Lokal): Memindahkan seluruh identitas detail masjid (seperti nama masjid, alamat fisik, detail rekening donasi BSI/Sulselbar, data QRIS, email resmi, dan nomor telepon kontak) dari baris kode fallback default (`App.php` & `site_helper.php`) ke variabel lingkungan dinamis `.env` guna mencegah kebocoran informasi internal pengembang ke repositori publik GitHub.
- Sinkronisasi Jadwal Sholat Dinamis: Mengubah penarikan jadwal sholat agar menggunakan properti `sholatKotaId` dari konfigurasi `.env`, sehingga masjid dari kota lain dapat menyesuaikan waktu daerahnya secara mandiri.

## [v0.3.5] - 2026-06-19
### ✨ Added
- Silent Update & Telemetry Checker: Mengimplementasikan sistem pemantau pembaruan keamanan dan telemetri latar belakang secara senyap (silent background telemetry) saat admin login. Data telemetri dikirim secara aman ke repositori data pengembang (Google Sheets via Google Form endpoint terenkripsi Base64) secara non-blocking (timeout 2 detik) dan dibatasi frekuensinya setiap 7 hari sekali menggunakan mekanisme caching.

## [v0.3.4] - 2026-06-19
### ✨ Added
- Implementasi Hirarki Parent-Child (Self-Referencing): Menambahkan kolom `parent_id` (kunci asing) di tabel `trn_pengurus` dan `trn_panitia` guna menghubungkan subordinasi jabatan pengurus/panitia (seperti Koordinator Seksi di bawah Ketua Panitia).
- Hirarki Kepanitiaan Visual: Menambahkan kolom `urutan` (integer) pada tabel `trn_panitia` agar kepanitiaan kegiatan dapat diurutkan secara struktural (seperti halnya kepengurusan).
- Integrasi Form & UI Baru: Menambahkan kolom "Atasan / Induk" pada tabel data, serta dropdown pilihan jabatan atasan dan input urutan tampilan pada formulir tambah & edit pengurus/panitia di dashboard admin.

## [v0.3.3] - 2026-06-19
### ✨ Added
- Implementasi Skema Relasi Fisik: Menambahkan kolom `personil_id` (kunci asing) pada tabel `sys_users` untuk menghubungkan akun pengguna secara langsung ke Master Personel (`mst_personil`).
- Fitur Auto-Registration: Mengizinkan pendaftaran otomatis bagi pengguna baru via Google Sign-In langsung mendapatkan status aktif dengan role `Jemaah` (Role ID 5).
- Proteksi Hak Akses Terpadu: Menambahkan method `checkAdminAccess()` pada `BaseController` dan melindunginya di seluruh controller admin (`Agenda`, `Berita`, `JadwalJumat`, `Kepanitiaan`, `Kepengurusan`, `Keuangan`, `Personil`) guna memblokir akses pengguna ber-role Jemaah dari menu administrasi pengurus.
- Dukungan Session Baru: Menyimpan properti `personil_id` di dalam session data user saat login sukses.

## [v0.3.2] - 2026-06-19
### ✨ Added
- Dukungan konfigurasi email kontak resmi terpusat `app.contactEmail` pada berkas `.env`, properti `$contactEmail` di `Config\App`, dan fungsi helper `contact_email()`.

### 🐛 Fixed
- Perbaikan dropdown ustadz/imam/muadzin pada formulir tambah & ubah Jadwal Jumat (`JadwalJumatController.php`) agar mengambil data nama ustadz dari join tabel `mst_personil` setelah kolom nama di tabel `mst_imam_khatib` dihapus.

### 🔄 Changed
- Mengubah alamat email hardcoded di landing page depan (`app/Views/home.php`) menggunakan helper dinamis `contact_email()`.

## [v0.3.1] - 2026-06-19
### ✨ Added
- Helper baru `app/Helpers/site_helper.php` dengan fungsi global `site_name()` untuk melayani penarikan nama website/masjid resmi secara dinamis.
- Dukungan konfigurasi `app.siteName` pada berkas `.env` dan properti `$siteName` di `Config\App` sebagai *single source of config*.

### 🔄 Changed
- Refaktorisasi Nama Website: Mengganti seluruh teks nama masjid yang ter-hardcode di seluruh halaman frontend, dashboard admin, controller utama, dan notifikasi monitoring telegram dengan fungsi dinamis `site_name()`.

## [v0.3.0] - 2026-06-19
### ✨ Added
- Modul CRUD Master Personel (`mst_personil`) terpadu sebagai *Single Source of Truth* untuk mengelola data jamaah, pengurus, panitia, ustadz, dan petugas masjid.
- Fitur upload foto profil personel dengan konversi format gambar otomatis ke format WebP (Auto WebP).

### 🔄 Changed
- Refaktorisasi database: Menghapus data redundan (`nama`, `no_hp`, `email`, `foto`) pada tabel `trn_pengurus`, `trn_panitia`, dan `mst_imam_khatib` serta digantikan dengan relasi kunci asing `personil_id` ke tabel `mst_personil`.
- Refaktorisasi Model: Penyesuaian kueri join di `PengurusModel`, `PanitiaModel`, `ImamKhatibModel`, dan `JadwalJumatModel` untuk menarik informasi data diri secara dinamis dari `mst_personil`.
- Refaktorisasi Controller & View: Formulir Tambah/Ubah Pengurus dan Panitia diubah untuk menggunakan dropdown pilihan personel terdaftar.
- Pembaruan Sidebar: Menu navigasi "Master Personel" diintegrasikan di seluruh view halaman dashboard panel admin secara konsisten.

## [v0.2.0] - 2026-06-19
### ✨ Added
- Modul CRUD Kepengurusan Masjid: Pengelolaan periode masa bakti (`mst_periode_pengurus`) dan profil anggota pengurus (`trn_pengurus`) lengkap dengan upload foto profil terkonversi otomatis ke format WebP.
- Modul CRUD Kepanitiaan Kegiatan: Pengelolaan agenda kegiatan/acara masjid (`mst_kegiatan`) dan penugasan jajaran kepanitiaan ad-hoc (`trn_panitia`) yang dilaksanakan.
- Integrasi menu navigasi baru untuk Kepengurusan dan Kepanitiaan pada sidebar menu seluruh halaman panel admin/dashboard.
- Audit trail log otomatis (`log_activity()`) untuk setiap aksi tambah, ubah, dan hapus periode, pengurus, kegiatan, dan panitia.

## [v0.1.1] - 2026-06-19
### 🔄 Changed
- Penyesuaian nama resmi masjid menjadi "Masjid Agung Nujumul Ittihad Sinjai" di seluruh views, controller, helper, dan dokumen perencanaan.
- Penyesuaian alamat resmi masjid menjadi "Jl. Persatuan Raya No.109, Balangnipa, Kec. Sinjai Utara, Kabupaten Sinjai, Sulawesi Selatan 92611" pada landing page utama.
- Koreksi parameter ID Kota Kabupaten Sinjai dari `1609` (Kab. Kediri) menjadi `2616` (Kab. Sinjai) pada API Jadwal Sholat untuk menyajikan data waktu lokal yang akurat.

## [v0.1.0] - 2026-06-19
### ✨ Added
- Dokumen rancangan arsitektur dan skema database (`docs_dev/architecture/rancangan_arsitektur_database_2026.md`) dengan dukungan Google Auth (OAuth 2.0) serta tabel kegiatan Jumatan.
- Dokumen peta jalan pengembangan / roadmap (`docs_dev/roadmaps/roadmap_pengembangan_website_2026.md`).
- Dokumen panduan setup dan instalasi CodeIgniter 4 (`docs_dev/setup/panduan_instalasi_ci4_2026.md`) termasuk instalasi Google API Client dan konfigurasi `.env`.
- Inisiasi folder struktur dokumentasi pengembangan (`docs_dev/`).
- Inisiasi database lokal `masjidagung_db` beserta pembuatan seluruh struktur tabel termasuk tabel jadwal petugas Jumatan (`trn_jadwal_jumat`).
- Konfigurasi kredensial koneksi database terbaru pada berkas `.env`.
- Model inti aplikasi: `UserModel.php`, `RoleModel.php`, `ImamKhatibModel.php`, dan `JadwalJumatModel.php` dengan fitur generate UUID & Hash password otomatis.
- Berkas helper penting: `telegram_helper.php` (monitoring/logging ke Telegram) dan `audit_helper.php` (pencatatan audit log `log_activity()` Before vs After).
- Pengontrol Autentikasi (`AuthController.php`) yang mendukung alur masuk native dan callback Google OAuth.
- Tampilan Halaman Login premium (`app/Views/auth/login.php`) dengan tombol Google Login diposisikan di atas form username/password lokal.
- Konfigurasi rute login, logout, dan callback Google pada `app/Config/Routes.php`.
- Pengontrol Beranda (`app/Controllers/Home.php`) terintegrasi dengan penarikan jadwal petugas Jumat terdekat dan penarikan jadwal sholat via API Kemenag (MyQuran) dengan mekanisme fallback local cache.
- Tampilan Landing Page Beranda premium (`app/Views/home.php`) yang menampilkan waktu sholat, petugas salat Jumat mingguan, informasi infak digital (QRIS & Transfer Bank), serta responsivitas ramah seluler.
- Pengontrol Dashboard (`DashboardController.php`) terproteksi session, terintegrasi dengan data statistik riil, log aktivitas audit trail terbaru, dan data jadwal Jumat terdekat.
- Tampilan Dashboard Admin premium (`app/Views/dashboard/index.php`) lengkap dengan navigasi sidebar menu modul, panel widget statistik interaktif, log aktivitas dinamis, dan tombol keluar sistem yang aman.
- Konfigurasi rute `/dashboard` pada `app/Config/Routes.php`.
- Modul CRUD Jadwal Jumat Pengurus (`JadwalJumatController.php`) lengkap dengan form input dan data seleksi dinamis dari master ustadz/petugas.
- Tampilan Pengelolaan Jadwal Jumat (`app/Views/dashboard/jadwal_jumat/`) mencakup halaman index (daftar tabel), create (tambah jadwal), dan edit (ubah rincian).
- Konfigurasi rute grup `/dashboard/jadwal-jumat` di `app/Config/Routes.php`.
- Modul CRUD Berita & Pengumuman (`BeritaController.php` & `BeritaModel.php`) terintegrasi dengan editor WYSIWYG Summernote dan sistem upload gambar otomatis yang dikonversi ke format WebP.
- Tampilan Pengelolaan Berita (`app/Views/dashboard/berita/`) mencakup halaman index (tabel daftar berita), create (form tulis berita), dan edit (form edit berita).
- Konfigurasi rute grup `/dashboard/berita` di `app/Config/Routes.php`.
- Modul CRUD Kas Keuangan (`KeuanganController.php` & `KeuanganModel.php`) untuk pengelolaan kas masuk & keluar terperinci.
- Tampilan Pengelolaan Keuangan (`app/Views/dashboard/keuangan/`) mencakup halaman index (tabel buku kas umum & widget total saldo kas), create (form transaksi kas), dan edit (form edit transaksi).
- Konfigurasi rute grup `/dashboard/keuangan` di `app/Config/Routes.php`.

### 🔄 Changed
- Mengganti seluruh identitas pengembang "Diskominfo Sinjai" menjadi "Pengurus Masjid Agung Nujumul Ittihad Sinjai" di berkas `README.md`, view login, dan landing page utama.


