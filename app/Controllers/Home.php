<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use App\Models\BeritaModel;
use App\Models\JadwalJumatModel;
use Exception;

class Home extends BaseController
{
    protected $agendaModel;
    protected $beritaModel;
    protected $jadwalJumatModel;

    public function __construct()
    {
        $this->agendaModel      = new \App\Models\AgendaModel();
        $this->beritaModel      = new \App\Models\BeritaModel();
        $this->jadwalJumatModel = new JadwalJumatModel();
        helper(['url', 'date', 'site_helper']);
    }

    public function index()
    {
        // 1. Ambil data petugas Jumat terdekat
        $petugasJumat = $this->jadwalJumatModel->getJadwalTerdekat();

        // 2. Dapatkan Jadwal Sholat Hari Ini secara dinamis
        $jadwalSholat = $this->getJadwalSholat();

        // 3. Ambil data agenda terdekat dari database
        $realAgenda = $this->agendaModel->getAgendaTerdekat(3);
        $agendaList = [];
        if (!empty($realAgenda)) {
            foreach ($realAgenda as $row) {
                $agendaList[] = [
                    'judul'      => $row['judul'],
                    'tanggal'    => $row['tanggal'],
                    'waktu'      => $row['waktu'],
                    'lokasi'     => $row['lokasi'],
                    'narasumber' => $row['narasumber_id'] ? $row['nama_ustadz'] : $row['narasumber'],
                    'banner'     => $row['banner']
                ];
            }
        }

        // 4. Ambil data berita terbit terdekat dari database
        $realBerita = $this->beritaModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll(3);
        $beritaList = [];
        if (!empty($realBerita)) {
            foreach ($realBerita as $row) {
                $beritaList[] = [
                    'judul'      => $row['judul'],
                    'slug'       => $row['slug'],
                    'konten'     => $row['konten'],
                    'created_at' => $row['created_at'],
                    'banner'     => $row['banner']
                ];
            }
        }

        $rekeningModel = new \App\Models\RekeningModel();
        $rekeningList  = $rekeningModel->getActiveChannels();

        $layananModel = new \App\Models\LayananModel();
        $layananList  = $layananModel->getLayananAktif();

        return render_theme('home', [
            'petugas_jumat' => $petugasJumat,
            'jadwal_sholat' => $jadwalSholat,
            'agenda_list'   => $agendaList,
            'berita_list'   => $beritaList,
            'rekening_list' => $rekeningList,
            'layanan_list'  => $layananList
        ]);
    }

    /**
     * Halaman Publik Khusus Panitia Pembangunan Masjid Agung Sinjai
     */
    public function pembangunan($id = null)
    {
        $kegiatanModel = new \App\Models\KegiatanModel();

        if ($id) {
            $kegiatan = $kegiatanModel->find($id);
        } else {
            // Default: Panitia Pembangunan aktif terbaru
            $kegiatan = $kegiatanModel->where('deleted_at', null)
                                      ->orderBy('created_at', 'DESC')
                                      ->first();
        }

        if (!$kegiatan) {
            return redirect()->to('/')->with('error', 'Informasi kepanitiaan tidak ditemukan.');
        }

        $kegiatanId = $kegiatan['id'];

        $jabatanKegiatanModel = new \App\Models\JabatanKegiatanModel();
        $panitiaModel = new \App\Models\PanitiaModel();
        $kelompokKegiatanModel = new \App\Models\KelompokKegiatanModel();
        $anggotaKelompokModel = new \App\Models\AnggotaKelompokModel();
        $keuanganModel = new \App\Models\KeuanganModel();
        $bantuanMaterialModel = new \App\Models\BantuanMaterialModel();
        $rekeningModel = new \App\Models\RekeningModel();
        $agendaModel = new \App\Models\AgendaModel();

        // 1. Ambil jajaran struktur jabatan & personil panitia
        $panitiaList = $panitiaModel->getPanitiaByKegiatan($kegiatanId);
        $jabatanList = $jabatanKegiatanModel->getJabatanByKegiatan($kegiatanId);

        foreach ($jabatanList as &$jabatan) {
            $jabatan['panitia'] = array_values(array_filter($panitiaList, function($p) use ($jabatan) {
                return $p['jabatan_kegiatan_id'] === $jabatan['id'];
            }));
        }

        // 2. Ambil kelompok kerja lapangan & anggota jemaah
        $kelompokList = $kelompokKegiatanModel->getKelompokByKegiatan($kegiatanId);
        foreach ($kelompokList as &$kelompok) {
            $kelompok['anggota'] = $anggotaKelompokModel->getAnggotaByKelompok($kelompok['id']);
        }

        // 3. Transparansi Kas Keuangan Proyek
        $keuanganList = $keuanganModel->where('kegiatan_id', $kegiatanId)
                                      ->where('deleted_at', null)
                                      ->orderBy('tanggal', 'DESC')
                                      ->orderBy('created_at', 'DESC')
                                      ->findAll();

        $totalMasuk  = 0;
        $totalKeluar = 0;
        foreach ($keuanganList as $k) {
            if ($k['tipe'] === 'masuk') {
                $totalMasuk += $k['nominal'];
            } else {
                $totalKeluar += $k['nominal'];
            }
        }
        $saldoKas = $totalMasuk - $totalKeluar;

        // 4. Rekap Bantuan Material Nontunai
        $materialList = $bantuanMaterialModel->getMaterialByKegiatan($kegiatanId);
        $totalNilaiMaterial = 0;
        foreach ($materialList as $m) {
            $totalNilaiMaterial += ($m['total_nilai'] ?: ((float)($m['harga_satuan'] ?? 0) * (float)($m['volume'] ?? 0)));
        }

        // 5. Rekening Donasi Pembangunan & Agenda Proyek
        $rekeningList = $rekeningModel->getActiveChannels();
        $agendaList   = $agendaModel->where('kegiatan_id', $kegiatanId)
                                    ->where('deleted_at', null)
                                    ->orderBy('tanggal', 'ASC')
                                    ->findAll();

        return render_theme('kepanitiaan', [
            'kegiatan'             => $kegiatan,
            'jabatan_list'         => $jabatanList,
            'panitia_list'         => $panitiaList,
            'kelompok_list'        => $kelompokList,
            'keuangan_list'        => $keuanganList,
            'total_masuk'          => $totalMasuk,
            'total_keluar'         => $totalKeluar,
            'saldo_kas'            => $saldoKas,
            'material_list'        => $materialList,
            'total_nilai_material' => $totalNilaiMaterial,
            'rekening_list'        => $rekeningList,
            'agenda_list'          => $agendaList
        ]);
    }

