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
