<?php

namespace App\Controllers;

use App\Models\JadwalSholatModel;
use Exception;

class JadwalSholatController extends BaseController
{
    protected $jadwalModel;
    protected $session;

    public function __construct()
    {
        $this->jadwalModel = new JadwalSholatModel();
        $this->session     = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Kalender & Jadwal Waktu Shalat
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $bulan = (int) ($this->request->getVar('bulan') ?? date('n'));
        if ($bulan < 1 || $bulan > 12) {
            $bulan = (int) date('n');
        }

        $namaBulan = [
            1  => 'Januari',
            2  => 'Februari',
            3  => 'Maret',
            4  => 'April',
            5  => 'Mei',
            6  => 'Juni',
            7  => 'Juli',
            8  => 'Agustus',
            9  => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $jadwalList = $this->jadwalModel->getByBulan($bulan);
        $hariIni    = $this->jadwalModel->getHariIni();

        $settingModel = new \App\Models\SettingModel();
        $settings = $settingModel->getSettings();

        return view('dashboard/jadwal_sholat/index', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'bulan_aktif'  => $bulan,
            'nama_bulan'   => $namaBulan,
            'jadwal_list'  => $jadwalList,
            'hari_ini'     => $hariIni,
            'settings'     => $settings
        ]);
    }

    /**
     * Simpan Pengaturan Durasi Blank Layar Display Tiap Waktu Shalat
     */
    public function saveDisplayBlankSettings()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $keys = [
            'blank_before_prayer'   => (int) ($this->request->getPost('blank_before_prayer') ?? 0),
            'blank_duration_subuh'   => (int) ($this->request->getPost('blank_duration_subuh') ?? 25),
            'blank_duration_dzuhur'  => (int) ($this->request->getPost('blank_duration_dzuhur') ?? 20),
            'blank_duration_ashar'   => (int) ($this->request->getPost('blank_duration_ashar') ?? 20),
            'blank_duration_maghrib' => (int) ($this->request->getPost('blank_duration_maghrib') ?? 20),
            'blank_duration_isya'    => (int) ($this->request->getPost('blank_duration_isya') ?? 25),
            'blank_duration_jumat'   => (int) ($this->request->getPost('blank_duration_jumat') ?? 45),
            'slideshow_duration'     => (int) ($this->request->getPost('slideshow_duration') ?? 10),
        ];

