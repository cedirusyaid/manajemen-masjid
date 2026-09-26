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

        // Ambil seluruh personil/petugas masjid tanpa pemisahan peran
        $petugasList = $this->imamKhatibModel->getAllPetugasUnified();

        return view('dashboard/jadwal_jumat/create', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'petugas_list' => $petugasList,
            'khatib_list'  => $petugasList,
            'imam_list'    => $petugasList,
            'muadzin_list' => $petugasList,
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
            'khatib_id'     => 'required|max_length[36]',
            'imam_id'       => 'required|max_length[36]',
            'muadzin_id'    => 'permit_empty',
            'judul_khotbah' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $newId = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

        $data = [
            'id'            => $newId,
            'tanggal'       => $this->request->getPost('tanggal'),
            'khatib_id'     => $this->request->getPost('khatib_id'),
            'imam_id'       => $this->request->getPost('imam_id'),
            'muadzin_id'    => $this->request->getPost('muadzin_id') ?: null,
            'judul_khotbah' => $this->request->getPost('judul_khotbah'),
            'keterangan'    => $this->request->getPost('keterangan')
        ];

        try {
            $this->jadwalJumatModel->insert($data);
            
            // Catat Audit Trail
            log_activity('INSERT', 'trn_jadwal_jumat', $newId, null, $data);

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

        // Ambil seluruh personil/petugas masjid tanpa pemisahan peran
        $petugasList = $this->imamKhatibModel->getAllPetugasUnified();

        return view('dashboard/jadwal_jumat/edit', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'jadwal'       => $jadwal,
            'petugas_list' => $petugasList,
            'khatib_list'  => $petugasList,
            'imam_list'    => $petugasList,
            'muadzin_list' => $petugasList,
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
            'muadzin_id'    => 'permit_empty',
            'judul_khotbah' => 'permit_empty|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'tanggal'       => $this->request->getPost('tanggal'),
            'khatib_id'     => $this->request->getPost('khatib_id'),
            'imam_id'       => $this->request->getPost('imam_id'),
            'muadzin_id'    => $this->request->getPost('muadzin_id') ?: null,
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
     * Tambah Petugas (Khatib/Imam/Muadzin) Baru via AJAX (Quick Add)
     */
    public function ajaxAddPetugas()
    {
        if ($this->session->get('role_name') === 'Jemaah' || !$this->session->get('username')) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Akses ditolak.'
            ])->setStatusCode(403);
        }

        $rules = [
            'nama'    => 'required|min_length[3]|max_length[150]',
            'jabatan' => 'required|in_list[khatib,imam,muadzin,imam_khatib]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => implode(' | ', $this->validator->getErrors())
            ]);
        }

        $nama    = trim($this->request->getPost('nama'));
        $jabatan = $this->request->getPost('jabatan');

        try {
            // 1. Simpan ke mst_personil
            $personilModel = new \App\Models\PersonilModel();
            $personilId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            $personilData  = [
                'id'            => $personilId,
                'nama'          => $nama,
                'jenis_kelamin' => 'L',
                'tipe_default'  => 'ustadz,petugas'
            ];
            $personilModel->insert($personilData);

            // 2. Simpan ke mst_imam_khatib
            $newImamKhatibId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
            $imamKhatibData = [
                'id'          => $newImamKhatibId,
                'personil_id' => $personilId,
                'jabatan'     => $jabatan,
                'bio'         => 'Petugas Tambahan'
            ];
            $this->imamKhatibModel->insert($imamKhatibData);

            // Catat Audit Trail
            log_activity('INSERT', 'mst_imam_khatib', $newImamKhatibId, null, $imamKhatibData);

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Petugas baru berhasil ditambahkan.',
                'data'    => [
                    'id'      => $newImamKhatibId,
                    'nama'    => $nama,
                    'jabatan' => $jabatan
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
