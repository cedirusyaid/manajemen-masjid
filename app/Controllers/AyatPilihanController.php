<?php

namespace App\Controllers;

use App\Models\AyatPilihanModel;
use Exception;

class AyatPilihanController extends BaseController
{
    protected $ayatModel;
    protected $session;

    public function __construct()
    {
        $this->ayatModel = new AyatPilihanModel();
        $this->session   = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Ayat Pilihan Display
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $ayatList = $this->ayatModel->where('deleted_at', null)
                                   ->orderBy('urutan', 'ASC')
                                   ->orderBy('created_at', 'ASC')
                                   ->findAll();

        return view('dashboard/ayat/index', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
            'ayat_list' => $ayatList
        ]);
    }

    /**
     * Form Tambah Ayat Pilihan
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/ayat/create', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar')
        ]);
    }

    /**
     * Simpan Ayat Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $surah       = trim($this->request->getPost('surah'));
        $nomorAyat   = trim($this->request->getPost('nomor_ayat'));
        $teksArab    = trim($this->request->getPost('teks_arab'));
        $terjemahan  = trim($this->request->getPost('terjemahan'));
        $tema        = trim($this->request->getPost('tema')) ?: 'Umum';
        $urutan      = (int) $this->request->getPost('urutan');
        $isActive    = (int) ($this->request->getPost('is_active') ?? 1);

        $newId = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $data = [
            'id'         => $newId,
            'surah'      => $surah,
            'nomor_ayat' => $nomorAyat,
            'teks_arab'  => $teksArab,
            'terjemahan' => $terjemahan,
            'tema'       => $tema,
            'urutan'     => $urutan,
            'is_active'  => $isActive
        ];

        try {
            $this->ayatModel->insert($data);
            log_activity('INSERT', 'mst_ayat_pilihan', $newId, null, [
                'surah'      => $surah,
                'nomor_ayat' => $nomorAyat,
                'tema'       => $tema
            ]);

            return redirect()->to('/dashboard/ayat')->with('success', "Ayat QS. {$surah}: {$nomorAyat} berhasil ditambahkan ke Display.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan ayat: ' . $e->getMessage());
        }
    }

    /**
     * Form Edit Ayat
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $ayat = $this->ayatModel->find($id);
        if (!$ayat) {
            return redirect()->to('/dashboard/ayat')->with('error', 'Data ayat tidak ditemukan.');
        }

        return view('dashboard/ayat/edit', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
            'ayat'      => $ayat
        ]);
    }

    /**
     * Update Ayat
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $old = $this->ayatModel->find($id);
        if (!$old) {
            return redirect()->to('/dashboard/ayat')->with('error', 'Data ayat tidak ditemukan.');
        }

        $data = [
            'surah'      => trim($this->request->getPost('surah')),
            'nomor_ayat' => trim($this->request->getPost('nomor_ayat')),
            'teks_arab'  => trim($this->request->getPost('teks_arab')),
            'terjemahan' => trim($this->request->getPost('terjemahan')),
            'tema'       => trim($this->request->getPost('tema')) ?: 'Umum',
            'urutan'     => (int) $this->request->getPost('urutan'),
            'is_active'  => (int) ($this->request->getPost('is_active') ?? 1)
        ];

        try {
            $this->ayatModel->update($id, $data);
            log_activity('UPDATE', 'mst_ayat_pilihan', $id, $old, $data);

            return redirect()->to('/dashboard/ayat')->with('success', "Ayat QS. {$data['surah']}: {$data['nomor_ayat']} berhasil diperbarui.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui ayat: ' . $e->getMessage());
        }
    }

    /**
     * Toggle Status Aktif Display
     */
    public function toggleStatus(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $ayat = $this->ayatModel->find($id);
        if (!$ayat) {
            return redirect()->to('/dashboard/ayat')->with('error', 'Data ayat tidak ditemukan.');
        }

        $newStatus = $ayat['is_active'] == 1 ? 0 : 1;
        $this->ayatModel->update($id, ['is_active' => $newStatus]);

        log_activity('UPDATE', 'mst_ayat_pilihan', $id, $ayat, ['is_active' => $newStatus]);

        $statusText = $newStatus == 1 ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/dashboard/ayat')->with('success', "Ayat QS. {$ayat['surah']}: {$ayat['nomor_ayat']} berhasil {$statusText} di display.");
    }

    /**
     * Hapus Ayat (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $ayat = $this->ayatModel->find($id);
        if (!$ayat) {
            return redirect()->to('/dashboard/ayat')->with('error', 'Data ayat tidak ditemukan.');
        }

        $this->ayatModel->delete($id);
        log_activity('DELETE', 'mst_ayat_pilihan', $id, $ayat, null);

        return redirect()->to('/dashboard/ayat')->with('success', "Ayat QS. {$ayat['surah']}: {$ayat['nomor_ayat']} berhasil dihapus.");
    }
}