    /**
     * Mengambil jadwal sholat via API publik dengan Fallback Local Cache
     */
    private function getJadwalSholat(): array
    {
        $today = date('Y-m-d');
        $cacheKey = 'sholat_jadwal_' . $today;

        // Coba ambil dari cache CodeIgniter 4
        if ($jadwal = cache($cacheKey)) {
            return $jadwal;
        }

        // 1. Prioritaskan master hisab lokal dari database (mst_jadwal_sholat)
        try {
            $jadwalSholatModel = new \App\Models\JadwalSholatModel();
            $dbJadwal = $jadwalSholatModel->getHariIni();
            if ($dbJadwal) {
                $jadwalFormat = [
                    'tanggal' => date('d-m-Y'),
                    'imsak'   => $dbJadwal['imsak'],
                    'subuh'   => $dbJadwal['subuh'],
                    'terbit'  => $dbJadwal['terbit'],
                    'dhuha'   => $dbJadwal['dhuha'],
                    'dzuhur'  => $dbJadwal['dzuhur'],
                    'ashar'   => $dbJadwal['ashar'],
                    'maghrib' => $dbJadwal['maghrib'],
                    'isya'    => $dbJadwal['isya']
                ];
                cache()->save($cacheKey, $jadwalFormat, 43200);
                return $jadwalFormat;
            }
        } catch (\Throwable $e) {
            // Lanjut ke fallback / API jika belum ada database
        }

        // Target API Kemenag via myQuran dengan ID Kota terkonfigurasi (DB dengan fallback)
        $settingModel = new \App\Models\SettingModel();
        $kotaId = $settingModel->getSetting('sholat_kota_id') ?? (config('App')->sholatKotaId ?? '2616');
        $url = "https://api.myquran.com/v2/sholat/jadwal/{$kotaId}/" . date('Y/m/d');

        $fallbackJadwal = [
            'tanggal' => date('d-m-Y'),
            'imsak'   => '04:35',
            'subuh'   => '04:45',
            'terbit'  => '06:02',
            'dhuha'   => '06:30',
            'dzuhur'  => '12:05',
            'ashar'   => '15:26',
            'maghrib' => '18:03',
            'isya'    => '19:17'
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); // Timeout cepat agar load page tidak macet
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && !empty($response)) {
                $resData = json_decode($response, true);
                if (isset($resData['status']) && $resData['status'] === true && isset($resData['data']['jadwal'])) {
                    $apiJadwal = $resData['data']['jadwal'];
                    $jadwalFormat = [
                        'tanggal' => $apiJadwal['tanggal'],
                        'imsak'   => $apiJadwal['imsak'],
                        'subuh'   => $apiJadwal['subuh'],
                        'terbit'  => $apiJadwal['terbit'],
                        'dhuha'   => $apiJadwal['dhuha'],
                        'dzuhur'  => $apiJadwal['dzuhur'],
                        'ashar'   => $apiJadwal['ashar'],
                        'maghrib' => $apiJadwal['maghrib'],
                        'isya'    => $apiJadwal['isya']
                    ];

                    // Simpan di cache selama 12 jam
                    cache()->save($cacheKey, $jadwalFormat, 43200);

                    return $jadwalFormat;
                }
            }
        } catch (Exception $e) {
            log_message('error', 'Jadwal Sholat API Error: ' . $e->getMessage());
        }

        return $fallbackJadwal;
    }
}
