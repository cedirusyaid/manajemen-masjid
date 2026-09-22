<?php

namespace App\Controllers;

use App\Models\LayananModel;
use App\Models\PelayananModel;
use App\Models\PersonilModel;
use Exception;

class LayananController extends BaseController
{
    protected $layananModel;
    protected $pelayananModel;
    protected $personilModel;
    protected $session;

    public function __construct()
    {
        $this->layananModel   = new LayananModel();
        $this->pelayananModel = new PelayananModel();
        $this->personilModel  = new PersonilModel();
        $this->session        = \Config\Services::session();
        helper(['url', 'form', 'site_helper', 'audit_helper', 'telegram_helper']);
    }

    // ==========================================
    // MASTER LAYANAN CRUD
    // ==========================================

    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layananList = $this->layananModel->select('mst_layanan.*, mst_personil.nama as nama_pj, (SELECT COUNT(*) FROM trn_pelayanan WHERE trn_pelayanan.layanan_id = mst_layanan.id AND trn_pelayanan.deleted_at IS NULL) as total_pelayanan')
                                          ->join('mst_personil', 'mst_personil.id = mst_layanan.pj_personil_id', 'left')
                                          ->where('mst_layanan.deleted_at', null)
                                          ->orderBy('mst_layanan.urutan', 'ASC')
                                          ->findAll();

