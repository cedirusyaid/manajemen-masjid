# Panduan Deploy & Auto-Deployment Website
**Tanggal:** 2026-06-20  
**Versi Dokumen:** v1.0.0  
**Status:** Draf  
**Penyusun:** Alexa (AI Assistant)  

---

## 1. Pendahuluan
Dokumen ini disusun untuk menjelaskan kesiapan dan proses instalasi aplikasi Website Masjid Agung Nujumul Ittihad Sinjai di lingkungan server produksi (Debian 12). Panduan ini memuat langkah-langkah setup, inisialisasi database, konfigurasi keamanan, dan sistem auto-deployment otomatis berbasis Git Webhook.

---

## 2. Prasyarat Lingkungan Server Produksi
Sistem produksi dirancang untuk berjalan pada lingkungan Linux dengan spesifikasi sebagai berikut (mengacu pada **Linux Environment Standard v2.5**):

- **Sistem Operasi**: Debian 12 / Ubuntu 22.04 LTS.
- **Web Server**: Apache2 atau Nginx.
- **PHP**: Versi 8.2 (dilengkapi ekstensi: `php-intl`, `php-gd`, `php-mysql`, `php-curl`, `php-mbstring`, `php-xml`).
- **Database Server**: MariaDB Server 10.11+ / MySQL 8.0+.
- **Version Control**: Git.
- **Dependency Manager**: Composer v2.x.
- **Keamanan OS**: UFW (Uncomplicated Firewall) aktif dengan port `80` (HTTP), `443` (HTTPS), dan `22` (SSH) terbuka.

---

## 3. Langkah-Langkah Instalasi Produksi

### Langkah 3.1. Clone Repository & Setup Hak Akses
1. Hubungkan ke server produksi melalui SSH:
   ```bash
   ssh user@ip_server
   ```
2. Clone repository ke folder web root (misalnya `/var/www/masjidagung`):
   ```bash
   git clone git@github.com:cedirusyaid/manajemen-masjid.git /var/www/masjidagung
   ```
3. Atur hak kepemilikan folder ke user web server (`www-data`):
   ```bash
   chown -R www-data:www-data /var/www/masjidagung
   ```
4. Pastikan folder writeable memiliki izin tulis:
   ```bash
   chmod -R 775 /var/www/masjidagung/writable
   ```

### Langkah 3.2. Instalasi Dependensi via Composer
Jalankan composer install dengan opsi produksi untuk mengoptimalkan autoloader dan mengecualikan modul development:
```bash
cd /var/www/masjidagung
composer install --no-dev --optimize-autoloader
```

### Langkah 3.3. Inisialisasi Database
1. Buat database baru di MariaDB/MySQL server produksi:
   ```sql
   CREATE DATABASE masjidagung_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
2. Restore skema database fisik awal dari rancangan arsitektur database (`docs_dev/architecture/rancangan_arsitektur_database_2026.md`) atau backup SQL dump terlampir ke database produksi.

### Langkah 3.4. Konfigurasi Environment Produksi (`.env`)
Salin file `env` menjadi `.env` di root project:
```bash
cp env .env
```
Lakukan konfigurasi kunci berikut pada `.env` server produksi:
```env
CI_ENVIRONMENT = production

app.baseURL = 'https://masjidagungnujumulittihad.or.id/'
app.forceGlobalSecureRequests = true

database.default.hostname = localhost
database.default.database = masjidagung_db
database.default.username = prod_user
database.default.password = PASSWORD_AMAN_PRODUKSI

# Konfigurasi Pengaman Webhook Auto-Deploy
DEPLOY_TOKEN = "TOKEN_UNIK_YANG_SANGAT_PANJANG_DAN_ACAK"

# Konfigurasi Telegram Log Error
TELEGRAM_BOT_TOKEN = "8270886210:AAHoidg-_LpnTUBgLys96-U17hHkjUrCAd0"
TELEGRAM_CHAT_ID = "-1002836383641"
```

---

## 4. Antisipasi Auto-Deployment (`Deploy.php`)
Untuk mempermudah pemeliharaan berkelanjutan, aplikasi telah dilengkapi dengan script auto-deployment terisolasi di [Deploy.php](file:///apps/masjidagung/public/Deploy.php) yang ditempatkan langsung pada folder `/public`.

### 4.1. Keamanan & Mekanisme Kerja
- **Bypass CSRF Filter**: Karena diletakkan langsung di dalam folder `/public`, script ini diakses langsung sebagai file statis oleh Apache/Nginx tanpa melalui *routing engine* CodeIgniter 4. Hal ini secara otomatis meniadakan benturan dengan filter CSRF global aplikasi (tidak memerlukan pengecualian manual di `Filters.php`).
- **Token-Based Access**: Akses dibatasi menggunakan parameter query string `token` (misalnya `https://domain.com/Deploy.php?token=TOKEN_ANDA`). Token dicocokkan dengan `DEPLOY_TOKEN` yang ada di `.env` produksi.
- **Fail-Safe Alert**: Jika terjadi kegagalan saat menjalankan `git pull`, `composer install`, atau `php spark optimize`, script akan otomatis mengirimkan notifikasi kegagalan detail beserta log error ke Telegram Monitoring Group.

### 4.2. Cara Integrasi Webhook (GitHub)
1. Buka repositori GitHub proyek, lalu navigasikan ke **Settings > Webhooks > Add webhook**.
2. Masukkan Payload URL dengan format:
   `https://masjidagungnujumulittihad.or.id/Deploy.php?token=TOKEN_UNIK_YANG_SANGAT_PANJANG_DAN_ACAK`
3. Atur Content type ke `application/json`.
4. Pilih trigger event: **Just the push event** (pada branch `main`).
5. Simpan Webhook. Setiap kali ada push ke branch `main`, server produksi akan secara otomatis memperbarui kode program.
