# 🖥️ Rancangan Modul TV Display Masjid Digital
**Project:** Aplikasi Manajemen Masjid (`manajemen-masjid`)  
**Base Framework:** CodeIgniter 4 (PHP 8.2+)  
**Tanggal Update:** 2026-09-13  
**Versi Dokumen:** v1.2.0 (Dilengkapi Fitur Auto Theme Rotator / Anti Burn-In)  

---

## 1. Pendahuluan & Tujuan
Dokumen ini merupakan rancangan integrasi **Modul TV Display Masjid Digital** ke dalam ekosistem aplikasi **Manajemen Masjid** berbasis CodeIgniter 4. 

Modul ini berfungsi sebagai antarmuka visual interaktif (*Digital Signage*) pada layar Smart TV / Android TV masjid tanpa membutuhkan perangkat komputer tambahan. Tampilan TV memanfaatkan API data terpusat dari aplikasi utama (seperti jadwal sholat, kas keuangan, pengumuman agenda, dan jadwal petugas Jumat).

---

## 2. Arsitektur Integrasi & Relasi Database

```
+-----------------------------------------------------------------------------------+
|                              SMART TV / ANDROID TV                                |
|  +-----------------------------------------------------------------------------+  |
|  |             Kiosk Engine (Fully Kiosk Browser / Auto-Boot App)             |  |
|  |  +-----------------------------------------------------------------------+  |  |
|  |  |  Frontend Display (HTML5, CSS Flexbox/Grid, Theme Rotator, JS, PWA)  |  |  |
|  |  +-----------------------------------------------------------------------+  |  |
|  +------------------------------------^----------------------------------------+  |
+---------------------------------------|-------------------------------------------+
| Fetch API (JSON) / 30 Detik
v
+-----------------------------------------------------------------------------------+
|                        CODEIGNITER 4 BACKEND (`manajemen-masjid`)                  |
|  +-----------------------------------------------------------------------------+  |
|  | RESTful Controller: `App\Controllers\Api\DisplayController.php`             |  |
|  +-----------------------------------------------------------------------------+  |
|                                       |                                           |
|                                       v                                           |
|  +-----------------------------------------------------------------------------+  |
|  | Models CI4 & Database MariaDB / MySQL                                       |  |
|  | - `SettingModel`    (`sys_settings`): Konfigurasi Nama Masjid & GPS           |  |
|  | - `KeuanganModel`  (`trn_keuangan`): Rekap Kas Masuk / Keluar / Saldo         |  |
|  | - `AgendaModel`    (`mst_agenda`): Banner & Pengumuman Agenda               |  |
|  | - `JadwalJumatModel`(`trn_jadwal_jumat` -> `mst_imam_khatib` -> `mst_personil`) |  |
|  +-----------------------------------------------------------------------------+  |
+-----------------------------------------------------------------------------------+
```

---

## 3. Spesifikasi Fungsional Frontend Display

### A. Komponen Utama Layar (16:9 Aspect Ratio)
1. **Header Section:**
   - Nama & Alamat Resmi Masjid (dari `sys_settings` / `AppConfig`).
   - Jam Digital Real-Time (Presisi Jam:Menit:Detik).
   - Penanggalan Masehi & Hijriah otomatis.
2. **Main Content Section (Dynamic Carousel & Grid):**
   - Poster / Banner Agenda Kegiatan (`mst_agenda`).
   - Informative Cards: Laporan Kas Keuangan Bulanan & Jadwal Petugas Salat Jumat Terdekat (`khatib_nama`, `imam_nama`, `muadzin_nama`).
3. **Jadwal Sholat Grid (Bar Bawah):**
   - Menampilkan 7 Waktu: Imsak, Subuh, Syuruq, Dzuhur, Ashar, Maghrib, Isya.
   - Penanda aktif visual untuk waktu sholat berikutnya.
4. **Footer Running Text (Marquee):**
   - Pengumuman darurat, pesan motivasi/hadis, dan ringkasan saldo kas.
5. **Fitur Auto Theme Rotator (Anti Screen Burn-In & Visual Refresh):**
   - Latar belakang layar berganti palet warna secara otomatis & halus (*smooth CSS transition 2.5s*) setiap **3 menit sekali**.
   - Terdiri dari 5 palet warna islami bernuansa gelap (Deep Ocean Blue, Emerald Green, Royal Midnight Purple, Bronze Warm Amber, dan Slate Dark Blue).
6. **Mode Khusus (Overlay / Screen Saver):**
   - **Mode Countdown Iqomah:** Layar otomatis berubah menjadi timer hitung mundur saat masuk waktu sholat.
   - **Mode Blanking / Standby Sholat:** Layar menjadi gelap atau menampilkan tulisan *"Luruskan dan Rapatkan Shaf"* selama ibadah berlangsung.

---

## 4. Perancangan Backend API (CodeIgniter 4)

### A. Endpoint REST API
* **URL:** `/api/display`
* **Method:** `GET`
* **Response Format:** JSON

### B. Implementasi Controller
`app/Controllers/Api/DisplayController.php`

