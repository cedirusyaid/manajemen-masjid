<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use App\Models\PersonilModel;
use Exception;

class AgendaController extends BaseController
{
    protected $agendaModel;
    protected $personilModel;
    protected $session;

    public function __construct()
    {
        $this->agendaModel   = new AgendaModel();
        $this->personilModel = new PersonilModel();
        $this->session       = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper', 'site_helper']);
    }

    /**
     * Tampilkan Daftar Agenda/Pengajian
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $agendaList = $this->agendaModel->getAgendaLengkap();

        return view('dashboard/agenda/index', [
            'username'    => $this->session->get('username'),
            'role_name'   => $this->session->get('role_name'),
            'avatar'      => $this->session->get('avatar'),
            'agenda_list' => $agendaList
        ]);
    }

    /**
     * Tampilkan Form Tambah Agenda
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/agenda/create', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'personil_list' => $personilList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Agenda Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'judul'     => 'required|min_length[5]|max_length[255]',
            'deskripsi' => 'required',
            'tanggal'   => 'required|valid_date[Y-m-d]',
            'waktu'     => 'required',
            'lokasi'    => 'permit_empty|max_length[255]',
            'narasumber_id' => 'permit_empty',
            'narasumber'    => 'permit_empty|max_length[150]',
            'banner'    => 'permit_empty|uploaded[banner]|is_image[banner]|mime_in[banner,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $bannerName = null;
        $file = $this->request->getFile('banner');

        // Skenario Auto WebP (Standard v2.5 & v2.6)
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $targetDir = FCPATH . 'uploads/images/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $mime = $file->getMimeType();
                $tempPath = $file->getRealPath();
                $bannerName = $file->getRandomName() . '.webp';

                if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                    $imageSource = imagecreatefromjpeg($tempPath);
                } elseif ($mime === 'image/png') {
                    $imageSource = imagecreatefrompng($tempPath);
                } elseif ($mime === 'image/webp') {
                    $imageSource = imagecreatefromwebp($tempPath);
                } else {
                    throw new Exception('Format berkas gambar tidak didukung untuk konversi WebP.');
                }

                if ($imageSource) {
                    imagewebp($imageSource, $targetDir . $bannerName, 80);
                    imagedestroy($imageSource);
                } else {
                    throw new Exception('Gagal memproses berkas gambar asli.');
                }
            } catch (Exception $e) {
                log_message('error', 'Auto WebP Conversion Failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal memproses banner: ' . $e->getMessage());
            }
        }

        $data = [
            'judul'         => $this->request->getPost('judul'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'tanggal'       => $this->request->getPost('tanggal'),
            'waktu'         => $this->request->getPost('waktu'),
            'lokasi'        => $this->request->getPost('lokasi') ?: site_name(),
            'narasumber_id' => $this->request->getPost('narasumber_id') ?: null,
            'narasumber'    => $this->request->getPost('narasumber') ?: null,
            'banner'        => $bannerName
        ];

        try {
            $this->agendaModel->insert($data);
            $newId = $this->agendaModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'mst_agenda', $newId ?: 'UUID', null, $data);

            return redirect()->to('/dashboard/agenda')->with('success', 'Agenda pengajian baru berhasil diterbitkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Form Edit Agenda
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect()->to('/dashboard/agenda')->with('error', 'Data agenda tidak ditemukan.');
        }

        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/agenda/edit', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'agenda'        => $agenda,
            'personil_list' => $personilList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Perubahan Agenda
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect()->to('/dashboard/agenda')->with('error', 'Data agenda tidak ditemukan.');
        }

        $rules = [
            'judul'     => 'required|min_length[5]|max_length[255]',
            'deskripsi' => 'required',
            'tanggal'   => 'required|valid_date[Y-m-d]',
            'waktu'     => 'required',
            'lokasi'    => 'permit_empty|max_length[255]',
            'narasumber_id' => 'permit_empty',
            'narasumber'    => 'permit_empty|max_length[150]',
            'banner'    => 'permit_empty|uploaded[banner]|is_image[banner]|mime_in[banner,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $bannerName = $agenda['banner'];
        $file = $this->request->getFile('banner');

        // Skenario Auto WebP
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $targetDir = FCPATH . 'uploads/images/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Hapus gambar lama jika ada
                if (!empty($agenda['banner']) && file_exists($targetDir . $agenda['banner'])) {
                    @unlink($targetDir . $agenda['banner']);
                }

                $mime = $file->getMimeType();
                $tempPath = $file->getRealPath();
                $bannerName = $file->getRandomName() . '.webp';

                if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                    $imageSource = imagecreatefromjpeg($tempPath);
                } elseif ($mime === 'image/png') {
                    $imageSource = imagecreatefrompng($tempPath);
                } elseif ($mime === 'image/webp') {
                    $imageSource = imagecreatefromwebp($tempPath);
                } else {
                    throw new Exception('Format berkas gambar tidak didukung untuk konversi WebP.');
                }

                if ($imageSource) {
                    imagewebp($imageSource, $targetDir . $bannerName, 80);
                    imagedestroy($imageSource);
                } else {
                    throw new Exception('Gagal memproses berkas gambar asli.');
                }
            } catch (Exception $e) {
                log_message('error', 'Auto WebP Conversion Failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal memproses banner: ' . $e->getMessage());
            }
        }

        $data = [
            'judul'         => $this->request->getPost('judul'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'tanggal'       => $this->request->getPost('tanggal'),
            'waktu'         => $this->request->getPost('waktu'),
            'lokasi'        => $this->request->getPost('lokasi') ?: site_name(),
            'narasumber_id' => $this->request->getPost('narasumber_id') ?: null,
            'narasumber'    => $this->request->getPost('narasumber') ?: null,
            'banner'        => $bannerName
        ];

        try {
            $this->agendaModel->update($id, $data);
            
            // Catat Audit Trail
            log_activity('UPDATE', 'mst_agenda', $id, $agenda, $data);

            return redirect()->to('/dashboard/agenda')->with('success', 'Agenda pengajian berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Agenda (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $agenda = $this->agendaModel->find($id);

        if (!$agenda) {
            return redirect()->to('/dashboard/agenda')->with('error', 'Data agenda tidak ditemukan.');
        }

        try {
            $this->agendaModel->delete($id);

            // Catat Audit Trail
            log_activity('DELETE', 'mst_agenda', $id, $agenda, null);

            return redirect()->to('/dashboard/agenda')->with('success', 'Agenda pengajian berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/agenda')->with('error', 'Gagal menghapus agenda: ' . $e->getMessage());
        }
    }
}
