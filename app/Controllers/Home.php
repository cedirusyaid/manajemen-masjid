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
        if (!empty($realAgenda)) {
            $agendaList = [];
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
        } else {
            // Fallback Dummy Data jika database kosong
            $agendaList = [
                [
                    'judul'      => 'Kajian Rutin Tafsir Al-Qur\'an',
                    'tanggal'    => date('Y-m-d', strtotime('+2 days')),
                    'waktu'      => '18:30:00',
                    'lokasi'     => 'Ruang Utama ' . site_name(),
                    'narasumber' => 'Ustadz DR. H. Muh. Yahya, M.A.',
                    'banner'     => null
                ],
                [
                    'judul'      => 'Tabligh Akbar Menyambut Tahun Baru Hijriah',
                    'tanggal'    => date('Y-m-d', strtotime('+5 days')),
                    'waktu'      => '09:00:00',
                    'lokasi'     => 'Halaman Utama ' . site_name(),
                    'narasumber' => 'Syeikh KH. Rasyid Bakri',
                    'banner'     => null
                ]
            ];
        }

        // 4. Ambil data berita terbit terdekat dari database
        $realBerita = $this->beritaModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll(3);
        if (!empty($realBerita)) {
            $beritaList = [];
            foreach ($realBerita as $row) {
                $beritaList[] = [
                    'judul'      => $row['judul'],
                    'slug'       => $row['slug'],
                    'konten'     => $row['konten'],
                    'created_at' => $row['created_at'],
                    'banner'     => $row['banner']
                ];
            }
        } else {
            // Fallback Dummy Data
            $beritaList = [
                [
                    'judul'      => 'Penyaluran Zakat Fitrah 1447 H Berjalan Lancar',
                    'slug'       => 'penyaluran-zakat-fitrah-berjalan-lancar',
                    'konten'     => site_name() . ' sukses menyalurkan zakat fitrah kepada ratusan mustahik di sekitar wilayah Sinjai Utara...',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 days')),
                    'banner'     => null
                ],
                [
                    'judul'      => 'Pembangunan Menara Masjid Tahap II Dimulai',
                    'slug'       => 'pembangunan-menara-masjid-dimulai',
                    'konten'     => 'Panitia pembangunan resmi memulai pengerjaan fisik menara tahap kedua setelah dana hibah dari Pemda cair...',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
                    'banner'     => null
                ]
            ];
        }

        return render_theme('home', [
            'petugas_jumat' => $petugasJumat,
            'jadwal_sholat' => $jadwalSholat,
            'agenda_list'   => $agendaList,
            'berita_list'   => $beritaList
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
