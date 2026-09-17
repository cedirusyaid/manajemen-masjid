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
        $agenda      = $agendaModel->where('tanggal >=', date('Y-m-d'))
            ->orderBy('tanggal', 'ASC')
            ->findAll(5);

        $beritaModel = new \App\Models\BeritaModel();
        $pengumuman  = $beritaModel->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll(3);

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

        $lastRow = $keuanganModel->orderBy('tanggal', 'DESC')->first();
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

        $appConfig = config('App');

        $data = [
            'status'  => true,
            'message' => 'Data display berhasil dimuat',
            'data'    => [
                'display_type' => $settings['display_type'] ?? 'slideshow',
                'masjid' => [
                    'nama'      => $settings['nama_masjid'] ?? $appConfig->siteName ?? 'MASJID AGUNG NUJUMUL ITTIHAD',
                    'alamat'    => $settings['alamat_masjid'] ?? $appConfig->siteAddress ?? 'Kabupaten Sinjai',
                    'latitude'  => $settings['latitude'] ?? '-5.1234',
                    'longitude' => $settings['longitude'] ?? '120.1234'
                ],
                'keuangan' => [
                    'total_masuk'  => $kasMasuk,
                    'total_keluar' => $kasKeluar,
                    'saldo'        => ($kasMasuk - $kasKeluar),
                    'last_update'  => $lastUpdateKeuangan
                ],
                'jadwal_jumat'      => $jadwalJumatSingle,
                'jadwal_jumat_list' => $jadwalJumatList,
                'agenda'            => $agenda ?? [],
                'pengumuman'        => $pengumuman ?? [],
                'donasi'            => $donasiList ?? [],
                'qris_data'         => $settings['qris_data'] ?? 'MasjidAgungSinjaiQRIS'
            ]
        ];

        return $this->respond($data);
    }
}
