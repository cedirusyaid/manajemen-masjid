# Panduan Konfigurasi Google OAuth Client
**Tanggal:** 2026-06-19  
**Versi Dokumen:** v1.0.0  
**Status:** Disetujui  
**Penyusun:** Kirana (AI Assistant)

---

## 1. Pendahuluan
Dokumen ini disusun untuk memberikan panduan langkah demi langkah bagi Administrator dalam melakukan pendaftaran dan pembuatan **Google OAuth 2.0 Client Credentials** di Google Cloud Console. Kredensial ini diperlukan agar fitur login satu-klik menggunakan akun Google (*Google Sign-In*) pada Website Masjid Agung Nujumul Ittihad Sinjai dapat berfungsi dengan aman dan lancar.

---

## 2. Langkah 1: Akses Google Cloud Console & Buat Proyek
1. Buka browser dan akses [Google Cloud Console](https://console.cloud.google.com/).
2. Masuk menggunakan akun Google (Gmail) yang akan digunakan sebagai pengelola kredensial sistem.
3. Di pojok kiri atas (sebelah logo *Google Cloud*), klik menu dropdown proyek aktif.
4. Klik tombol **New Project** (Proyek Baru) di bagian kanan atas jendela modal.
5. Masukkan data proyek:
   - **Project name:** `Masjid Agung Sinjai` (atau nama lain yang mudah dikenali).
   - **Location:** Biarkan default (`No organization`).
6. Klik **Create** dan tunggu beberapa saat hingga pembuatan proyek selesai. Pastikan proyek baru tersebut dipilih sebagai proyek aktif sebelum melanjutkan ke langkah berikutnya.

---

## 3. Langkah 2: Konfigurasi OAuth Consent Screen (Layar Persetujuan)
Sebelum membuat kredensial, Anda wajib mengonfigurasi layar persetujuan yang akan ditampilkan kepada pengguna ketika mereka masuk menggunakan Google.

1. Buka menu navigasi utama di pojok kiri atas (ikon tiga garis) > pilih **APIs & Services** > klik **OAuth consent screen**.
2. Pada pilihan **User Type**, pilih **External** (agar dapat diakses oleh akun ustadz/pengurus dari domain gmail umum).
3. Klik **Create**.
4. Isi data **App Information** (Informasi Aplikasi):
   - **App name:** `Sistem Masjid Agung Sinjai`.
   - **User support email:** Pilih email Anda yang aktif dari dropdown.
   - **App logo:** Kosongkan (opsional).
5. Isi data **Developer contact information**:
   - **Email addresses:** Isi dengan email administrator sistem (contoh: `admin@sinjaikab.go.id`).
6. Klik **Save and Continue**.
7. Pada langkah **Scopes** (Cakupan Akses):
   - Klik **Add or Remove Scopes**.
   - Centang cakupan `/auth/userinfo.email` dan `/auth/userinfo.profile`.
   - Klik **Update** di bagian bawah, lalu klik **Save and Continue**.
8. Pada langkah **Test Users** (Pengguna Uji Coba):
   - Selama status aplikasi masih *Testing* (Belum dipublikasikan), hanya email yang didaftarkan di sini yang bisa melakukan login Google.
   - Klik **Add Users** dan masukkan alamat email Gmail pengurus atau admin yang akan digunakan untuk pengujian (contoh: `mrusyaid@sinjaikab.go.id`).
   - Klik **Save and Continue**.
9. Periksa ringkasan konfigurasi pada layar terakhir, lalu klik **Back to Dashboard**.

---

## 4. Langkah 3: Membuat Kredensial OAuth Client ID
Setelah layar persetujuan siap, ikuti langkah berikut untuk membuat kunci akses:

1. Pada menu sisi kiri, klik tab **Credentials** (Kredensial).
2. Klik tombol **+ Create Credentials** di bagian atas halaman > pilih **OAuth client ID**.
3. Pada dropdown **Application type**, pilih **Web application**.
4. Isi konfigurasi web client:
   - **Name:** `Web Client Masjid Agung`.
   - **Authorized JavaScript origins:** (Domain asal aplikasi Anda)
     - Klik **+ Add URI** dan masukkan URL dasar web (tanpa path di belakangnya).
     * Contoh lokal: `http://localhost:8080`
     * Contoh server live: `https://masjidagungsinjai.or.id`
   - **Authorized redirect URIs:** (URL callback yang akan memproses token autentikasi)
     - Klik **+ Add URI** dan masukkan alamat rute callback OAuth aplikasi.
     * Alamat lokal: `http://localhost:8080/auth/google/callback`
     * Alamat server live: `https://masjidagungsinjai.or.id/auth/google/callback`
5. Klik **Create**.
6. Jendela pop-up baru akan muncul menampilkan data kredensial:
   - **Your Client ID** (Kunci identifikasi publik aplikasi).
   - **Your Client Secret** (Kunci rahasia aplikasi - *jaga kerahasiaannya!*).
7. Salin kedua nilai tersebut atau unduh berkas JSON kredensialnya.

---

## 5. Langkah 4: Penerapan pada Aplikasi Website Masjid
Setelah berhasil mendapatkan Client ID dan Client Secret, Anda perlu memasukkannya ke dalam konfigurasi aplikasi.

### A. Konfigurasi Environment (`.env`)
Buka berkas konfigurasi lokal **[.env](file:///apps/masjidagung/.env)** Anda dan perbarui baris konfigurasi berikut:

```env
#--------------------------------------------------------------------
# GOOGLE OAUTH CONFIG
#--------------------------------------------------------------------
google.clientID = "MASUKKAN_CLIENT_ID_ANDA_DI_SINI.apps.googleusercontent.com"
google.clientSecret = "MASUKKAN_CLIENT_SECRET_ANDA_DI_SINI"
google.redirectURI = "http://localhost:8080/auth/google/callback"
```
> [!IMPORTANT]
> Pastikan nilai `google.redirectURI` di file `.env` sama persis dengan URI redirect yang Anda daftarkan di Google Cloud Console pada Langkah 3 nomor 4. Perbedaan satu karakter (seperti penggunaan `https` vs `http` atau penambahan tanda slash `/` di akhir rute) akan mengakibatkan error `redirect_uri_mismatch`.

### B. Registrasi Akun Pengurus
Agar login Google berhasil masuk ke dashboard, daftarkan email Gmail yang bersangkutan ke dalam database pada tabel `sys_users`.
* Contoh query SQL untuk mendaftarkan email admin utama:
  ```sql
  UPDATE sys_users SET email = 'email_anda_yang_dites@gmail.com' WHERE username = 'admin';
  ```

---

## 6. Langkah 5: Publikasi Aplikasi (Opsional)
Jika aplikasi website sudah siap digunakan oleh publik/seluruh pengurus secara luas di server produksi:
1. Kembali ke Google Cloud Console > **OAuth consent screen**.
2. Di bawah nama aplikasi, klik tombol **Publish App** (Publikasikan Aplikasi).
3. Konfirmasi pilihan Anda. 
4. Aplikasi akan beralih status ke *In Production* sehingga seluruh email Gmail pengurus dapat langsung melakukan login tanpa perlu didaftarkan satu per satu sebagai *Test Users*.
