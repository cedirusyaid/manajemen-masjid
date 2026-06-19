<?php

namespace App\Controllers;

use App\Models\PeriodePengurusModel;
use App\Models\PengurusModel;
use App\Models\PersonilModel;
use Exception;

class KepengurusanController extends BaseController
{
    protected $periodeModel;
    protected $pengurusModel;
    protected $personilModel;
    protected $session;

    public function __construct()
    {
        $this->periodeModel  = new PeriodePengurusModel();
        $this->pengurusModel = new PengurusModel();
        $this->personilModel = new PersonilModel();
        $this->session       = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Tampilkan Kelola Kepengurusan
     */
    public function index()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $periodeList  = $this->periodeModel->where('deleted_at', null)->orderBy('tahun_mulai', 'DESC')->findAll();
        
        // Cari periode aktif untuk default
        $activePeriode = null;
        foreach ($periodeList as $p) {
            if ($p['status'] === 'aktif') {
                $activePeriode = $p['id'];
                break;
            }
        }
        
        // Ambil filter periode dari request GET
        $selectedPeriode = $this->request->getVar('periode_id');
        if ($selectedPeriode === null) {
            $selectedPeriode = $activePeriode;
        }

        $pengurusList = [];
        if (!empty($selectedPeriode)) {
            $pengurusList = $this->pengurusModel->getPengurusByPeriode($selectedPeriode);
        }

        return view('dashboard/kepengurusan/index', [
            'username'         => $this->session->get('username'),
            'role_name'        => $this->session->get('role_name'),
            'avatar'           => $this->session->get('avatar'),
            'periode_list'     => $periodeList,
            'pengurus_list'    => $pengurusList,
            'selected_periode' => $selectedPeriode
        ]);
    }

    // ==========================================
    // PERIODE CRUD
    // ==========================================

