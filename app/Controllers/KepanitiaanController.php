<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PanitiaModel;
use App\Models\PersonilModel;
use App\Models\JabatanKegiatanModel;
use Exception;

class KepanitiaanController extends BaseController
{
    protected $kegiatanModel;
    protected $panitiaModel;
    protected $personilModel;
    protected $jabatanKegiatanModel;
    protected $session;

    public function __construct()
    {
        $this->kegiatanModel        = new KegiatanModel();
        $this->panitiaModel         = new PanitiaModel();
        $this->personilModel        = new PersonilModel();
        $this->jabatanKegiatanModel = new JabatanKegiatanModel();
        $this->session              = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Daftar Kegiatan (Halaman Depan Kepanitiaan)
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        
        return view('dashboard/kepanitiaan/index', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'kegiatan_list'     => $kegiatanList
        ]);
    }

    /**
     * Tampilkan Detail Kegiatan dengan Struktur Panitia & Struktur Jabatan Kegiatan
     */
    public function detail($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data kegiatan tidak ditemukan.');
        }

        $panitiaList = $this->panitiaModel->getPanitiaByKegiatan($id);
        $jabatanList = $this->jabatanKegiatanModel->getJabatanByKegiatan($id);

        return view('dashboard/kepanitiaan/detail', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'kegiatan'          => $kegiatan,
            'panitia_list'      => $panitiaList,
            'jabatan_list'      => $jabatanList,
            'validation'        => \Config\Services::validation()
        ]);
    }

    // ==========================================
    // KEGIATAN CRUD
    // ==========================================

    public function createKegiatan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/kepanitiaan/kegiatan_create', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'validation' => \Config\Services::validation()
        ]);
    }

    public function storeKegiatan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'nama_kegiatan'   => 'required|min_length[3]|max_length[255]',
            'tanggal_mulai'   => 'required|valid_date[Y-m-d]',
            'tanggal_selesai' => 'required|valid_date[Y-m-d]',
            'status'          => 'required|in_list[rencana,berjalan,selesai,dibatalkan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'nama_kegiatan'   => $this->request->getPost('nama_kegiatan'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'status'          => $this->request->getPost('status')
        ];

        try {
            $this->kegiatanModel->insert($data);
            $newId = $this->kegiatanModel->getInsertID() ?: $this->kegiatanModel->db->insertID();

            // Log Activity
            log_activity('INSERT', 'mst_kegiatan', $newId, null, $data);

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $newId)->with('success', 'Kegiatan baru berhasil dibuat.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal membuat kegiatan baru: ' . $e->getMessage());
        }
    }

    public function editKegiatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatan = $this->kegiatanModel->find($id);
        if (!$kegiatan) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Kegiatan tidak ditemukan.');
        }

        return view('dashboard/kepanitiaan/kegiatan_edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'kegiatan'   => $kegiatan,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function updateKegiatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanBefore = $this->kegiatanModel->find($id);
        if (!$kegiatanBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Kegiatan tidak ditemukan.');
        }

        $rules = [
            'nama_kegiatan'   => 'required|min_length[3]|max_length[255]',
            'tanggal_mulai'   => 'required|valid_date[Y-m-d]',
            'tanggal_selesai' => 'required|valid_date[Y-m-d]',
            'status'          => 'required|in_list[rencana,berjalan,selesai,dibatalkan]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'nama_kegiatan'   => $this->request->getPost('nama_kegiatan'),
            'tanggal_mulai'   => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'status'          => $this->request->getPost('status')
        ];

        try {
            $this->kegiatanModel->update($id, $data);

            // Log Activity
            log_activity('UPDATE', 'mst_kegiatan', $id, $kegiatanBefore, $data);

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $id)->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kegiatan: ' . $e->getMessage());
        }
    }

    public function deleteKegiatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanBefore = $this->kegiatanModel->find($id);
        if (!$kegiatanBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Kegiatan tidak ditemukan.');
        }

        try {
            $this->kegiatanModel->delete($id);

            // Log Activity
            log_activity('DELETE', 'mst_kegiatan', $id, $kegiatanBefore, null);

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Kegiatan berhasil dihapus (Soft Delete).');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Gagal menghapus kegiatan: ' . $e->getMessage());
        }
    }

    // ==========================================
    // PANITIA CRUD
    // ==========================================

    public function createPanitia()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $jabatanList  = $this->jabatanKegiatanModel->where('deleted_at', null)->orderBy('urutan', 'ASC')->findAll();

        $selectedKegiatan = $this->request->getVar('kegiatan_id');

        return view('dashboard/kepanitiaan/panitia_create', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'kegiatan_list'     => $kegiatanList,
            'personil_list'     => $personilList,
            'jabatan_list'      => $jabatanList,
            'selected_kegiatan' => $selectedKegiatan,
            'validation'        => \Config\Services::validation()
        ]);
    }

    public function storePanitia()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'jabatan_kegiatan_id' => 'required',
            'personil_id'         => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'jabatan_kegiatan_id' => $this->request->getPost('jabatan_kegiatan_id'),
            'personil_id'         => $this->request->getPost('personil_id')
        ];

        try {
            $this->panitiaModel->insert($data);
            $newId = $this->panitiaModel->getInsertID() ?: $this->panitiaModel->db->insertID();

            // Log Activity
            log_activity('INSERT', 'trn_panitia', $newId, null, $data);

            $jabatanInfo = $this->jabatanKegiatanModel->find($data['jabatan_kegiatan_id']);
            $kegiatanId = $jabatanInfo ? $jabatanInfo['kegiatan_id'] : '';

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $kegiatanId)->with('success', 'Anggota panitia baru berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan anggota panitia: ' . $e->getMessage());
        }
    }

    public function editPanitia($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $panitia = $this->panitiaModel->find($id);
        if (!$panitia) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data panitia tidak ditemukan.');
        }

        $currentJabatan = $this->jabatanKegiatanModel->find($panitia['jabatan_kegiatan_id']);
        $currentKegiatanId = $currentJabatan ? $currentJabatan['kegiatan_id'] : '';

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $jabatanList  = $this->jabatanKegiatanModel->where('deleted_at', null)->orderBy('urutan', 'ASC')->findAll();

        $selectedKegiatan = $this->request->getVar('kegiatan_id') ?: $currentKegiatanId;

        return view('dashboard/kepanitiaan/panitia_edit', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'panitia'           => $panitia,
            'kegiatan_list'     => $kegiatanList,
            'personil_list'     => $personilList,
            'jabatan_list'      => $jabatanList,
            'current_kegiatan_id'=> $currentKegiatanId,
            'selected_kegiatan' => $selectedKegiatan,
            'validation'        => \Config\Services::validation()
        ]);
    }

    public function updatePanitia($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $panitiaBefore = $this->panitiaModel->find($id);
        if (!$panitiaBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data panitia tidak ditemukan.');
        }

        $rules = [
            'jabatan_kegiatan_id' => 'required',
            'personil_id'         => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'jabatan_kegiatan_id' => $this->request->getPost('jabatan_kegiatan_id'),
            'personil_id'         => $this->request->getPost('personil_id')
        ];

        try {
            $this->panitiaModel->update($id, $data);

            // Log Activity
            log_activity('UPDATE', 'trn_panitia', $id, $panitiaBefore, $data);

            $jabatanInfo = $this->jabatanKegiatanModel->find($data['jabatan_kegiatan_id']);
            $kegiatanId = $jabatanInfo ? $jabatanInfo['kegiatan_id'] : '';

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $kegiatanId)->with('success', 'Data panitia berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data panitia: ' . $e->getMessage());
        }
    }

    public function deletePanitia($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $panitiaBefore = $this->panitiaModel->find($id);
        if (!$panitiaBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data panitia tidak ditemukan.');
        }

        try {
            $this->panitiaModel->delete($id);

            // Log Activity
            log_activity('DELETE', 'trn_panitia', $id, $panitiaBefore, null);

            $jabatanInfo = $this->jabatanKegiatanModel->find($panitiaBefore['jabatan_kegiatan_id']);
            $kegiatanId = $jabatanInfo ? $jabatanInfo['kegiatan_id'] : '';

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $kegiatanId)->with('success', 'Anggota panitia berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Gagal menghapus data panitia: ' . $e->getMessage());
        }
    }

    // ==========================================
    // JABATAN KEGIATAN CRUD
    // ==========================================

    public function createJabatan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $selectedKegiatan = $this->request->getVar('kegiatan_id');
        
        $jabatanList = [];
        if (!empty($selectedKegiatan)) {
            $jabatanList = $this->jabatanKegiatanModel->where('kegiatan_id', $selectedKegiatan)->where('deleted_at', null)->findAll();
        }

        return view('dashboard/kepanitiaan/jabatan_create', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'kegiatan_list'     => $kegiatanList,
            'jabatan_list'      => $jabatanList,
            'selected_kegiatan' => $selectedKegiatan,
            'validation'        => \Config\Services::validation()
        ]);
    }

    public function storeJabatan()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'kegiatan_id'  => 'required',
            'nama_jabatan' => 'required|min_length[2]|max_length[100]',
            'parent_id'    => 'permit_empty',
            'tugas'        => 'permit_empty',
            'urutan'       => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kegiatan_id'  => $this->request->getPost('kegiatan_id'),
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'parent_id'    => $this->request->getPost('parent_id') ?: null,
            'tugas'        => $this->request->getPost('tugas'),
            'urutan'       => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->jabatanKegiatanModel->insert($data);
            $newId = $this->jabatanKegiatanModel->getInsertID() ?: $this->jabatanKegiatanModel->db->insertID();

            // Log Activity
            log_activity('INSERT', 'trn_jabatan_kegiatan', $newId, null, $data);

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $data['kegiatan_id'])->with('success', 'Jabatan baru berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan jabatan: ' . $e->getMessage());
        }
    }

    public function editJabatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jabatan = $this->jabatanKegiatanModel->find($id);
        if (!$jabatan) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data jabatan tidak ditemukan.');
        }

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $jabatanList = $this->jabatanKegiatanModel->where('kegiatan_id', $jabatan['kegiatan_id'])
                                                 ->where('id !=', $id)
                                                 ->where('deleted_at', null)
                                                 ->findAll();

        $selectedKegiatan = $this->request->getVar('kegiatan_id') ?: $jabatan['kegiatan_id'];

        return view('dashboard/kepanitiaan/jabatan_edit', [
            'username'          => $this->session->get('username'),
            'role_name'         => $this->session->get('role_name'),
            'avatar'            => $this->session->get('avatar'),
            'jabatan'           => $jabatan,
            'kegiatan_list'     => $kegiatanList,
            'jabatan_list'      => $jabatanList,
            'selected_kegiatan' => $selectedKegiatan,
            'validation'        => \Config\Services::validation()
        ]);
    }

    public function updateJabatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jabatanBefore = $this->jabatanKegiatanModel->find($id);
        if (!$jabatanBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data jabatan tidak ditemukan.');
        }

        $rules = [
            'kegiatan_id'  => 'required',
            'nama_jabatan' => 'required|min_length[2]|max_length[100]',
            'parent_id'    => 'permit_empty',
            'tugas'        => 'permit_empty',
            'urutan'       => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kegiatan_id'  => $this->request->getPost('kegiatan_id'),
            'nama_jabatan' => $this->request->getPost('nama_jabatan'),
            'parent_id'    => $this->request->getPost('parent_id') ?: null,
            'tugas'        => $this->request->getPost('tugas'),
            'urutan'       => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->jabatanKegiatanModel->update($id, $data);

            // Log Activity
            log_activity('UPDATE', 'trn_jabatan_kegiatan', $id, $jabatanBefore, $data);

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $data['kegiatan_id'])->with('success', 'Data jabatan berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data jabatan: ' . $e->getMessage());
        }
    }

    public function deleteJabatan($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $jabatanBefore = $this->jabatanKegiatanModel->find($id);
        if (!$jabatanBefore) {
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Data jabatan tidak ditemukan.');
        }

        try {
            $this->jabatanKegiatanModel->delete($id);

            // Log Activity
            log_activity('DELETE', 'trn_jabatan_kegiatan', $id, $jabatanBefore, null);

            return redirect()->to('/dashboard/kepanitiaan/detail/' . $jabatanBefore['kegiatan_id'])->with('success', 'Jabatan berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Gagal menghapus data jabatan: ' . $e->getMessage());
        }
    }
}
