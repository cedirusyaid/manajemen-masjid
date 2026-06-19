# 🕌 Aplikasi Manajemen Masjid (Manajemen-Masjid)
> **Sarana Digitalisasi Manajemen Masjid, Transparansi Keuangan, dan Pusat Pelayanan Jamaah berbasis CodeIgniter 4.**

---

<p align="center">
  <img src="https://img.shields.io/badge/PHP-8.1%20%7C%208.2-777bb4.svg?style=for-the-badge&logo=php" alt="PHP Version" />
  <img src="https://img.shields.io/badge/CodeIgniter-4.7.x-EF4223.svg?style=for-the-badge&logo=codeigniter" alt="Framework Version" />
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952b3.svg?style=for-the-badge&logo=bootstrap" alt="Bootstrap Version" />
  <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License" />
</p>

---

## 🌟 Fitur Utama

Aplikasi ini dikembangkan dalam dua fase utama dengan mengedepankan fungsionalitas yang ramah seluler (*mobile-first design*):

### 📌 Fase 1: Minimum Viable Product (MVP)
*   **⏰ Sistem Jadwal Sholat**: Integrasi API waktu sholat akurat dengan sistem fallback penyimpanan lokal.
*   **💳 Modul Infak Digital**: Pembayaran donasi nontunai menggunakan barcode QRIS dinamis dan rekening resmi masjid.
*   **📢 Pusat Notifikasi**: Pengumuman agenda darurat atau perubahan jadwal kegiatan langsung di beranda.
*   **💸 Transparansi Kas**: Laporan keuangan kas masuk dan keluar bulanan secara detail dan transparan untuk jamaah.
*   **🔑 Multi-Method Authentication**: Login pengurus menggunakan akun lokal terenkripsi `BCRYPT` atau via **Google Sign-In (OAuth 2.0)**.

### 📌 Fase 2: Pelayanan Digital Lanjutan
*   **📝 Pendaftaran TPA Online**: Penerimaan santri baru secara mandiri melalui form online.
*   **🕋 Pelayanan Zakat (ZIS)**: Form pelaporan dan verifikasi zakat fitrah, zakat maal, dan sedekah khusus.
*   **📞 Integrasi Telegram Bot**: Bot monitoring pengiriman notifikasi transaksi penting dan pelaporan galat (*system error*).
*   **🏛️ Form Pengajuan Acara**: Pemesanan penggunaan fasilitas/ruangan masjid oleh masyarakat umum.

---

## 📂 Peta Dokumentasi Pengembangan
Untuk mempermudah pemeliharaan sistem, dokumen perencanaan teknis disimpan secara terstruktur di folder [docs_dev/](file:///apps/masjidagung/docs_dev/):

| 📁 Kategori | 📄 Dokumen | 🔍 Cakupan Pembahasan |
| :--- | :--- | :--- |
| **Arsitektur & DB** | [rancangan_arsitektur_database_2026.md](file:///apps/masjidagung/docs_dev/architecture/rancangan_arsitektur_database_2026.md) | Desain skema DB (`sys_`, `mst_`, `trn_`, `log_`), skenario enkripsi, API response, dan rancangan integrasi Google Auth. |
| **Peta Jalan** | [roadmap_pengembangan_website_2026.md](file:///apps/masjidagung/docs_dev/roadmaps/roadmap_pengembangan_website_2026.md) | Jadwal rilis fitur, metodologi rilis MVP, dan tata cara standardisasi commit git. |
| **Instalasi** | [panduan_instalasi_ci4_2026.md](file:///apps/masjidagung/docs_dev/setup/panduan_instalasi_ci4_2026.md) | Prasyarat sistem PHP 8.x, instalasi library Google Client via Composer, dan checklist keamanan global. |

---

## 🛠️ Tech Stack & Spesifikasi
*   **Backend**: PHP 8.1+ & CodeIgniter 4 Framework
*   **Frontend**: HTML5, CSS3 Vanilla, JavaScript, Bootstrap 5.3, DataTables (Server-Side), Summernote WYSIWYG
*   **Database**: MariaDB / MySQL (dengan pengindeksan filter penelusuran & soft deletes)
*   **API / SDK**: Google Client API Library, Telegram Bot API
*   **Optimasi Gambar**: GD Library (Auto-convert uploads ke format **WebP**)

---

## ⚙️ Panduan Menjalankan Proyek Secara Lokal

### 1. Kloning Repositori
```bash
git clone git@github.com:cedirusyaid/manajemen-masjid.git
cd manajemen-masjid
```

### 2. Instalasi Dependensi
Gunakan PHP 8.1+ dan Composer untuk memasang seluruh pustaka backend (termasuk Google API Client):
```bash
composer install
```

### 3. Konfigurasi File Environment
Salin template konfigurasi `.env`:
```bash
cp env .env
```
Buka file `.env` dan sesuaikan pengaturan database dan kunci integrasi Anda:
```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

# Database MariaDB/MySQL
database.default.database = db_masjid_agung
database.default.username = root
database.default.password = your_password

# Google API OAuth
google.clientID = "YOUR_CLIENT_ID.apps.googleusercontent.com"
google.clientSecret = "YOUR_CLIENT_SECRET"
```

### 4. Jalankan Server Lokal
Nyalakan server pengembangan lokal bawaan CodeIgniter:
```bash
php spark serve
```
Akses web aplikasi melalui peramban kesayangan Anda di: **`http://localhost:8080`**

---

## 🛡️ Protokol Git & Kontribusi (Standard v2.5)
Setiap pembaruan kode harus mengikuti pedoman berikut:
*   **Linting**: Pengembang wajib menjalankan `php -l [nama_file.php]` sebelum melakukan commit.
*   **Commit Format**: `YYMMDD - [Tipe]: Deskripsi Singkat`
    *   *Tipe*: `Added`, `Fixed`, `Changed`, `Security`.
    *   *Contoh*: `260619 - [Added]: Menambahkan skema tabel sys_users dengan dukungan Google OAuth`.
*   **Push**: Gunakan script otomatis [`push.sh`](file:///apps/masjidagung/push.sh) untuk kemudahan integrasi.

---
*Project Open Source - Manajemen Masjid*
