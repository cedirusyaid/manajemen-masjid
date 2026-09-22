<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\PersonilModel;
use App\Models\KegiatanModel;
use App\Models\UserKegiatanModel;
use Exception;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;
    protected $personilModel;
    protected $kegiatanModel;
    protected $userKegiatanModel;
    protected $session;

    public function __construct()
    {
        $this->userModel         = new UserModel();
        $this->roleModel         = new RoleModel();
        $this->personilModel     = new PersonilModel();
        $this->kegiatanModel     = new KegiatanModel();
        $this->userKegiatanModel = new UserKegiatanModel();
        $this->session           = \Config\Services::session();
        helper(['url', 'form', 'audit_helper', 'telegram_helper']);
    }

    /**
     * Memeriksa akses khusus Super Admin (Role ID 1)
     */
    protected function checkSuperAdminAccess()
    {
        if ($redirect = $this->checkAdminAccess()) {
            return $redirect;
        }

        $roleId = (int) $this->session->get('role_id');
        if ($roleId !== 1) {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak. Menu Manajemen Pengguna hanya dapat diakses oleh Super Admin.');
        }

        return null;
    }

    /**
     * Tampilkan Daftar Pengguna & Filter
     */
    public function index()
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $roleId  = $this->request->getVar('role_id');
        $status  = $this->request->getVar('status');
        $keyword = trim($this->request->getVar('q') ?? '');

        $users = $this->userModel->getUsersWithDetails($roleId, $status, $keyword);
        $roles = $this->roleModel->findAll();

        // Ambil daftar kepanitiaan yang ditugaskan ke masing-masing user
        foreach ($users as &$u) {
            $u['kepanitiaan_list'] = $this->userKegiatanModel->getKegiatanByUser($u['id']);
        }

        // Hitung statistik user
        $totalUsers    = $this->userModel->where('deleted_at', null)->countAllResults();
        $activeUsers   = $this->userModel->where('deleted_at', null)->where('status', 'active')->countAllResults();
        $inactiveUsers = $this->userModel->where('deleted_at', null)->where('status', 'inactive')->countAllResults();
        $superAdmins   = $this->userModel->where('deleted_at', null)->where('role_id', 1)->countAllResults();

        return view('dashboard/users/index', [
            'username'       => $this->session->get('username'),
            'role_name'      => $this->session->get('role_name'),
            'avatar'         => $this->session->get('avatar'),
            'current_user_id'=> $this->session->get('user_id'),
            'users'          => $users,
            'roles'          => $roles,
            'filter_role'    => $roleId,
            'filter_status'  => $status,
            'filter_keyword' => $keyword,
            'stats'          => [
                'total'    => $totalUsers,
                'active'   => $activeUsers,
                'inactive' => $inactiveUsers,
                'super'    => $superAdmins
            ]
        ]);
    }

    /**
     * Form Tambah Pengguna Baru
     */
    public function create()
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $roles     = $this->roleModel->findAll();
        $personils = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $kegiatans = $this->kegiatanModel->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();

        return view('dashboard/users/create', [
            'username'  => $this->session->get('username'),
            'role_name' => $this->session->get('role_name'),
            'avatar'    => $this->session->get('avatar'),
            'roles'     => $roles,
            'personils' => $personils,
            'kegiatans' => $kegiatans
        ]);
    }

    /**
     * Simpan Pengguna Baru
     */
    public function store()
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $username    = trim($this->request->getPost('username'));
        $email       = trim($this->request->getPost('email'));
        $password    = $this->request->getPost('password');
        $roleId      = (int) $this->request->getPost('role_id');
        $personilId  = $this->request->getPost('personil_id') ?: null;
        $status      = $this->request->getPost('status') ?? 'active';
        $kegiatanIds = $this->request->getPost('kegiatan_ids') ?? [];

        // Validasi Duplikasi
        $existsUser = $this->userModel->where('username', $username)->first();
        if ($existsUser) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan oleh akun lain.');
        }

        $existsEmail = $this->userModel->where('email', $email)->first();
        if ($existsEmail) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar pada sistem.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal terdiri dari 6 karakter.');
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
            'id'          => $newId,
            'username'    => $username,
            'email'       => $email,
            'password'    => $password, // Akan di-hash otomatis oleh Model callback
            'role_id'     => $roleId,
            'personil_id' => $personilId,
            'status'      => $status
        ];

        try {
            $this->userModel->insert($data);

            // Sinkronisasi Kepanitiaan yang Ditugaskan
            if (!empty($kegiatanIds)) {
                $this->userKegiatanModel->syncUserKegiatan($newId, $kegiatanIds);
            }

            log_activity('INSERT', 'sys_users', $newId, null, [
                'username'     => $username,
                'email'        => $email,
                'role_id'      => $roleId,
                'status'       => $status,
                'kegiatan_ids' => $kegiatanIds
            ]);

            return redirect()->to('/dashboard/users')->with('success', "Pengguna '{$username}' berhasil ditambahkan.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    /**
     * Form Edit Pengguna
     */
    public function edit(string $id)
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/dashboard/users')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $roles               = $this->roleModel->findAll();
        $personils           = $this->personilModel->where('deleted_at', null)->orderBy('nama', 'ASC')->findAll();
        $kegiatans           = $this->kegiatanModel->where('deleted_at', null)->orderBy('nama_kegiatan', 'ASC')->findAll();
        $assignedKegiatanIds = $this->userKegiatanModel->getKegiatanIdsByUser($id);

        return view('dashboard/users/edit', [
            'username'              => $this->session->get('username'),
            'role_name'             => $this->session->get('role_name'),
            'avatar'                => $this->session->get('avatar'),
            'user'                  => $user,
            'roles'                 => $roles,
            'personils'             => $personils,
            'kegiatans'             => $kegiatans,
            'assigned_kegiatan_ids' => $assignedKegiatanIds
        ]);
    }

    /**
     * Update Pengguna
     */
    public function update(string $id)
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $oldUser = $this->userModel->find($id);
        if (!$oldUser) {
            return redirect()->to('/dashboard/users')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $username    = trim($this->request->getPost('username'));
        $email       = trim($this->request->getPost('email'));
        $password    = $this->request->getPost('password');
        $roleId      = (int) $this->request->getPost('role_id');
        $personilId  = $this->request->getPost('personil_id') ?: null;
        $status      = $this->request->getPost('status') ?? 'active';
        $kegiatanIds = $this->request->getPost('kegiatan_ids') ?? [];

        // Validasi Duplikasi
        $existsUser = $this->userModel->where('username', $username)->where('id !=', $id)->first();
        if ($existsUser) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan oleh akun lain.');
        }

        $existsEmail = $this->userModel->where('email', $email)->where('id !=', $id)->first();
        if ($existsEmail) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar pada sistem.');
        }

        // Cegah Super Admin menonaktifkan akunnya sendiri
        $currentUserId = $this->session->get('user_id');
        if ($id === $currentUserId && $status === 'inactive') {
            return redirect()->back()->withInput()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri saat sedang aktif login.');
        }

        $data = [
            'username'    => $username,
            'email'       => $email,
            'role_id'     => $roleId,
            'personil_id' => $personilId,
            'status'      => $status
        ];

        // Jika password diisi, update password
        if (!empty($password)) {
            if (strlen($password) < 6) {
                return redirect()->back()->withInput()->with('error', 'Password minimal terdiri dari 6 karakter.');
            }
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        try {
            $this->userModel->update($id, $data);

            // Sinkronisasi Penugasan Kepanitiaan (Many-to-Many)
            $this->userKegiatanModel->syncUserKegiatan($id, $kegiatanIds);

            log_activity('UPDATE', 'sys_users', $id, $oldUser, array_merge($data, ['kegiatan_ids' => $kegiatanIds]));

            return redirect()->to('/dashboard/users')->with('success', "Data pengguna '{$username}' berhasil diperbarui.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Toggle Status Pengguna (Active / Inactive)
     */
    public function toggleStatus(string $id)
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/dashboard/users')->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Cegah mengubah status akun sendiri
        $currentUserId = $this->session->get('user_id');
        if ($id === $currentUserId) {
            return redirect()->to('/dashboard/users')->with('error', 'Anda tidak dapat mengubah status aktif akun Anda sendiri.');
        }

        $newStatus = ($user['status'] === 'active') ? 'inactive' : 'active';

        try {
            $this->userModel->update($id, ['status' => $newStatus]);
            log_activity('TOGGLE_STATUS', 'sys_users', $id, ['status' => $user['status']], ['status' => $newStatus]);

            $label = ($newStatus === 'active') ? 'diaktifkan' : 'dinonaktifkan';
            return redirect()->to('/dashboard/users')->with('success', "Akun '{$user['username']}' berhasil {$label}.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/users')->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Hapus Pengguna (Soft Delete)
     */
    public function delete(string $id)
    {
        if ($redirect = $this->checkSuperAdminAccess()) {
            return $redirect;
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/dashboard/users')->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Cegah menghapus akun sendiri
        $currentUserId = $this->session->get('user_id');
        if ($id === $currentUserId) {
            return redirect()->to('/dashboard/users')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang login.');
        }

        try {
            $this->userModel->delete($id);
            log_activity('DELETE', 'sys_users', $id, $user, null);

            return redirect()->to('/dashboard/users')->with('success', "Pengguna '{$user['username']}' berhasil dihapus.");
        } catch (Exception $e) {
            telegram_log_error($e);
            return redirect()->to('/dashboard/users')->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}
