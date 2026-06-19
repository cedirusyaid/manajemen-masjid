<?php

namespace App\Controllers;

use App\Models\KeuanganModel;
use Exception;

class KeuanganController extends BaseController
{
    protected $keuanganModel;
    protected $session;

    public function __construct()
    {
        $this->keuanganModel = new KeuanganModel();
        $this->session       = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Kas Keuangan & Ringkasan Saldo
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Ambil data kas diurutkan berdasarkan tanggal terbaru
        $kasList = $this->keuanganModel->where('deleted_at', null)->orderBy('tanggal', 'DESC')->orderBy('created_at', 'DESC')->findAll();

        // Hitung total kas masuk, keluar, dan saldo akhir
        $totalMasuk  = 0;
        $totalKeluar = 0;

        foreach ($kasList as $item) {
            if ($item['tipe'] === 'masuk') {
                $totalMasuk += $item['nominal'];
            } else {
                $totalKeluar += $item['nominal'];
            }
        }

        $saldoKas = $totalMasuk - $totalKeluar;

        return view('dashboard/keuangan/index', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'kas_list'     => $kasList,
            'total_masuk'  => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo_kas'    => $saldoKas
        ]);
    }

    /**
     * Tampilkan Form Tambah Transaksi Kas
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/keuangan/create', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Transaksi Kas Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'tanggal'          => 'required|valid_date[Y-m-d]',
            'kategori'         => 'required|in_list[operasional,pembangunan,zis,sosial]',
            'tipe'             => 'required|in_list[masuk,keluar]',
            'nominal'          => 'required|numeric|greater_than[0]',
            'keterangan'       => 'required|max_length[255]',
            'penanggung_jawab' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $buktiName = null;
        $buktiFile = $this->request->getFile('bukti_transaksi');

        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            // Validasi file: image or pdf, max 2MB
            $validationRule = [
                'bukti_transaksi' => [
                    'label' => 'Bukti Transaksi',
                    'rules' => 'uploaded[bukti_transaksi]|max_size[bukti_transaksi,2048]|ext_in[bukti_transaksi,jpg,jpeg,png,webp,pdf]',
                ]
            ];
            
            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getError('bukti_transaksi'));
            }

            if (!is_dir(FCPATH . 'uploads/keuangan')) {
                mkdir(FCPATH . 'uploads/keuangan', 0755, true);
            }

            $ext = $buktiFile->getClientExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                // Terapkan Auto WebP untuk gambar
                $buktiName = $buktiFile->getRandomName();
                $buktiName = pathinfo($buktiName, PATHINFO_FILENAME) . '.webp';
                $imagePath = $buktiFile->getTempName();
                
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
                        imagewebp($image, FCPATH . 'uploads/keuangan/' . $buktiName, 80);
                        imagedestroy($image);
                    } else {
                        $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
                    }
                } else {
                    $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
                }
            } else {
                // PDF - save langsung
                $buktiName = $buktiFile->getRandomName();
                $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
            }
        }

        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'kategori'         => $this->request->getPost('kategori'),
            'tipe'             => $this->request->getPost('tipe'),
            'nominal'          => $this->request->getPost('nominal'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
            'bukti_transaksi'  => $buktiName
        ];

        try {
            $this->keuanganModel->insert($data);
            $newId = $this->keuanganModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'trn_keuangan', $newId ?: 'UUID', null, $data);

            return redirect()->to('/dashboard/keuangan')->with('success', 'Transaksi kas berhasil dicatat.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Form Edit Transaksi Kas
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        return view('dashboard/keuangan/edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'kas'        => $kas,
            'validation' => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Perubahan Transaksi Kas
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        $rules = [
            'tanggal'          => 'required|valid_date[Y-m-d]',
            'kategori'         => 'required|in_list[operasional,pembangunan,zis,sosial]',
            'tipe'             => 'required|in_list[masuk,keluar]',
            'nominal'          => 'required|numeric|greater_than[0]',
            'keterangan'       => 'required|max_length[255]',
            'penanggung_jawab' => 'permit_empty|max_length[100]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $buktiName = $kas['bukti_transaksi'];
        $buktiFile = $this->request->getFile('bukti_transaksi');

        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            // Validasi file: image or pdf, max 2MB
            $validationRule = [
                'bukti_transaksi' => [
                    'label' => 'Bukti Transaksi',
                    'rules' => 'uploaded[bukti_transaksi]|max_size[bukti_transaksi,2048]|ext_in[bukti_transaksi,jpg,jpeg,png,webp,pdf]',
                ]
            ];
            
            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('error', $this->validator->getError('bukti_transaksi'));
            }

            // Hapus bukti transaksi lama jika ada
            if (!empty($kas['bukti_transaksi']) && is_file(FCPATH . 'uploads/keuangan/' . $kas['bukti_transaksi'])) {
                @unlink(FCPATH . 'uploads/keuangan/' . $kas['bukti_transaksi']);
            }

            if (!is_dir(FCPATH . 'uploads/keuangan')) {
                mkdir(FCPATH . 'uploads/keuangan', 0755, true);
            }

            $ext = $buktiFile->getClientExtension();
            if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp'])) {
                // Terapkan Auto WebP untuk gambar
                $buktiName = $buktiFile->getRandomName();
                $buktiName = pathinfo($buktiName, PATHINFO_FILENAME) . '.webp';
                $imagePath = $buktiFile->getTempName();
                
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
                        imagewebp($image, FCPATH . 'uploads/keuangan/' . $buktiName, 80);
                        imagedestroy($image);
                    } else {
                        $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
                    }
                } else {
                    $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
                }
            } else {
                // PDF - save langsung
                $buktiName = $buktiFile->getRandomName();
                $buktiFile->move(FCPATH . 'uploads/keuangan', $buktiName);
            }
        }

        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'kategori'         => $this->request->getPost('kategori'),
            'tipe'             => $this->request->getPost('tipe'),
            'nominal'          => $this->request->getPost('nominal'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
            'bukti_transaksi'  => $buktiName
        ];

        try {
            $this->keuanganModel->update($id, $data);
            
            // Catat Audit Trail
            log_activity('UPDATE', 'trn_keuangan', $id, $kas, array_merge($kas, $data));

            return redirect()->to('/dashboard/keuangan')->with('success', 'Transaksi kas berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Transaksi Kas (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        try {
            $this->keuanganModel->delete($id);
            
            // Catat Audit Trail
            log_activity('DELETE', 'trn_keuangan', $id, $kas, null);

            return redirect()->to('/dashboard/keuangan')->with('success', 'Transaksi kas berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/keuangan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
