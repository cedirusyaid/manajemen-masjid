<?php

namespace App\Controllers;

use App\Models\BeritaModel;
use Exception;

class BeritaController extends BaseController
{
    protected $beritaModel;
    protected $session;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
        $this->session     = \Config\Services::session();
        helper(['url', 'form', 'text', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Berita & Pengumuman
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Ambil data lengkap dengan nama penulis
        $beritaList = $this->beritaModel->getBeritaLengkap();

        return view('dashboard/berita/index', [
            'username'    => $this->session->get('username'),
            'role_name'   => $this->session->get('role_name'),
            'avatar'      => $this->session->get('avatar'),
            'berita_list' => $beritaList
        ]);
    }

    /**
     * Tampilkan Form Tambah Berita
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/berita/create', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Berita Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'judul'  => 'required|min_length[5]|max_length[255]',
            'konten' => 'required',
            'status' => 'required|in_list[draft,published]',
            'banner' => 'permit_empty|uploaded[banner]|is_image[banner]|mime_in[banner,image/jpg,image/jpeg,image/png,image/webp]'
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

                // Buat resource image berdasarkan tipe file asli
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
                    // Konversi dan simpan ke format WebP (kualitas 80%)
                    imagewebp($imageSource, $targetDir . $bannerName, 80);
                    imagedestroy($imageSource);
                } else {
                    throw new Exception('Gagal memproses berkas gambar asli.');
                }
            } catch (Exception $e) {
                log_message('error', 'Auto WebP Conversion Failed: ' . $e->getMessage());
                return redirect()->back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
        }

        $data = [
            'judul'      => $this->request->getPost('judul'),
            'konten'     => $this->request->getPost('konten'),
            'status'     => $this->request->getPost('status'),
            'banner'     => $bannerName,
            'created_by' => $this->session->get('user_id')
        ];

        try {
            $this->beritaModel->insert($data);
            $newId = $this->beritaModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'mst_berita', $newId ?: 'UUID', null, $data);

            return redirect()->to('/dashboard/berita')->with('success', 'Berita berhasil diterbitkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Form Edit Berita
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/dashboard/berita')->with('error', 'Data berita tidak ditemukan.');
        }

        return view('dashboard/berita/edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'berita'     => $berita,
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Perubahan Berita
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/dashboard/berita')->with('error', 'Data berita tidak ditemukan.');
        }

        $rules = [
            'judul'  => 'required|min_length[5]|max_length[255]',
            'konten' => 'required',
            'status' => 'required|in_list[draft,published]',
            'banner' => 'permit_empty|uploaded[banner]|is_image[banner]|mime_in[banner,image/jpg,image/jpeg,image/png,image/webp]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $bannerName = $berita['banner'];
        $file = $this->request->getFile('banner');

        // Skenario Auto WebP (Standard v2.5 & v2.6)
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $targetDir = FCPATH . 'uploads/images/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                // Hapus gambar lama jika ada
                if (!empty($berita['banner']) && file_exists($targetDir . $berita['banner'])) {
                    unlink($targetDir . $berita['banner']);
                }

                $mime = $file->getMimeType();
                $tempPath = $file->getRealPath();
                $bannerName = $file->getRandomName() . '.webp';

                // Buat resource image berdasarkan tipe file asli
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
                return redirect()->back()->withInput()->with('error', 'Gagal memproses gambar: ' . $e->getMessage());
            }
        }

        $data = [
            'judul'  => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status'),
            'banner' => $bannerName
        ];

        try {
            $this->beritaModel->update($id, $data);
            
            // Catat Audit Trail
            log_activity('UPDATE', 'mst_berita', $id, $berita, array_merge($berita, $data));

            return redirect()->to('/dashboard/berita')->with('success', 'Berita berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Berita (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to('/dashboard/berita')->with('error', 'Data berita tidak ditemukan.');
        }

        try {
            $this->beritaModel->delete($id);
            
            // Catat Audit Trail
            log_activity('DELETE', 'mst_berita', $id, $berita, null);

            return redirect()->to('/dashboard/berita')->with('success', 'Berita berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/berita')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