```php
<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\SettingModel;
use App\Models\AgendaModel;
use App\Models\KeuanganModel;
use App\Models\JadwalJumatModel;

class DisplayController extends ResourceController
{
    protected $format = 'json';

    public function index()
    {
        // 1. Fetch System Settings via SettingModel
        $settingModel = new SettingModel();
        $settings     = $settingModel->getSettings();

        // 2. Fetch Active Agenda via AgendaModel
        $agendaModel = new AgendaModel();
        $agenda      = $agendaModel->where('tanggal >=', date('Y-m-d'))
            ->orderBy('tanggal', 'ASC')
            ->findAll(5);

        // 3. Fetch Kas Summary via KeuanganModel
        $keuanganModel = new KeuanganModel();
        
        $rowMasuk = $keuanganModel->where('tipe', 'masuk')
            ->selectSum('nominal')
            ->first();
        $kasMasuk = (float) ($rowMasuk['nominal'] ?? 0);

        $rowKeluar = $keuanganModel->where('tipe', 'keluar')
            ->selectSum('nominal')
            ->first();
        $kasKeluar = (float) ($rowKeluar['nominal'] ?? 0);

        // 4. Fetch Nearest Friday Schedule via JadwalJumatModel
        $jadwalJumatModel = new JadwalJumatModel();
        $jadwalJumatRaw   = $jadwalJumatModel->getJadwalTerdekat();

        $jadwalJumat = null;
        if ($jadwalJumatRaw) {
            $jadwalJumat = [
                'tanggal'       => $jadwalJumatRaw['tanggal'],
                'judul_khotbah' => $jadwalJumatRaw['judul_khotbah'] ?? '-',
                'khatib'        => $jadwalJumatRaw['khatib_nama'] ?? '-',
                'khatib_foto'   => $jadwalJumatRaw['khatib_foto'] ?? null,
                'imam'          => $jadwalJumatRaw['imam_nama'] ?? '-',
                'imam_foto'     => $jadwalJumatRaw['imam_foto'] ?? null,
                'muadzin'       => $jadwalJumatRaw['muadzin_nama'] ?? '-',
                'muadzin_foto'  => $jadwalJumatRaw['muadzin_foto'] ?? null,
            ];
        }

        $appConfig = config('App');

        $data = [
            'status'  => true,
            'message' => 'Data display berhasil dimuat',
            'data'    => [
                'masjid' => [
                    'nama'      => $settings['nama_masjid'] ?? $appConfig->siteName ?? 'MASJID AGUNG NUJUMUL ITTIHAD',
                    'alamat'    => $settings['alamat_masjid'] ?? $appConfig->siteAddress ?? 'Kabupaten Sinjai',
                    'latitude'  => $settings['latitude'] ?? '-5.1234',
                    'longitude' => $settings['longitude'] ?? '120.1234'
                ],
                'keuangan' => [
                    'total_masuk'  => $kasMasuk,
                    'total_keluar' => $kasKeluar,
                    'saldo'        => ($kasMasuk - $kasKeluar)
                ],
                'jadwal_jumat' => $jadwalJumat,
                'agenda'       => $agenda ?? []
            ]
        ];

        return $this->respond($data);
    }
}
```

---

## 5. Implementasi Frontend Views (`public/display/index.html`)

```html
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TV Display - Masjid Agung Nujumul Ittihad</title>
  <style>
    :root {
      --bg-dark: #0a192f;
      --card-bg: #112240;
      --accent-cyan: #64ffda;
      --text-white: #e6f1ff;
      --text-gold: #ffd166;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background-color: var(--bg-dark);
      color: var(--text-white);
      height: 100vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: background-color 2.5s ease-in-out, color 2.5s ease-in-out;
    }

    header {
      background: var(--card-bg);
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 3px solid var(--accent-cyan);
      transition: background-color 2.5s ease-in-out, border-color 2.5s ease-in-out;
    }

    .masjid-title {
      font-size: 2.2rem;
      color: var(--accent-cyan);
      font-weight: bold;
      transition: color 2.5s ease-in-out;
    }

    .card {
      background: var(--card-bg);
      border-radius: 12px;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, 0.05);
      transition: background-color 2.5s ease-in-out;
    }
  </style>
</head>
<body>

  <!-- Struct & Script dengan Auto Theme Rotator -->
  <script>
    // Palet warna yang berganti halus tiap 3 menit
    const themes = [
      { bg: '#0a192f', card: '#112240', accent: '#64ffda' }, // Ocean Blue
      { bg: '#062c1e', card: '#0d402d', accent: '#50e3c2' }, // Emerald Green
      { bg: '#1a0e2e', card: '#281746', accent: '#a78bfa' }, // Midnight Purple
      { bg: '#241808', card: '#38260f', accent: '#fbbf24' }, // Bronze Amber
      { bg: '#0f172a', card: '#1e293b', accent: '#38bdf8' }  // Slate Blue
    ];
    let currentThemeIndex = 0;

    function rotateTheme() {
      currentThemeIndex = (currentThemeIndex + 1) % themes.length;
      const t = themes[currentThemeIndex];
      document.documentElement.style.setProperty('--bg-dark', t.bg);
      document.documentElement.style.setProperty('--card-bg', t.card);
      document.documentElement.style.setProperty('--accent-cyan', t.accent);
    }
    setInterval(rotateTheme, 180000); // 3 Menit
  </script>
</body>
</html>
```

---

*Dokumen Rancangan TV Display Masjid Digital - CodeIgniter 4*
