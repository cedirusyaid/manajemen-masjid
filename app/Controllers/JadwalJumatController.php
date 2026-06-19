<?php

namespace App\Controllers;

use App\Models\JadwalJumatModel;
use App\Models\ImamKhatibModel;
use Exception;

class JadwalJumatController extends BaseController
{
    protected $jadwalJumatModel;
    protected $imamKhatibModel;
    protected $session;

    public function __construct()
    {
        $this->jadwalJumatModel = new JadwalJumatModel();
        $this->imamKhatibModel  = new ImamKhatibModel();
        $this->session          = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Jadwal Jumat
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Ambil data lengkap dengan nama petugas
        $jadwalList = $this->jadwalJumatModel->getJadwalLengkap();

        return view('dashboard/jadwal_jumat/index', [
            'username'    => $this->session->get('username'),
            'role_name'   => $this->session->get('role_name'),
            'avatar'      => $this->session->get('avatar'),
            'jadwal_list' => $jadwalList
        ]);
    }

    /**
     * Tampilkan Form Tambah Jadwal Jumat
     */
    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        // Ambil data khatib, imam, dan muadzin untuk pilihan dropdown
        $khatibList  = $this->imamKhatibModel->getPetugasWithPersonil(['khatib', 'imam_khatib']);
        $imamList    = $this->imamKhatibModel->getPetugasWithPersonil(['imam', 'imam_khatib']);
        $muadzinList = $this->imamKhatibModel->getPetugasWithPersonil('muadzin');

        return view('dashboard/jadwal_jumat/create', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'khatib_list'  => $khatibList,
            'imam_list'    => $imamList,
            'muadzin_list' => $muadzinList,
            'validation'   => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Jadwal Jumat Baru
     */
    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'tanggal'       => 'required|valid_date[Y-m-d]',
            'khatib_id'     => 'required',
            'imam_id'       => 'required',
            'muadzin_id'    => 'required',
            'judul_khotbah' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'tanggal'       => $this->request->getPost('tanggal'),
            'khatib_id'     => $this->request->getPost('khatib_id'),
            'imam_id'       => $this->request->getPost('imam_id'),
            'muadzin_id'    => $this->request->getPost('muadzin_id'),
            'judul_khotbah' => $this->request->getPost('judul_khotbah'),
            'keterangan'    => $this->request->getPost('keterangan')
        ];

        try {
            $this->jadwalJumatModel->insert($data);
            
            // Dapatkan ID yang baru saja digenerate otomatis di model
            $newId = $this->jadwalJumatModel->getInsertID() ?: $db = \Config\Database::connect()->insertID();
            
            // Catat Audit Trail
            log_activity('INSERT', 'trn_jadwal_jumat', $newId ?: 'UUID', null, $data);

            return redirect()->to('/dashboard/jadwal-jumat')->with('success', 'Jadwal Jumat berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Form Edit Jadwal Jumat
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jadwal = $this->jadwalJumatModel->find($id);

        if (!$jadwal) {
            return redirect()->to('/dashboard/jadwal-jumat')->with('error', 'Data jadwal tidak ditemukan.');
        }

        // Ambil data khatib, imam, dan muadzin untuk pilihan dropdown
        $khatibList  = $this->imamKhatibModel->getPetugasWithPersonil(['khatib', 'imam_khatib']);
        $imamList    = $this->imamKhatibModel->getPetugasWithPersonil(['imam', 'imam_khatib']);
        $muadzinList = $this->imamKhatibModel->getPetugasWithPersonil('muadzin');

        return view('dashboard/jadwal_jumat/edit', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'jadwal'       => $jadwal,
            'khatib_list'  => $khatibList,
            'imam_list'    => $imamList,
            'muadzin_list' => $muadzinList,
            'validation'   => \Config\Services::validation()
        ]);
    }

    /**
     * Simpan Perubahan Jadwal Jumat
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jadwal = $this->jadwalJumatModel->find($id);

        if (!$jadwal) {
            return redirect()->to('/dashboard/jadwal-jumat')->with('error', 'Data jadwal tidak ditemukan.');
        }

        $rules = [
            'tanggal'       => 'required|valid_date[Y-m-d]',
            'khatib_id'     => 'required',
            'imam_id'       => 'required',
            'muadzin_id'    => 'required',
            'judul_khotbah' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'tanggal'       => $this->request->getPost('tanggal'),
            'khatib_id'     => $this->request->getPost('khatib_id'),
            'imam_id'       => $this->request->getPost('imam_id'),
            'muadzin_id'    => $this->request->getPost('muadzin_id'),
            'judul_khotbah' => $this->request->getPost('judul_khotbah'),
            'keterangan'    => $this->request->getPost('keterangan')
        ];

        try {
            $this->jadwalJumatModel->update($id, $data);
            
            // Catat Audit Trail (Before vs After)
            log_activity('UPDATE', 'trn_jadwal_jumat', $id, $jadwal, array_merge($jadwal, $data));

            return redirect()->to('/dashboard/jadwal-jumat')->with('success', 'Jadwal Jumat berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Jadwal Jumat (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jadwal = $this->jadwalJumatModel->find($id);

        if (!$jadwal) {
            return redirect()->to('/dashboard/jadwal-jumat')->with('error', 'Data jadwal tidak ditemukan.');
        }

        try {
            $this->jadwalJumatModel->delete($id);
            
            // Catat Audit Trail
            log_activity('DELETE', 'trn_jadwal_jumat', $id, $jadwal, null);

            return redirect()->to('/dashboard/jadwal-jumat')->with('success', 'Jadwal Jumat berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/jadwal-jumat')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
