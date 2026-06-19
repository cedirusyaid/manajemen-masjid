<?php

namespace App\Controllers;

use App\Models\PersonilModel;
use Exception;

class PersonilController extends BaseController
{
    protected $personilModel;
    protected $session;

    public function __construct()
    {
        $this->personilModel = new PersonilModel();
        $this->session       = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Personil
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personilList = $this->personilModel->where('deleted_at', null)->findAll();

        return view('dashboard/personil/index', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'personil_list' => $personilList
        ]);
    }

    /**
     * Tampilkan Form Tambah Personil
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/personil/create', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Personil Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'nama'          => 'required|min_length[3]|max_length[150]',
            'nik'           => 'permit_empty|exact_length[16]',
            'no_hp'         => 'permit_empty|min_length[8]|max_length[20]',
            'email'         => 'permit_empty|valid_email|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'alamat'        => 'permit_empty',
            'foto'          => 'permit_empty|uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $fotoName = null;
        $file = $this->request->getFile('foto');

        // Skenario Auto WebP (Standard v2.5 & v2.6)
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $targetDir = FCPATH . 'uploads/images/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $mime = $file->getMimeType();
                $tempPath = $file->getRealPath();
                $fotoName = $file->getRandomName() . '.webp';

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
                    imagewebp($imageSource, $targetDir . $fotoName, 80);
                    imagedestroy($imageSource);
                } else {
                    throw new Exception('Gagal memproses berkas gambar asli.');
                }
            } catch (Exception $e) {
                log_message('error', 'Auto WebP Conversion Failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
        }

        // Tipe Default SET
        $tipeArray = $this->request->getPost('tipe_default') ?: [];
        $tipeString = implode(',', $tipeArray);
        if (empty($tipeString)) {
            $tipeString = 'jamaah';
        }

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'nik'           => $this->request->getPost('nik') ?: null,
            'no_hp'         => $this->request->getPost('no_hp') ?: null,
            'email'         => $this->request->getPost('email') ?: null,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => $this->request->getPost('alamat') ?: null,
            'foto'          => $fotoName,
            'tipe_default'  => $tipeString
        ];

        try {
            $this->personilModel->insert($data);
            $newId = $this->personilModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'mst_personil', $newId ?: 'UUID', null, $data);

            return redirect()->to('/dashboard/personil')->with('success', 'Data personel berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Form Edit Personil
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personil = $this->personilModel->find($id);

        if (!$personil) {
            return redirect()->to('/dashboard/personil')->with('error', 'Data personel tidak ditemukan.');
        }

        return view('dashboard/personil/edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'personil'   => $personil,
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Perubahan Personil
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personil = $this->personilModel->find($id);

        if (!$personil) {
            return redirect()->to('/dashboard/personil')->with('error', 'Data personel tidak ditemukan.');
        }

        $rules = [
            'nama'          => 'required|min_length[3]|max_length[150]',
            'nik'           => 'permit_empty|exact_length[16]',
            'no_hp'         => 'permit_empty|min_length[8]|max_length[20]',
            'email'         => 'permit_empty|valid_email|max_length[100]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'alamat'        => 'permit_empty',
            'foto'          => 'permit_empty|uploaded[foto]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $fotoName = $personil['foto'];
        $file = $this->request->getFile('foto');

        // Skenario Auto WebP (Standard v2.5 & v2.6)
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $targetDir = FCPATH . 'uploads/images/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Hapus gambar lama jika ada
                if (!empty($personil['foto']) && file_exists($targetDir . $personil['foto'])) {
                    @unlink($targetDir . $personil['foto']);
                }

                $mime = $file->getMimeType();
                $tempPath = $file->getRealPath();
                $fotoName = $file->getRandomName() . '.webp';

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
                    imagewebp($imageSource, $targetDir . $fotoName, 80);
                    imagedestroy($imageSource);
                } else {
                    throw new Exception('Gagal memproses berkas gambar asli.');
                }
            } catch (Exception $e) {
                log_message('error', 'Auto WebP Conversion Failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
        }

        // Tipe Default SET
        $tipeArray = $this->request->getPost('tipe_default') ?: [];
        $tipeString = implode(',', $tipeArray);
        if (empty($tipeString)) {
            $tipeString = 'jamaah';
        }

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'nik'           => $this->request->getPost('nik') ?: null,
            'no_hp'         => $this->request->getPost('no_hp') ?: null,
            'email'         => $this->request->getPost('email') ?: null,
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat'        => $this->request->getPost('alamat') ?: null,
            'foto'          => $fotoName,
            'tipe_default'  => $tipeString
        ];

        try {
            $this->personilModel->update($id, $data);
            
            // Catat Audit Trail
            log_activity('UPDATE', 'mst_personil', $id, $personil, $data);

            return redirect()->to('/dashboard/personil')->with('success', 'Data personel berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Personil (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personil = $this->personilModel->find($id);

        if (!$personil) {
            return redirect()->to('/dashboard/personil')->with('error', 'Data personel tidak ditemukan.');
        }

        try {
            $this->personilModel->delete($id);

            // Catat Audit Trail
            log_activity('DELETE', 'mst_personil', $id, $personil, null);

            return redirect()->to('/dashboard/personil')->with('success', 'Data personel berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/personil')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * Simpan Personil Baru via AJAX (untuk inline creation)
     */
    public function ajaxStore()
    {
        // Cek akses admin secara manual (karena ini AJAX request)
        if ($this->session->get('role_name') === 'Jemaah' || !$this->session->get('username')) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki wewenang.'
            ])->setStatusCode(403);
        }

        $rules = [
            'nama'          => 'required|min_length[3]|max_length[150]',
            'jenis_kelamin' => 'required|in_list[L,P]',
            'no_hp'         => 'permit_empty|min_length[8]|max_length[20]',
            'alamat'        => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => implode(' | ', $this->validator->getErrors())
            ]);
        }

        $data = [
            'nama'          => $this->request->getPost('nama'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'no_hp'         => $this->request->getPost('no_hp') ?: null,
            'alamat'        => $this->request->getPost('alamat') ?: null,
            'tipe_default'  => $this->request->getPost('tipe_default') ?: 'pengurus'
        ];

        try {
            $this->personilModel->insert($data);
            $newId = $this->personilModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'mst_personil', $newId ?: 'UUID', null, $data);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Personil baru berhasil ditambahkan.',
                'data'    => [
                    'id'   => $newId,
                    'nama' => $data['nama']
                ]
            ]);
        } catch (Exception $e) {
            telegram_log_error($e);
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}

