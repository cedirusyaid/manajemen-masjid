<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\JadwalJumatModel;
use CodeIgniter\Controller;

class DashboardController extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper(['url', 'date', 'audit_helper']);
    }

    /**
     * Halaman Dashboard Admin Pengurus
     */
    public function index()
    {
        // 1. Proteksi Halaman (Hanya yang sudah login boleh masuk)
        if (!$this->session->get('is_logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        // 2. Ambil Statistik Data Riil untuk Widget Dashboard
        // A. Total Pengurus Aktif
        $totalPengurus = $db->table('sys_users')->where('status', 'active')->where('deleted_at', null)->countAllResults();

        // B. Total Infak Digital Terverifikasi (dari trn_zis)
        $totalInfakRow = $db->table('trn_zis')
                            ->selectSum('nominal')
                            ->where('status_verifikasi', 'verified')
                            ->where('deleted_at', null)
                            ->get()
                            ->getRow();
        $totalInfak = $totalInfakRow ? ($totalInfakRow->nominal ?? 0) : 0;

        // C. Jumlah Santri TPA Terdaftar (diterima)
        $totalSantri = $db->table('trn_pendaftaran_tpa')
                           ->where('status_pendaftaran', 'diterima')
                           ->where('deleted_at', null)
                           ->countAllResults();

        // D. Laporan Kas Keuangan Bulan Ini (trn_keuangan)
        $kasMasukRow = $db->table('trn_keuangan')
                          ->selectSum('nominal')
                          ->where('tipe', 'masuk')
                          ->where('deleted_at', null)
                          ->get()
                          ->getRow();
        $kasMasuk = $kasMasukRow ? ($kasMasukRow->nominal ?? 0) : 0;

        $kasKeluarRow = $db->table('trn_keuangan')
                           ->selectSum('nominal')
                           ->where('tipe', 'keluar')
                           ->where('deleted_at', null)
                           ->get()
                           ->getRow();
        $kasKeluar = $kasKeluarRow ? ($kasKeluarRow->nominal ?? 0) : 0;
        
        $saldoKas = $kasMasuk - $kasKeluar;

        // 3. Ambil Log Aktivitas Terbaru (Audit Trail log_activities)
        $logActivities = $db->table('log_activities')
                            ->select('log_activities.*, sys_users.username')
                            ->join('sys_users', 'sys_users.id = log_activities.user_id', 'left')
                            ->orderBy('log_activities.created_at', 'DESC')
                            ->limit(5)
                            ->get()
                            ->getResultArray();

        // 4. Jadwal Jumat Pekan Ini
        $jadwalJumatModel = new JadwalJumatModel();
        $petugasJumat = $jadwalJumatModel->getJadwalTerdekat();

        return view('dashboard/index', [
            'username'       => $this->session->get('username'),
            'role_name'      => $this->session->get('role_name'),
            'avatar'         => $this->session->get('avatar'),
            'total_pengurus' => $totalPengurus,
            'total_infak'    => $totalInfak,
            'total_santri'   => $totalSantri,
            'saldo_kas'      => $saldoKas,
            'logs'           => $logActivities,
            'petugas_jumat'  => $petugasJumat
        ]);
    }
}
