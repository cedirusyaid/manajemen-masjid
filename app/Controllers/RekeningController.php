<?php

namespace App\Controllers;

use App\Models\RekeningModel;
use CodeIgniter\Controller;

class RekeningController extends BaseController
{
    protected $rekeningModel;
    protected $session;

    public function __construct()
    {
        $this->rekeningModel = new RekeningModel();
        $this->session = \Config\Services::session();
        helper(['url', 'form', 'site_helper', 'audit_helper']);
    }

    /**
     * Tampilkan daftar rekening/metode infaq (Read)
     */
    public function index()
    {
        // Proteksi Akses Admin
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rekeningList = $this->rekeningModel->findAll();

        return view('dashboard/rekening/index', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'rekening_list' => $rekeningList
        ]);
    }

    /**
     * Form Tambah Rekening (Create)
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/rekening/tambah', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
        ]);
    }

    /**
     * Proses Simpan Rekening Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Validasi Input
        $rules = [
            'nama_bank' => 'required|min_length[2]|max_length[100]',
            'jenis'     => 'required|in_list[transfer,qris]',
            'status'    => 'required|in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Generasi UUID
        $id = sprintf('%s-%s-%s-%s-%s',
            bin2hex(random_bytes(4)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(2)),
            bin2hex(random_bytes(6))
        );

        $logoName = null;
        $logoFile = $this->request->getFile('logo');

        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            // Terapkan Auto WebP
            $logoName = $logoFile->getRandomName();
            $logoName = pathinfo($logoName, PATHINFO_FILENAME) . '.webp';

            $imagePath = $logoFile->getTempName();
            
            if (!is_dir(FCPATH . 'uploads/rekening')) {
                mkdir(FCPATH . 'uploads/rekening', 0755, true);
            }

            // Gunakan GD Library untuk mengubah format ke WebP
            $info = getimagesize($imagePath);
            if ($info) {
                $mime = $info['mime'];
                switch ($mime) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($imagePath);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($imagePath);
                        break;
                    case 'image/gif':
                        $image = imagecreatefromgif($imagePath);
                        break;
                    case 'image/webp':
                        $image = imagecreatefromwebp($imagePath);
                        break;
                    default:
                        $image = false;
                }

                if ($image !== false) {
                    imagewebp($image, FCPATH . 'uploads/rekening/' . $logoName, 80);
                    imagedestroy($image);
                } else {
                    $logoFile->move(FCPATH . 'uploads/rekening', $logoName);
                }
            } else {
                $logoFile->move(FCPATH . 'uploads/rekening', $logoName);
            }
        }

        $data = [
            'id'             => $id,
            'nama_bank'      => $this->request->getPost('nama_bank'),
            'nomor_rekening' => $this->request->getPost('nomor_rekening'),
            'atas_nama'      => $this->request->getPost('atas_nama'),
            'jenis'          => $this->request->getPost('jenis'),
            'logo'           => $logoName,
            'status'         => $this->request->getPost('status')
        ];

        if ($this->rekeningModel->insert($data)) {
            log_activity(
                'INSERT',
                'mst_rekening',
                $id,
                null,
                $data
            );

            return redirect()->to('/dashboard/rekening')->with('success', 'Metode infaq baru berhasil ditambahkan.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
    }

    /**
     * Form Edit Rekening (Update)
     */
    public function edit($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rekening = $this->rekeningModel->find($id);
        if (!$rekening) {
            return redirect()->to('/dashboard/rekening')->with('error', 'Metode infaq tidak ditemukan.');
        }

        return view('dashboard/rekening/edit', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
            'rekening'  => $rekening
        ]);
    }

    /**
     * Proses Pembaruan Data Rekening
     */
    public function update($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rekening = $this->rekeningModel->find($id);
        if (!$rekening) {
            return redirect()->to('/dashboard/rekening')->with('error', 'Metode infaq tidak ditemukan.');
        }

        // Validasi Input
        $rules = [
            'nama_bank' => 'required|min_length[2]|max_length[100]',
            'jenis'     => 'required|in_list[transfer,qris]',
            'status'    => 'required|in_list[active,inactive]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $logoName = $rekening['logo'];
        $logoFile = $this->request->getFile('logo');

        if ($logoFile && $logoFile->isValid() && !$logoFile->hasMoved()) {
            // Hapus logo lama jika ada
            if (!empty($rekening['logo']) && is_file(FCPATH . 'uploads/rekening/' . $rekening['logo'])) {
                @unlink(FCPATH . 'uploads/rekening/' . $rekening['logo']);
            }

            // Terapkan Auto WebP
            $logoName = $logoFile->getRandomName();
            $logoName = pathinfo($logoName, PATHINFO_FILENAME) . '.webp';

            $imagePath = $logoFile->getTempName();
            $info = getimagesize($imagePath);
            if ($info) {
                $mime = $info['mime'];
                switch ($mime) {
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($imagePath);
                        break;
                    case 'image/png':
                        $image = imagecreatefrompng($imagePath);
                        break;
                    case 'image/gif':
                        $image = imagecreatefromgif($imagePath);
                        break;
                    case 'image/webp':
                        $image = imagecreatefromwebp($imagePath);
                        break;
                    default:
                        $image = false;
                }

                if ($image !== false) {
                    imagewebp($image, FCPATH . 'uploads/rekening/' . $logoName, 80);
                    imagedestroy($image);
                } else {
                    $logoFile->move(FCPATH . 'uploads/rekening', $logoName);
                }
            } else {
                $logoFile->move(FCPATH . 'uploads/rekening', $logoName);
            }
        }

        $data = [
            'nama_bank'      => $this->request->getPost('nama_bank'),
            'nomor_rekening' => $this->request->getPost('nomor_rekening'),
            'atas_nama'      => $this->request->getPost('atas_nama'),
            'jenis'          => $this->request->getPost('jenis'),
            'logo'           => $logoName,
            'status'         => $this->request->getPost('status')
        ];

        if ($this->rekeningModel->update($id, $data)) {
            log_activity(
                'UPDATE',
                'mst_rekening',
                $id,
                $rekening,
                array_merge($rekening, $data)
            );

            return redirect()->to('/dashboard/rekening')->with('success', 'Metode infaq berhasil diperbarui.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data.');
    }

    /**
     * Hapus Rekening (Soft Delete)
     */
    public function delete($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rekening = $this->rekeningModel->find($id);
        if (!$rekening) {
            return redirect()->to('/dashboard/rekening')->with('error', 'Metode infaq tidak ditemukan.');
        }

        if ($this->rekeningModel->delete($id)) {
            log_activity(
                'DELETE',
                'mst_rekening',
                $id,
                $rekening,
                null
            );

            return redirect()->to('/dashboard/rekening')->with('success', 'Metode infaq berhasil dihapus (soft-deleted).');
        }

        return redirect()->to('/dashboard/rekening')->with('error', 'Gagal menghapus data.');
    }
}
