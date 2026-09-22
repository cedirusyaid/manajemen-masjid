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
     * Tampilkan Daftar Kas Umum Masjid & Ringkasan Saldo
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $userId = $this->session->get('user_id');
        $roleId = (int)$this->session->get('role_id');

        // Khusus Kas Umum Masjid (kegiatan_id IS NULL)
        $kasList = $this->keuanganModel->where('trn_keuangan.kegiatan_id', null)
                                       ->where('trn_keuangan.deleted_at', null)
                                       ->orderBy('trn_keuangan.tanggal', 'DESC')
                                       ->orderBy('trn_keuangan.created_at', 'DESC')
                                       ->findAll();

        // Hitung total Kas Umum Masjid
        $totalMasuk  = (float)($this->keuanganModel->where('kegiatan_id', null)->where('tipe', 'masuk')->where('deleted_at', null)->selectSum('nominal')->first()['nominal'] ?? 0);
        $totalKeluar = (float)($this->keuanganModel->where('kegiatan_id', null)->where('tipe', 'keluar')->where('deleted_at', null)->selectSum('nominal')->first()['nominal'] ?? 0);
        $saldoKas    = $totalMasuk - $totalKeluar;

        return view('dashboard/keuangan/index', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'kas_list'     => $kasList,
            'total_masuk'  => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo_kas'    => $saldoKas,
            'role_id'      => $roleId
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

        $userId = $this->session->get('user_id');
        $roleId = (int)$this->session->get('role_id');
        $kegiatanModel = new \App\Models\KegiatanModel();
        
        // Role 2 (Bendahara Pengurus) tidak boleh memilih kegiatan (khusus kas umum)
        if ($roleId === 2) {
            $kegiatanList = [];
            $selectedKegiatanId = null;
        } elseif ($roleId === 6) {
            // Role 6 (Bendahara Kepanitiaan): Batasi dropdown hanya pada kepanitiaan yang ditugaskan
            $userKegiatanModel = new \App\Models\UserKegiatanModel();
            $assignedKegiatanIds = $userId ? $userKegiatanModel->getKegiatanIdsByUser($userId) : [];
            if (!empty($assignedKegiatanIds)) {
                $kegiatanList = $kegiatanModel->whereIn('id', $assignedKegiatanIds)->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();
            } else {
                $kegiatanList = $kegiatanModel->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();
            }
            $selectedKegiatanId = $this->request->getGet('kegiatan_id');
        } else {
            $kegiatanList = $kegiatanModel->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();
            $selectedKegiatanId = $this->request->getGet('kegiatan_id');
        }

        $rekeningModel = new \App\Models\RekeningModel();
        $rekeningList = $rekeningModel->where('deleted_at', null)->where('status', 'active')->findAll();

        return view('dashboard/keuangan/create', [
            'username'             => $this->session->get('username'),
            'role_name'            => $this->session->get('role_name'),
            'avatar'               => $this->session->get('avatar'),
            'kegiatan_list'        => $kegiatanList,
            'rekening_list'        => $rekeningList,
            'selected_kegiatan_id' => $selectedKegiatanId,
            'role_id'              => $roleId,
            'validation'           => \Config\Services::validation()
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
            'kegiatan_id'      => 'permit_empty|max_length[36]',
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

        $roleId = (int)$this->session->get('role_id');
        $kegiatanId = $this->request->getPost('kegiatan_id');
        $rekeningId = $this->request->getPost('rekening_id');
        $redirectKegiatanId = $this->request->getPost('redirect_kegiatan_id');

        if ($roleId === 2) {
            // Bendahara Pengurus hanya boleh input kas umum (non-kegiatan)
            $kegiatanId = null;
        } elseif ($roleId === 6) {
            // Bendahara Kepanitiaan wajib mengaitkan transaksi dengan kegiatan
            if (empty($kegiatanId)) {
                return redirect()->back()->withInput()->with('error', 'Akses dibatasi: Bendahara Kepanitiaan hanya boleh mencatat keuangan kegiatan/proyek.');
            }
        }

        $data = [
            'kegiatan_id'       => !empty($kegiatanId) ? $kegiatanId : null,
            'rekening_id'       => !empty($rekeningId) ? $rekeningId : null,
            'tanggal'           => $this->request->getPost('tanggal'),
            'kategori'          => $this->request->getPost('kategori'),
            'tipe'              => $this->request->getPost('tipe'),
            'nominal'           => $this->request->getPost('nominal'),
            'nama_donatur'      => $this->request->getPost('nama_donatur'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran') ?: 'transfer_bank',
            'keterangan'        => $this->request->getPost('keterangan'),
            'penanggung_jawab'  => $this->request->getPost('penanggung_jawab'),
            'bukti_transaksi'   => $buktiName
        ];

        try {
            $this->keuanganModel->insert($data);
            $newId = $this->keuanganModel->getInsertID() ?: \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'trn_keuangan', $newId ?: 'UUID', null, $data);

            if (!empty($redirectKegiatanId)) {
                return redirect()->to('/dashboard/kepanitiaan/detail/' . $redirectKegiatanId)->with('success', 'Transaksi kas berhasil dicatat.');
            }

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

        $roleId = (int)$this->session->get('role_id');
        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        // Isolasi Role: Role 2 hanya kas umum, Role 6 hanya kas kepanitiaan
        if ($roleId === 2 && !empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas umum pengurus.');
        }
        if ($roleId === 6 && empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas kegiatan kepanitiaan.');
        }

        $kegiatanModel = new \App\Models\KegiatanModel();
        if ($roleId === 2) {
            $kegiatanList = [];
        } else {
            $kegiatanList = $kegiatanModel->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();
        }
        $rekeningModel = new \App\Models\RekeningModel();
        $rekeningList = $rekeningModel->where('deleted_at', null)->where('status', 'active')->findAll();
        $redirectKegiatanId = $this->request->getGet('kegiatan_id');

        return view('dashboard/keuangan/edit', [
            'username'             => $this->session->get('username'),
            'role_name'            => $this->session->get('role_name'),
            'avatar'               => $this->session->get('avatar'),
            'kas'                  => $kas,
            'kegiatan_list'        => $kegiatanList,
            'rekening_list'        => $rekeningList,
            'redirect_kegiatan_id' => $redirectKegiatanId,
            'role_id'              => $roleId,
            'validation'           => \Config\Services::validation()
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

        $roleId = (int)$this->session->get('role_id');
        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        // Isolasi Role
        if ($roleId === 2 && !empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas umum pengurus.');
        }
        if ($roleId === 6 && empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas kegiatan kepanitiaan.');
        }

        $rules = [
            'kegiatan_id'      => 'permit_empty|max_length[36]',
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

        $kegiatanId = $this->request->getPost('kegiatan_id');
        $rekeningId = $this->request->getPost('rekening_id');
        $redirectKegiatanId = $this->request->getPost('redirect_kegiatan_id');

        if ($roleId === 2) {
            // Bendahara Pengurus hanya boleh edit kas umum (non-kegiatan)
            $kegiatanId = null;
        } elseif ($roleId === 6) {
            // Bendahara Kepanitiaan wajib mengaitkan transaksi dengan kegiatan
            if (empty($kegiatanId)) {
                return redirect()->back()->withInput()->with('error', 'Akses dibatasi: Bendahara Kepanitiaan hanya boleh mencatat keuangan kegiatan/proyek.');
            }
        }

        $data = [
            'kegiatan_id'       => !empty($kegiatanId) ? $kegiatanId : null,
            'rekening_id'       => !empty($rekeningId) ? $rekeningId : null,
            'tanggal'           => $this->request->getPost('tanggal'),
            'kategori'          => $this->request->getPost('kategori'),
            'tipe'              => $this->request->getPost('tipe'),
            'nominal'           => $this->request->getPost('nominal'),
            'nama_donatur'      => $this->request->getPost('nama_donatur'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran') ?: 'transfer_bank',
            'keterangan'        => $this->request->getPost('keterangan'),
            'penanggung_jawab'  => $this->request->getPost('penanggung_jawab'),
            'bukti_transaksi'   => $buktiName
        ];

        try {
            $this->keuanganModel->update($id, $data);
            
            // Catat Audit Trail
            log_activity('UPDATE', 'trn_keuangan', $id, $kas, array_merge($kas, $data));

            if (!empty($redirectKegiatanId)) {
                return redirect()->to('/dashboard/kepanitiaan/detail/' . $redirectKegiatanId)->with('success', 'Transaksi kas berhasil diperbarui.');
            }

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

        $roleId = (int)$this->session->get('role_id');
        $kas = $this->keuanganModel->find($id);

        if (!$kas) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Data transaksi kas tidak ditemukan.');
        }

        // Isolasi Role
        if ($roleId === 2 && !empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas umum pengurus.');
        }
        if ($roleId === 6 && empty($kas['kegiatan_id'])) {
            return redirect()->to('/dashboard/keuangan')->with('error', 'Akses ditolak: Anda hanya berwenang mengelola kas kegiatan kepanitiaan.');
        }

        $redirectKegiatanId = $this->request->getGet('kegiatan_id');

        try {
            $this->keuanganModel->delete($id);
            
            // Catat Audit Trail
            log_activity('DELETE', 'trn_keuangan', $id, $kas, null);

            if (!empty($redirectKegiatanId)) {
                return redirect()->to('/dashboard/kepanitiaan/detail/' . $redirectKegiatanId)->with('success', 'Transaksi kas berhasil dihapus.');
            }

            return redirect()->to('/dashboard/keuangan')->with('success', 'Transaksi kas berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/keuangan')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
