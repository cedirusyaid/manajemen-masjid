<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PanitiaModel;
use App\Models\PersonilModel;
use Exception;

class KepanitiaanController extends BaseController
{
    protected $kegiatanModel;
    protected $panitiaModel;
    protected $personilModel;
    protected $session;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        $this->panitiaModel  = new PanitiaModel();
        $this->personilModel = new PersonilModel();
        $this->session       = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Kelola Kepanitiaan & Kegiatan
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $panitiaList  = $this->panitiaModel->getPanitiaWithKegiatan();

        return view('dashboard/kepanitiaan/index', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'kegiatan_list' => $kegiatanList,
            'panitia_list'  => $panitiaList
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

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Kegiatan baru berhasil dibuat.');
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

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Kegiatan berhasil diperbarui.');
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
        $panitiaList  = $this->panitiaModel->select('trn_panitia.*, mst_personil.nama')
                            ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                            ->where('trn_panitia.deleted_at', null)
                            ->findAll();

        return view('dashboard/kepanitiaan/panitia_create', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'kegiatan_list' => $kegiatanList,
            'personil_list' => $personilList,
            'panitia_list'  => $panitiaList,
            'validation'    => \Config\Services::validation()
        ]);
    }

    public function storePanitia()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'kegiatan_id' => 'required',
            'personil_id' => 'required',
            'parent_id'   => 'permit_empty',
            'jabatan'     => 'required|min_length[2]|max_length[100]',
            'tugas'       => 'permit_empty',
            'urutan'      => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kegiatan_id' => $this->request->getPost('kegiatan_id'),
            'personil_id' => $this->request->getPost('personil_id'),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'jabatan'     => $this->request->getPost('jabatan'),
            'tugas'       => $this->request->getPost('tugas'),
            'urutan'      => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->panitiaModel->insert($data);
            $newId = $this->panitiaModel->getInsertID() ?: $this->panitiaModel->db->insertID();

            // Log Activity
            log_activity('INSERT', 'trn_panitia', $newId, null, $data);

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Anggota panitia baru berhasil ditambahkan.');
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

        $kegiatanList = $this->kegiatanModel->where('deleted_at', null)->orderBy('tanggal_mulai', 'DESC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $panitiaList  = $this->panitiaModel->select('trn_panitia.*, mst_personil.nama')
                            ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                            ->where('trn_panitia.id !=', $id)
                            ->where('trn_panitia.deleted_at', null)
                            ->findAll();

        return view('dashboard/kepanitiaan/panitia_edit', [
            'username'      => $this->session->get('username'),
            'role_name'     => $this->session->get('role_name'),
            'avatar'        => $this->session->get('avatar'),
            'panitia'       => $panitia,
            'kegiatan_list' => $kegiatanList,
            'personil_list' => $personilList,
            'panitia_list'  => $panitiaList,
            'validation'    => \Config\Services::validation()
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
            'kegiatan_id' => 'required',
            'personil_id' => 'required',
            'parent_id'   => 'permit_empty',
            'jabatan'     => 'required|min_length[2]|max_length[100]',
            'tugas'       => 'permit_empty',
            'urutan'      => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'kegiatan_id' => $this->request->getPost('kegiatan_id'),
            'personil_id' => $this->request->getPost('personil_id'),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'jabatan'     => $this->request->getPost('jabatan'),
            'tugas'       => $this->request->getPost('tugas'),
            'urutan'      => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->panitiaModel->update($id, $data);

            // Log Activity
            log_activity('UPDATE', 'trn_panitia', $id, $panitiaBefore, $data);

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Data panitia berhasil diperbarui.');
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

            return redirect()->to('/dashboard/kepanitiaan')->with('success', 'Anggota panitia berhasil dihapus (Soft Delete).');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepanitiaan')->with('error', 'Gagal menghapus anggota panitia: ' . $e->getMessage());
        }
    }
}