        return view('dashboard/layanan/index', [
            'username'     => $this->session->get('username'),
            'role_name'    => $this->session->get('role_name'),
            'avatar'       => $this->session->get('avatar'),
            'layanan_list' => $layananList
        ]);
    }

    public function create()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/layanan/create', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'personil_list' => $personilList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    public function store()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'nama_layanan' => 'required|min_length[3]|max_length[150]',
            'icon'         => 'permit_empty',
            'warna_tema'   => 'required|in_list[success,primary,warning,danger,info,secondary]',
            'kontak_wa'    => 'permit_empty',
            'urutan'       => 'permit_empty|integer',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, silakan periksa inputan Anda.');
        }

        $data = [
            'nama_layanan'     => $this->request->getPost('nama_layanan'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'icon'             => $this->request->getPost('icon') ?: 'fa-solid fa-hand-holding-heart',
            'warna_tema'       => $this->request->getPost('warna_tema'),
            'kontak_wa'        => $this->request->getPost('kontak_wa'),
            'pesan_wa_default' => $this->request->getPost('pesan_wa_default'),
            'pj_personil_id'   => $this->request->getPost('pj_personil_id') ?: null,
            'urutan'           => (int)$this->request->getPost('urutan') ?: 0,
            'status'           => $this->request->getPost('status')
        ];

        try {
            $this->layananModel->insert($data);
            $newId = $this->layananModel->getInsertID() ?: $this->layananModel->db->insertID();

            log_activity('INSERT', 'mst_layanan', $newId, null, $data);

            return redirect()->to('/dashboard/layanan')->with('success', 'Layanan baru berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan layanan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layanan = $this->layananModel->find($id);
        if (!$layanan) {
            return redirect()->to('/dashboard/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/layanan/edit', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'layanan'       => $layanan,
            'personil_list' => $personilList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layananBefore = $this->layananModel->find($id);
        if (!$layananBefore) {
            return redirect()->to('/dashboard/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        $rules = [
            'nama_layanan' => 'required|min_length[3]|max_length[150]',
            'icon'         => 'permit_empty',
            'warna_tema'   => 'required|in_list[success,primary,warning,danger,info,secondary]',
            'kontak_wa'    => 'permit_empty',
            'urutan'       => 'permit_empty|integer',
            'status'       => 'required|in_list[aktif,nonaktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, silakan periksa inputan Anda.');
        }

        $data = [
            'nama_layanan'     => $this->request->getPost('nama_layanan'),
            'deskripsi'        => $this->request->getPost('deskripsi'),
            'icon'             => $this->request->getPost('icon') ?: 'fa-solid fa-hand-holding-heart',
            'warna_tema'       => $this->request->getPost('warna_tema'),
            'kontak_wa'        => $this->request->getPost('kontak_wa'),
            'pesan_wa_default' => $this->request->getPost('pesan_wa_default'),
            'pj_personil_id'   => $this->request->getPost('pj_personil_id') ?: null,
            'urutan'           => (int)$this->request->getPost('urutan') ?: 0,
            'status'           => $this->request->getPost('status')
        ];

        try {
            $this->layananModel->update($id, $data);

            log_activity('UPDATE', 'mst_layanan', $id, $layananBefore, $data);

            return redirect()->to('/dashboard/layanan')->with('success', 'Data layanan berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui layanan: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layananBefore = $this->layananModel->find($id);
        if (!$layananBefore) {
            return redirect()->to('/dashboard/layanan')->with('error', 'Layanan tidak ditemukan.');
        }

        try {
            $this->layananModel->delete($id);

            log_activity('DELETE', 'mst_layanan', $id, $layananBefore, null);

            return redirect()->to('/dashboard/layanan')->with('success', 'Layanan berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/layanan')->with('error', 'Gagal menghapus layanan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // TRANSAKSI PELAYANAN JAMAAH
    // ==========================================

    public function pelayananIndex()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layananFilter = $this->request->getVar('layanan_id');
        $pelayananList = $this->pelayananModel->getPelayananLengkap(null, $layananFilter);
        $layananList   = $this->layananModel->where('deleted_at', null)->orderBy('nama_layanan', 'ASC')->findAll();

        return view('dashboard/layanan/pelayanan_index', [
            'username'       => $this->session->get('username'),
            'role_name'      => $this->session->get('role_name'),
            'avatar'         => $this->session->get('avatar'),
            'pelayanan_list' => $pelayananList,
            'layanan_list'   => $layananList,
            'selected_layanan' => $layananFilter
        ]);
    }

    public function createPelayanan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $layananList  = $this->layananModel->where('status', 'aktif')->where('deleted_at', null)->orderBy('nama_layanan', 'ASC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/layanan/pelayanan_create', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'layanan_list'      => $layananList,
            'personil_list'     => $personilList,
            'selected_layanan'  => $this->request->getVar('layanan_id'),
            'validation'        => \Config\Services::validation()
        ]);
    }

    public function storePelayanan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $userId = $this->session->get('user_id');

        $rules = [
            'layanan_id'        => 'required|max_length[36]',
            'tanggal'           => 'required|valid_date[Y-m-d]',
            'nama_pemohon'      => 'required|min_length[3]|max_length[150]',
            'no_hp_pemohon'     => 'permit_empty',
            'rincian_kebutuhan' => 'required',
            'status_layanan'    => 'required|in_list[diajukan,diproses,selesai,ditolak]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, silakan periksa inputan Anda.');
        }

        $data = [
            'layanan_id'          => $this->request->getPost('layanan_id'),
            'user_id'             => $userId, // Pencatat inputter
            'tanggal'             => $this->request->getPost('tanggal'),
            'nama_pemohon'        => $this->request->getPost('nama_pemohon'),
            'nik_pemohon'         => $this->request->getPost('nik_pemohon'),
            'no_hp_pemohon'       => $this->request->getPost('no_hp_pemohon'),
            'alamat_pemohon'      => $this->request->getPost('alamat_pemohon'),
            'rincian_kebutuhan'   => $this->request->getPost('rincian_kebutuhan'),
            'tindakan_petugas'    => $this->request->getPost('tindakan_petugas'),
            'petugas_personil_id' => $this->request->getPost('petugas_personil_id') ?: null,
            'biaya_infaq'         => (float)str_replace(['.', ','], ['', '.'], $this->request->getPost('biaya_infaq') ?: '0'),
            'status_layanan'      => $this->request->getPost('status_layanan')
        ];

        try {
            $this->pelayananModel->insert($data);
            $newId = $this->pelayananModel->getInsertID() ?: $this->pelayananModel->db->insertID();

            log_activity('INSERT', 'trn_pelayanan', $newId, null, $data);

            return redirect()->to('/dashboard/pelayanan')->with('success', 'Catatan pelayanan jemaah berhasil disimpan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal mencatat pelayanan: ' . $e->getMessage());
        }
    }

    public function editPelayanan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pelayanan = $this->pelayananModel->find($id);
        if (!$pelayanan) {
            return redirect()->to('/dashboard/pelayanan')->with('error', 'Data pelayanan tidak ditemukan.');
        }

        $layananList  = $this->layananModel->where('status', 'aktif')->where('deleted_at', null)->orderBy('nama_layanan', 'ASC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();

        return view('dashboard/layanan/pelayanan_edit', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'pelayanan'     => $pelayanan,
            'layanan_list'  => $layananList,
            'personil_list' => $personilList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    public function updatePelayanan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pelayananBefore = $this->pelayananModel->find($id);
        if (!$pelayananBefore) {
            return redirect()->to('/dashboard/pelayanan')->with('error', 'Data pelayanan tidak ditemukan.');
        }

        $rules = [
            'layanan_id'        => 'required|max_length[36]',
            'tanggal'           => 'required|valid_date[Y-m-d]',
            'nama_pemohon'      => 'required|min_length[3]|max_length[150]',
            'no_hp_pemohon'     => 'permit_empty',
            'rincian_kebutuhan' => 'required',
            'status_layanan'    => 'required|in_list[diajukan,diproses,selesai,ditolak]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, silakan periksa inputan Anda.');
        }

        $data = [
            'layanan_id'          => $this->request->getPost('layanan_id'),
            'tanggal'             => $this->request->getPost('tanggal'),
            'nama_pemohon'        => $this->request->getPost('nama_pemohon'),
            'nik_pemohon'         => $this->request->getPost('nik_pemohon'),
            'no_hp_pemohon'       => $this->request->getPost('no_hp_pemohon'),
            'alamat_pemohon'      => $this->request->getPost('alamat_pemohon'),
            'rincian_kebutuhan'   => $this->request->getPost('rincian_kebutuhan'),
            'tindakan_petugas'    => $this->request->getPost('tindakan_petugas'),
            'petugas_personil_id' => $this->request->getPost('petugas_personil_id') ?: null,
            'biaya_infaq'         => (float)str_replace(['.', ','], ['', '.'], $this->request->getPost('biaya_infaq') ?: '0'),
            'status_layanan'      => $this->request->getPost('status_layanan')
        ];

        try {
            $this->pelayananModel->update($id, $data);

            log_activity('UPDATE', 'trn_pelayanan', $id, $pelayananBefore, $data);

            return redirect()->to('/dashboard/pelayanan')->with('success', 'Data pelayanan berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui pelayanan: ' . $e->getMessage());
        }
    }

    public function deletePelayanan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pelayananBefore = $this->pelayananModel->find($id);
        if (!$pelayananBefore) {
            return redirect()->to('/dashboard/pelayanan')->with('error', 'Data pelayanan tidak ditemukan.');
        }

        try {
            $this->pelayananModel->delete($id);

            log_activity('DELETE', 'trn_pelayanan', $id, $pelayananBefore, null);

            return redirect()->to('/dashboard/pelayanan')->with('success', 'Data pelayanan berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/pelayanan')->with('error', 'Gagal menghapus pelayanan: ' . $e->getMessage());
        }
    }
}
