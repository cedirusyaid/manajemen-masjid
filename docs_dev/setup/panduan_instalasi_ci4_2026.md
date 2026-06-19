# Panduan Instalasi & Konfigurasi CodeIgniter 4
**Tanggal:** 2026-06-19  
**Versi Dokumen:** v1.0.0  
**Status:** Draf  
**Penyusun:** Alexa (AI Assistant)

---

## 1. Pendahuluan
Dokumen ini memuat panduan langkah demi langkah untuk melakukan setup lingkungan pengembangan (development environment) awal proyek Website Masjid Agung Nujumul Ittihad Sinjai menggunakan framework **CodeIgniter 4** (CI4). Panduan ini mematuhi standar konfigurasi aman dan portabel (Termux, Linux Debian, dan Windows).

---

## 2. Prasyarat Sistem
Sebelum memulai instalasi, pastikan sistem Anda memenuhi prasyarat berikut:
- **PHP**: Versi 8.1 atau yang lebih baru (sangat direkomendasikan PHP 8.2).
- **Ekstensi PHP Wajib**:
  - `intl` (wajib untuk CI4)
  - `mbstring`
  - `curl`
  - `mysqlnd` atau `mysqli`
  - `gd` (untuk pengolahan & konversi WebP otomatis)
  - `json`, `xml`
- **Composer**: Dependency Manager PHP terinstal secara global.
- **Database**: MariaDB 10.x atau MySQL 8.x.

---

## 3. Langkah Instalasi Awal
Untuk memulai proyek baru dengan CodeIgniter 4 di folder `/apps/masjidagung`:

1. **Unduh Framework via Composer**:
   ```bash
   composer create-project codeigniter4/appstarter .
   ```
   *Catatan: Titik (`.`) di akhir perintah digunakan untuk menginstal langsung di dalam folder aktif saat ini.*

2. **Unduh Library Google Client API**:
   Gunakan composer untuk menginstal Google API Client SDK resmi untuk memproses callback OAuth:
   ```bash
   composer require google/apiclient
   ```

3. **Periksa Struktur Direktori**:
   Struktur standar CodeIgniter 4 yang terbentuk:
   ```text
   ├── app/          # Kode utama aplikasi (Controller, Model, View, Config, dll)
   ├── public/       # Folder root web (index.php, aset CSS/JS/Gambar)
   ├── tests/        # Unit testing
   ├── writable/     # Folder untuk log, cache, upload (wajib writeable)
   ├── .env          # File konfigurasi environment (lokal)
   ├── composer.json # Konfigurasi dependensi
   └── spark         # CLI Utility CodeIgniter 4
   ```

---

## 4. Konfigurasi Environment (`.env`)
Sesuai dengan **Standard v2.5**, proyek CodeIgniter 4 wajib menggunakan file `.env`. 

Salin file `env` bawaan menjadi `.env`:
```bash
cp env .env
```

Buka dan sesuaikan file `.env` dengan konfigurasi berikut:

### 4.1 Konfigurasi Aplikasi & Mode Kerja
Ubah mode ke `development` selama masa pembuatan aplikasi agar error log tampil secara detail.
```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------
CI_ENVIRONMENT = development

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------
app.baseURL = 'http://localhost:8080/'
app.forceGlobalSecureRequests = false
```

### 4.2 Konfigurasi Database terpusat
Sesuaikan data koneksi ke MariaDB/MySQL Anda:
```env
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------
database.default.hostname = localhost
database.default.database = db_masjid_agung
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.DBPrefix = 
database.default.port = 3306
```

### 4.3 Konfigurasi Telegram Bot (Security & Monitoring)
Tambahkan konfigurasi Telegram Bot untuk keperluan logging error kritis dan monitoring:
```env
#--------------------------------------------------------------------
# TELEGRAM MONITORING
#--------------------------------------------------------------------
TELEGRAM_BOT_TOKEN = "YOUR_BOT_TOKEN"
TELEGRAM_CHAT_ID = "YOUR_CHAT_ID"
```

### 4.4 Konfigurasi Google OAuth (Google Sign-In)
Tambahkan konfigurasi Google OAuth Client Credentials di `.env` agar dapat terhubung dengan API Google Sign-In:
```env
#--------------------------------------------------------------------
# GOOGLE OAUTH CONFIG
#--------------------------------------------------------------------
google.clientID = "YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com"
google.clientSecret = "YOUR_GOOGLE_CLIENT_SECRET"
google.redirectURI = "http://localhost:8080/auth/google/callback"
```

---

## 5. Security Checklist
Setelah file `.env` dikonfigurasi, pastikan pengaturan keamanan berikut diterapkan di `app/Config/Filters.php`:

1. **CSRF (Cross-Site Request Forgery)**:
   Pastikan filter `csrf` diaktifkan secara global untuk mengamankan semua request bertipe POST, PUT, dan DELETE.
   ```php
   public $globals = [
       'before' => [
           'csrf',
           // ...
       ],
   ];
   ```

2. **XSS (Cross-Site Scripting)**:
   Buat Custom Filter untuk menyaring input kotor atau tag HTML berbahaya sebelum diproses oleh Controller.

---

## 6. Menjalankan Server Lokal
Untuk menjalankan server pengembangan bawaan CodeIgniter 4, gunakan utilitas `spark`:
```bash
php spark serve
```
Aplikasi akan dapat diakses melalui browser di alamat `http://localhost:8080`.