        try {
            $settingModel = new \App\Models\SettingModel();
            foreach ($keys as $key => $val) {
                $val = max(1, min(300, $val)); // Batas wajar
                $settingModel->setSetting($key, (string) $val, 'display');
            }

            log_activity('UPDATE', 'sys_settings', 'display_settings', null, $keys);

            return redirect()->to('/dashboard/jadwal-sholat')
                             ->with('success', 'Pengaturan Display TV & Slideshow berhasil disimpan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->with('error', 'Gagal menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Form Tambah Jadwal Sholat Manual
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $namaBulan = [
            1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
            4  => 'April',   5  => 'Mei',      6  => 'Juni',
            7  => 'Juli',    8  => 'Agustus',  9  => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('dashboard/jadwal_sholat/create', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'nama_bulan' => $namaBulan
        ]);
    }

    /**
     * Simpan Jadwal Sholat Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $bulan   = (int) $this->request->getPost('bulan');
        $tanggal = (int) $this->request->getPost('tanggal');

        // Cek duplikasi bulan & tanggal
        $existing = $this->jadwalModel->where('bulan', $bulan)
                                      ->where('tanggal', $tanggal)
                                      ->where('deleted_at', null)
                                      ->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', "Jadwal untuk tanggal {$tanggal} bulan {$bulan} sudah ada. Silakan gunakan menu Edit.");
        }

        $newId = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $subuh = trim($this->request->getPost('subuh'));
        $imsak = trim($this->request->getPost('imsak'));
        if (empty($imsak) && !empty($subuh)) {
            $sMin = JadwalSholatModel::timeToMinutes($subuh);
            $imsak = JadwalSholatModel::minutesToTime($sMin - 10);
        }

        $terbit = trim($this->request->getPost('terbit'));
        if (empty($terbit) && !empty($subuh)) {
            $sMin = JadwalSholatModel::timeToMinutes($subuh);
            $terbit = JadwalSholatModel::minutesToTime($sMin + 75);
        }

        $dhuha = trim($this->request->getPost('dhuha'));
        if (empty($dhuha) && !empty($terbit)) {
            $tMin = JadwalSholatModel::timeToMinutes($terbit);
            $dhuha = JadwalSholatModel::minutesToTime($tMin + 25);
        }

        $data = [
            'id'         => $newId,
            'bulan'      => $bulan,
            'tanggal'    => $tanggal,
            'imsak'      => $imsak ?: '04:35',
            'subuh'      => $subuh,
            'terbit'     => $terbit ?: '05:55',
            'dhuha'      => $dhuha ?: '06:20',
            'dzuhur'     => trim($this->request->getPost('dzuhur')),
            'ashar'      => trim($this->request->getPost('ashar')),
            'maghrib'    => trim($this->request->getPost('maghrib')),
            'isya'       => trim($this->request->getPost('isya')),
            'keterangan' => trim($this->request->getPost('keterangan')) ?: 'Jadwal Manual'
        ];

        try {
            $this->jadwalModel->insert($data);
            log_activity('INSERT', 'mst_jadwal_sholat', $newId, null, $data);

            return redirect()->to("/dashboard/jadwal-sholat?bulan={$bulan}")
                             ->with('success', "Jadwal waktu shalat tanggal {$tanggal} berhasil ditambahkan.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Form Edit Jadwal Sholat
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jadwal = $this->jadwalModel->find($id);
        if (!$jadwal) {
            return redirect()->to('/dashboard/jadwal-sholat')->with('error', 'Data jadwal sholat tidak ditemukan.');
        }

        $namaBulan = [
            1  => 'Januari', 2  => 'Februari', 3  => 'Maret',
            4  => 'April',   5  => 'Mei',      6  => 'Juni',
            7  => 'Juli',    8  => 'Agustus',  9  => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('dashboard/jadwal_sholat/edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'jadwal'     => $jadwal,
            'nama_bulan' => $namaBulan
        ]);
    }

    /**
     * Update Jadwal Sholat
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $oldData = $this->jadwalModel->find($id);
        if (!$oldData) {
            return redirect()->to('/dashboard/jadwal-sholat')->with('error', 'Data jadwal sholat tidak ditemukan.');
        }

        $data = [
            'imsak'      => trim($this->request->getPost('imsak')),
            'subuh'      => trim($this->request->getPost('subuh')),
            'terbit'     => trim($this->request->getPost('terbit')),
            'dhuha'      => trim($this->request->getPost('dhuha')),
            'dzuhur'     => trim($this->request->getPost('dzuhur')),
            'ashar'      => trim($this->request->getPost('ashar')),
            'maghrib'    => trim($this->request->getPost('maghrib')),
            'isya'       => trim($this->request->getPost('isya')),
            'keterangan' => trim($this->request->getPost('keterangan')) ?: 'Penyesuaian Manual'
        ];

        try {
            $this->jadwalModel->update($id, $data);
            log_activity('UPDATE', 'mst_jadwal_sholat', $id, $oldData, $data);

            $bulan = $oldData['bulan'];
            return redirect()->to("/dashboard/jadwal-sholat?bulan={$bulan}")
                             ->with('success', "Jadwal waktu shalat tanggal {$oldData['tanggal']} berhasil diperbarui.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Jadwal Sholat
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $oldData = $this->jadwalModel->find($id);
        if (!$oldData) {
            return redirect()->to('/dashboard/jadwal-sholat')->with('error', 'Data tidak ditemukan.');
        }

        try {
            $this->jadwalModel->delete($id);
            log_activity('DELETE', 'mst_jadwal_sholat', $id, $oldData, null);

            return redirect()->to("/dashboard/jadwal-sholat?bulan={$oldData['bulan']}")
                             ->with('success', 'Jadwal tanggal terkait berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    /**
     * Reset / Re-generate Seluruh Jadwal Tahunan Sesuai Rujukan Hisab
     */
    public function resetTahunan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        try {
            $count = $this->jadwalModel->generateTahunan(true);
            log_activity('REGENERATE', 'mst_jadwal_sholat', 'all', null, ['count' => $count]);

            return redirect()->to('/dashboard/jadwal-sholat')
                             ->with('success', "Seluruh {$count} jadwal waktu shalat tahunan berhasil di-reset & di-generate ulang sesuai hisab resmi Masjid Agung.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->with('error', 'Gagal generate: ' . $e->getMessage());
        }
    }
}
