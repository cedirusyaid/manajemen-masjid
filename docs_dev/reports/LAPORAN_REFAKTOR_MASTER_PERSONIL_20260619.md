# LAPORAN REFAKTORISASI DATA MASTER PERSONEL TERPADU
**Tanggal:** 2026-06-19  
**Versi Dokumen:** v1.0.0  
**Status:** Disetujui  
**Penyusun:** Alexa (AI Assistant)

---

## 1. Deskripsi Masalah
Sebelum dilakukan refaktorisasi, data personal individu (seperti nama lengkap, nomor HP, email, dan foto profil) disimpan secara redundan (inline) di beberapa tabel berbeda:
- `trn_pengurus`
- `trn_panitia`
- `mst_imam_khatib`

Redundansi ini menimbulkan masalah inkonsistensi data ketika terdapat pembaruan informasi kontak (misal nomor WhatsApp) dari seorang personel yang menjabat di beberapa struktur sekaligus, serta mempersulit pelacakan kontribusi individu dalam berbagai kegiatan masjid.

---

## 2. Analisis Teknis (RCA)
1. **Redundansi Kolom**: Penyimpanan data pribadi langsung di tabel relasional transaksi merusak prinsip normalisasi basis data (minimal 3NF).
2. **Keterbatasan Kategori**: Tidak adanya wadah mandiri untuk menyimpan profil jemaah umum yang bukan merupakan pengurus aktif atau panitia kegiatan.
3. **Collation Conflict**: Saat migrasi database awal, terdapat perbedaan collation antara tabel `mst_imam_khatib` (`utf8mb4_unicode_ci`) dengan tabel transaksi lainnya (`utf8mb4_general_ci`) yang sempat menghambat pendefinisian kunci asing (*foreign key*).

---

## 3. Langkah Perbaikan
1. **Penyelarasan Collation**: Mengubah collation seluruh tabel database secara seragam ke `utf8mb4_general_ci` untuk memastikan kelancaran pembuatan foreign key constraint.
2. **Pembuatan Tabel Master**: Mendefinisikan tabel master terpusat `mst_personil` sebagai *Single Source of Truth* profil personal.
3. **Migrasi Data & Pembersihan Kolom**:
   - Memindahkan data ustadz default dari tabel petugas Jumat ke tabel `mst_personil`.
   - Menghapus kolom redundan (`nama`, `no_hp`, `email`, `foto`) pada tabel `trn_pengurus`, `trn_panitia`, dan `mst_imam_khatib`.
   - Menambahkan kolom kunci asing `personil_id` pada ketiga tabel tersebut untuk menghubungkan rekaman ke tabel `mst_personil`.
4. **Implementasi CRUD Personil**: Membuat `PersonilModel`, `PersonilController`, dan antarmuka pengelolaan personel (`app/Views/dashboard/personil/`).
5. **Refaktor Kueri Model & Form CRUD**:
   - Memperbarui join model `PengurusModel`, `PanitiaModel`, dan `JadwalJumatModel` agar menarik profil dinamis dari `mst_personil`.
   - Mengubah form input nama dan kontak pada form kepengurusan dan kepanitiaan menjadi select dropdown personel.
   - Menyisipkan tautan navigasi "Master Personel" di seluruh file view sidebar.

---

## 4. Hasil Validasi
1. **Uji Sintaks PHP (Linting)**: Seluruh file PHP yang dimodifikasi (`app/Config/Routes.php`, controller, model, view baru) telah diuji via CLI (`php -l`) dengan hasil 100% bebas syntax error.
2. **Integritas Referensial**: Query database MySQL berhasil mengeksekusi join tabel pengurus, panitia, dan jadwal petugas salat Jumat secara konsisten.