    public function createPeriode()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        return view('dashboard/kepengurusan/periode_create', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
            'validation'=> \Config\Services::validation()
        ]);
    }

    public function storePeriode()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'nama_periode'  => 'required|min_length[3]|max_length[100]',
            'tahun_mulai'   => 'required|integer|exact_length[4]',
            'tahun_selesai' => 'required|integer|exact_length[4]',
            'status'        => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'nama_periode'  => $this->request->getPost('nama_periode'),
            'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'status'        => $this->request->getPost('status')
        ];

        // Jika status diset aktif, nonaktifkan periode lain
        if ($data['status'] === 'aktif') {
            $this->periodeModel->where('status', 'aktif')->set(['status' => 'tidak_aktif'])->update();
        }

        try {
            $this->periodeModel->insert($data);
            $newId = $this->periodeModel->getInsertID() ?: $this->periodeModel->db->insertID();
            
            // Log Activity
            log_activity('INSERT', 'mst_periode_pengurus', $newId, null, $data);

            return redirect()->to('/dashboard/kepengurusan')->with('success', 'Periode kepengurusan baru berhasil disimpan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data periode: ' . $e->getMessage());
        }
    }

    public function editPeriode($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $periode = $this->periodeModel->find($id);
        if (!$periode) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data periode tidak ditemukan.');
        }

        return view('dashboard/kepengurusan/periode_edit', [
            'username'   => $this->session->get('username'),
            'role_name'  => $this->session->get('role_name'),
            'avatar'     => $this->session->get('avatar'),
            'periode'    => $periode,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function updatePeriode($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $periodeBefore = $this->periodeModel->find($id);
        if (!$periodeBefore) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data periode tidak ditemukan.');
        }

        $rules = [
            'nama_periode'  => 'required|min_length[3]|max_length[100]',
            'tahun_mulai'   => 'required|integer|exact_length[4]',
            'tahun_selesai' => 'required|integer|exact_length[4]',
            'status'        => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'nama_periode'  => $this->request->getPost('nama_periode'),
            'tahun_mulai'   => $this->request->getPost('tahun_mulai'),
            'tahun_selesai' => $this->request->getPost('tahun_selesai'),
            'status'        => $this->request->getPost('status')
        ];

        // Jika status diset aktif, nonaktifkan periode lain
        if ($data['status'] === 'aktif') {
            $this->periodeModel->where('status', 'aktif')->where('id !=', $id)->set(['status' => 'tidak_aktif'])->update();
        }

        try {
            $this->periodeModel->update($id, $data);
            
            // Log Activity
            log_activity('UPDATE', 'mst_periode_pengurus', $id, $periodeBefore, $data);

            return redirect()->to('/dashboard/kepengurusan')->with('success', 'Data periode kepengurusan berhasil diubah.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data periode: ' . $e->getMessage());
        }
    }

    public function deletePeriode($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $periodeBefore = $this->periodeModel->find($id);
        if (!$periodeBefore) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data periode tidak ditemukan.');
        }

        try {
            $this->periodeModel->delete($id);

            // Log Activity
            log_activity('DELETE', 'mst_periode_pengurus', $id, $periodeBefore, null);

            return redirect()->to('/dashboard/kepengurusan')->with('success', 'Data periode kepengurusan berhasil dihapus (Soft Delete).');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Gagal menghapus data periode: ' . $e->getMessage());
        }
    }

    // ==========================================
    // PENGURUS CRUD
    // ==========================================

    public function createPengurus()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $periodeList  = $this->periodeModel->where('deleted_at', null)->orderBy('tahun_mulai', 'DESC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $pengurusList = $this->pengurusModel->select('trn_pengurus.*, mst_personil.nama')
                            ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                            ->where('trn_pengurus.deleted_at', null)
                            ->findAll();

        $selectedPeriode = $this->request->getVar('periode_id');

        return view('dashboard/kepengurusan/pengurus_create', [
            'username'         => $this->session->get('username'),
            'role_name'        => $this->session->get('role_name'),
            'avatar'           => $this->session->get('avatar'),
            'periode_list'     => $periodeList,
            'personil_list'    => $personilList,
            'pengurus_list'    => $pengurusList,
            'selected_periode' => $selectedPeriode,
            'validation'       => \Config\Services::validation()
        ]);
    }

    public function storePengurus()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $rules = [
            'periode_id'  => 'required',
            'personil_id' => 'required',
            'parent_id'   => 'permit_empty',
            'jabatan'     => 'required|min_length[2]|max_length[100]',
            'urutan'      => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'periode_id'  => $this->request->getPost('periode_id'),
            'personil_id' => $this->request->getPost('personil_id'),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'jabatan'     => $this->request->getPost('jabatan'),
            'urutan'      => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->pengurusModel->insert($data);
            $newId = $this->pengurusModel->getInsertID() ?: $this->pengurusModel->db->insertID();

            // Log Activity
            log_activity('INSERT', 'trn_pengurus', $newId, null, $data);

            return redirect()->to('/dashboard/kepengurusan?periode_id=' . $data['periode_id'])->with('success', 'Anggota pengurus baru berhasil ditambahkan.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan anggota pengurus: ' . $e->getMessage());
        }
    }

    public function editPengurus($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pengurus = $this->pengurusModel->find($id);
        if (!$pengurus) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data pengurus tidak ditemukan.');
        }

        $periodeList  = $this->periodeModel->where('deleted_at', null)->orderBy('tahun_mulai', 'DESC')->findAll();
        $personilList = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $pengurusList = $this->pengurusModel->select('trn_pengurus.*, mst_personil.nama')
                            ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                            ->where('trn_pengurus.id !=', $id)
                            ->where('trn_pengurus.deleted_at', null)
                            ->findAll();

        $selectedPeriode = $this->request->getVar('periode_id');

        return view('dashboard/kepengurusan/pengurus_edit', [
            'username'         => $this->session->get('username'),
            'role_name'        => $this->session->get('role_name'),
            'avatar'           => $this->session->get('avatar'),
            'pengurus'         => $pengurus,
            'periode_list'     => $periodeList,
            'personil_list'    => $personilList,
            'pengurus_list'    => $pengurusList,
            'selected_periode' => $selectedPeriode,
            'validation'       => \Config\Services::validation()
        ]);
    }

    public function updatePengurus($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pengurusBefore = $this->pengurusModel->find($id);
        if (!$pengurusBefore) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data pengurus tidak ditemukan.');
        }

        $rules = [
            'periode_id'  => 'required',
            'personil_id' => 'required',
            'parent_id'   => 'permit_empty',
            'jabatan'     => 'required|min_length[2]|max_length[100]',
            'urutan'      => 'permit_empty|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal, mohon periksa kembali inputan Anda.');
        }

        $data = [
            'periode_id'  => $this->request->getPost('periode_id'),
            'personil_id' => $this->request->getPost('personil_id'),
            'parent_id'   => $this->request->getPost('parent_id') ?: null,
            'jabatan'     => $this->request->getPost('jabatan'),
            'urutan'      => (int)$this->request->getPost('urutan') ?: 0
        ];

        try {
            $this->pengurusModel->update($id, $data);

            // Log Activity
            log_activity('UPDATE', 'trn_pengurus', $id, $pengurusBefore, $data);

            return redirect()->to('/dashboard/kepengurusan?periode_id=' . $data['periode_id'])->with('success', 'Data anggota pengurus berhasil diperbarui.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data pengurus: ' . $e->getMessage());
        }
    }

    public function deletePengurus($id)
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $pengurusBefore = $this->pengurusModel->find($id);
        if (!$pengurusBefore) {
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Data pengurus tidak ditemukan.');
        }

        try {
            $this->pengurusModel->delete($id);

            // Log Activity
            log_activity('DELETE', 'trn_pengurus', $id, $pengurusBefore, null);

            $periodeId = $pengurusBefore['periode_id'];
            return redirect()->to('/dashboard/kepengurusan?periode_id=' . $periodeId)->with('success', 'Anggota pengurus berhasil dihapus.');
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/kepengurusan')->with('error', 'Gagal menghapus data pengurus: ' . $e->getMessage());
        }
    }
}
