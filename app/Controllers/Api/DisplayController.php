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

        // 2. Fetch Active Agenda via AgendaModel & Published Pengumuman via BeritaModel
        $agendaModel = new AgendaModel();
        $agenda      = $agendaModel->getAgendaTerdekat(5);

        $beritaModel = new \App\Models\BeritaModel();
        $pengumuman  = $beritaModel->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll(3);

        // 3. Fetch Kas Umum Masjid (Periode Mingguan: Masuk Sabtu s.d Jumat, Saldo Awal s.d Jumat Lalu)
        $keuanganModel = new KeuanganModel();
        
        $today = new \DateTime(date('Y-m-d'));
        $dayOfWeek = (int)$today->format('w'); // 0=Min, 1=Sen, ..., 5=Jum, 6=Sab
        
        // Tentukan awal pekan berjalan (Hari Sabtu)
        if ($dayOfWeek === 6) {
            $startPekan = clone $today;
        } else {
            $startPekan = clone $today;
            $startPekan->modify('last saturday');
        }
        
        // Tanggal batas akhir Jumat sebelumnya (Cutoff Saldo Awal)
        $endJumatLalu = clone $startPekan;
        $endJumatLalu->modify('-1 day');
        
        // Tanggal akhir pekan berjalan (Hari Jumat ini)
        $endJumatIni = clone $startPekan;
        $endJumatIni->modify('+6 days');
        
        $tglStartPekan = $startPekan->format('Y-m-d');
        $tglEndJumatLalu = $endJumatLalu->format('Y-m-d');
        $tglEndJumatIni = $endJumatIni->format('Y-m-d');
        
        // A. Hitung Saldo Awal (Semua transaksi s.d Jumat Sebelumnya)
        $rowMasukAwal = $keuanganModel->where('kegiatan_id', null)
            ->where('tipe', 'masuk')
            ->where('tanggal <=', $tglEndJumatLalu)
            ->where('deleted_at', null)
            ->selectSum('nominal')
            ->first();
        $kasMasukAwal = (float) ($rowMasukAwal['nominal'] ?? 0);
        
        $rowKeluarAwal = $keuanganModel->where('kegiatan_id', null)
            ->where('tipe', 'keluar')
            ->where('tanggal <=', $tglEndJumatLalu)
            ->where('deleted_at', null)
            ->selectSum('nominal')
            ->first();
        $kasKeluarAwal = (float) ($rowKeluarAwal['nominal'] ?? 0);
        $saldoAwal = $kasMasukAwal - $kasKeluarAwal;
        
        // B. Hitung Pemasukan & Pengeluaran Pekan Ini (Mulai Sabtu s.d Hari ini / Jumat ini)
        $rowMasukPekan = $keuanganModel->where('kegiatan_id', null)
            ->where('tipe', 'masuk')
            ->where('tanggal >=', $tglStartPekan)
            ->where('deleted_at', null)
            ->selectSum('nominal')
            ->first();
        $kasMasukPekan = (float) ($rowMasukPekan['nominal'] ?? 0);
        
        $rowKeluarPekan = $keuanganModel->where('kegiatan_id', null)
            ->where('tipe', 'keluar')
            ->where('tanggal >=', $tglStartPekan)
            ->where('deleted_at', null)
            ->selectSum('nominal')
            ->first();
        $kasKeluarPekan = (float) ($rowKeluarPekan['nominal'] ?? 0);
        
        // C. Saldo Akhir Berjalan
        $saldoAkhir = $saldoAwal + $kasMasukPekan - $kasKeluarPekan;
        
        $lastRow = $keuanganModel->where('kegiatan_id', null)
            ->where('deleted_at', null)
            ->orderBy('tanggal', 'DESC')
            ->first();
        $lastUpdateKeuangan = $lastRow['tanggal'] ?? null;

        // 4. Fetch 3 Upcoming Friday Schedules via JadwalJumatModel
        $jadwalJumatModel  = new JadwalJumatModel();
        $jadwalJumatRawList = $jadwalJumatModel->getJadwalMendatang(3);

        $jadwalJumatList = [];
        foreach ($jadwalJumatRawList as $j) {
            $jadwalJumatList[] = [
                'tanggal'       => $j['tanggal'],
                'judul_khotbah' => $j['judul_khotbah'] ?? null,
                'khatib'        => $j['khatib_nama'] ?? null,
                'khatib_foto'   => $j['khatib_foto'] ?? null,
                'imam'          => $j['imam_nama'] ?? null,
                'imam_foto'     => $j['imam_foto'] ?? null,
                'muadzin'       => $j['muadzin_nama'] ?? null,
                'muadzin_foto'  => $j['muadzin_foto'] ?? null,
            ];
        }

        $jadwalJumatSingle = $jadwalJumatList[0] ?? null;

        // 5. Fetch Active Donation Channels via RekeningModel
        $rekeningModel = new \App\Models\RekeningModel();
        $donasiList    = $rekeningModel->getActiveChannels();
        foreach ($donasiList as &$rek) {
            $rek['logo_url'] = !empty($rek['logo']) ? base_url('uploads/rekening/' . $rek['logo']) : null;
        }
        unset($rek);

        $appConfig = config('App');

        // 6. Get Prayer Times
        $jadwalSholat = $this->getJadwalSholat();

        // 7. Fetch Panitia Pembangunan Proyek Data
        $kegiatanModel = new \App\Models\KegiatanModel();
        $kegiatanPembangunan = $kegiatanModel->where('deleted_at', null)
                                            ->orderBy('created_at', 'DESC')
                                            ->first();

        $pembangunanData = null;
        if ($kegiatanPembangunan) {
            $kegId = $kegiatanPembangunan['id'];
            
            // Keuangan Pembangunan
            $pembangunanMasuk = (float)($keuanganModel->where('kegiatan_id', $kegId)->where('tipe', 'masuk')->where('deleted_at', null)->selectSum('nominal')->first()['nominal'] ?? 0);
            $pembangunanKeluar = (float)($keuanganModel->where('kegiatan_id', $kegId)->where('tipe', 'keluar')->where('deleted_at', null)->selectSum('nominal')->first()['nominal'] ?? 0);
            $pembangunanSaldo = $pembangunanMasuk - $pembangunanKeluar;

            // Material Nontunai
            $bantuanMaterialModel = new \App\Models\BantuanMaterialModel();
            $materialList = $bantuanMaterialModel->getMaterialByKegiatan($kegId);
            $totalNilaiMaterial = 0;
            foreach ($materialList as $m) {
                $nilai = ($m['total_nilai'] ?: ((float)($m['harga_satuan'] ?? 0) * (float)($m['volume'] ?? 0)));
                $totalNilaiMaterial += $nilai;
            }
            $recentMaterial = array_slice($materialList, 0, 4);

            $targetDana = (float)($kegiatanPembangunan['target_dana'] ?? 0);
            $persentase = $targetDana > 0 ? min(100, round(($pembangunanMasuk / $targetDana) * 100, 1)) : 0;

            $pembangunanData = [
                'id'                   => $kegId,
                'nama_kegiatan'        => $kegiatanPembangunan['nama_kegiatan'],
                'deskripsi'            => $kegiatanPembangunan['deskripsi'],
                'target_dana'          => $targetDana,
                'total_masuk'          => $pembangunanMasuk,
                'total_keluar'         => $pembangunanKeluar,
                'saldo'                => $pembangunanSaldo,
                'persentase'           => $persentase,
                'total_nilai_material' => $totalNilaiMaterial,
                'total_dukungan_semua' => ($pembangunanMasuk + $totalNilaiMaterial),
                'daftar_material'      => $recentMaterial,
                'status'               => $kegiatanPembangunan['status']
            ];
        }

        $data = [
            'status'  => true,
            'message' => 'Data display berhasil dimuat',
            'data'    => [
                'display_type'       => $settings['display_type'] ?? 'slideshow',
                'slideshow_duration' => (int) ($settings['slideshow_duration'] ?? 10),
                'masjid' => [
                    'nama'      => $settings['site_name'] ?? $settings['nama_masjid'] ?? site_name(),
                    'alamat'    => $settings['site_address'] ?? $settings['alamat_masjid'] ?? site_address(),
                    'latitude'  => $settings['latitude'] ?? '-5.1242',
                    'longitude' => $settings['longitude'] ?? '120.2536'
                ],
                'jadwal_sholat' => $jadwalSholat,
                'display_blank_settings' => [
                    'before_prayer' => (int) ($settings['blank_before_prayer'] ?? 0),
                    'subuh'         => (int) ($settings['blank_duration_subuh'] ?? 25),
                    'dzuhur'        => (int) ($settings['blank_duration_dzuhur'] ?? 20),
                    'ashar'         => (int) ($settings['blank_duration_ashar'] ?? 20),
                    'maghrib'       => (int) ($settings['blank_duration_maghrib'] ?? 20),
                    'isya'          => (int) ($settings['blank_duration_isya'] ?? 25),
                    'jumat'         => (int) ($settings['blank_duration_jumat'] ?? 45)
                ],
                'pembangunan'   => $pembangunanData,
                'keuangan' => [
                    'saldo_awal'        => $saldoAwal,
                    'pemasukan_pekan'   => $kasMasukPekan,
                    'pengeluaran_pekan' => $kasKeluarPekan,
                    'saldo_akhir'       => $saldoAkhir,
                    'periode_label'     => 'Pekan ' . date('d/m', strtotime($tglStartPekan)) . ' s/d ' . date('d/m', strtotime($tglEndJumatIni)),
                    'cutoff_awal_label' => date('d/m/Y', strtotime($tglEndJumatLalu)),
                    'total_masuk'       => $kasMasukPekan,
                    'total_keluar'      => $kasKeluarPekan,
                    'saldo'             => $saldoAkhir,
                    'last_update'       => $lastUpdateKeuangan
                ],
                'jadwal_jumat'      => $jadwalJumatSingle,
                'jadwal_jumat_list' => $jadwalJumatList,
                'agenda'            => $agenda ?? [],
                'pengumuman'        => $pengumuman ?? [],
                'ayat_pilihan'      => (new \App\Models\AyatPilihanModel())->getAyatAktif(),
                'donasi'            => $donasiList ?? [],
                'qris_data'         => $settings['qris_data'] ?? 'MasjidAgungSinjaiQRIS'
            ]
        ];

        return $this->respond($data);
    }

    private function getJadwalSholat(): array
    {
        $today = date('Y-m-d');
        $cacheKey = 'sholat_jadwal_' . $today;

        if ($jadwal = cache($cacheKey)) {
            return $jadwal;
        }

        // 1. Cek dari Master Database Lokal (mst_jadwal_sholat)
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
            // Abaikan dan lanjut ke sumber alternatif
        }

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
            $settingModel = new SettingModel();
            $kotaId = $settingModel->getSetting('sholat_kota_id') ?? (config('App')->sholatKotaId ?? '2616');
            $url = "https://api.myquran.com/v2/sholat/jadwal/{$kotaId}/" . date('Y/m/d');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
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
                    cache()->save($cacheKey, $jadwalFormat, 43200);
                    return $jadwalFormat;
                }
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return $fallbackJadwal;
    }
}
