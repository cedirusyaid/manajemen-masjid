<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $table            = 'sys_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false; // Menggunakan UUID (CHAR(36))
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'username', 'password', 'email', 
        'google_id', 'avatar', 'personil_id', 'role_id', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks
    protected $beforeInsert   = ['generateUuid', 'hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    // Validation Rules
    protected $validationRules = [
        'username' => 'required|alpha_dash|min_length[4]|max_length[50]',
        'email'    => 'required|valid_email',
        'role_id'  => 'required|integer',
        'status'   => 'required|in_list[active,inactive]'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Otomatis generate UUID v4 untuk record baru
     */
    protected function generateUuid(array $data)
    {
        if (empty($data['data']['id'])) {
            $data['data']['id'] = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );
        }
        return $data;
    }

    /**
     * Otomatis melakukan hash password BCRYPT sebelum data disimpan
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }

    /**
     * Mendapatkan profil pengguna lengkap dengan nama role-nya
     */
    public function getUserWithRole(string $id)
    {
        return $this->select('sys_users.*, sys_roles.name as role_name, mst_personil.nama as nama_personil')
                    ->join('sys_roles', 'sys_roles.id = sys_users.role_id', 'left')
                    ->join('mst_personil', 'mst_personil.id = sys_users.personil_id', 'left')
                    ->where('sys_users.id', $id)
                    ->where('sys_users.deleted_at', null)
                    ->first();
    }

    /**
     * Mendapatkan daftar seluruh pengguna dengan nama role dan personil
     */
    public function getUsersWithDetails($roleId = null, $status = null, $keyword = null)
    {
        $builder = $this->select('sys_users.*, sys_roles.name as role_name, sys_roles.description as role_description, mst_personil.nama as nama_personil, mst_personil.no_hp as no_hp_personil')
                        ->join('sys_roles', 'sys_roles.id = sys_users.role_id', 'left')
                        ->join('mst_personil', 'mst_personil.id = sys_users.personil_id', 'left')
                        ->where('sys_users.deleted_at', null);

        if (!empty($roleId)) {
            $builder->where('sys_users.role_id', (int) $roleId);
        }

        if (!empty($status)) {
            $builder->where('sys_users.status', $status);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                    ->like('sys_users.username', $keyword)
                    ->orLike('sys_users.email', $keyword)
                    ->orLike('mst_personil.nama', $keyword)
                    ->groupEnd();
        }

        return $builder->orderBy('sys_users.created_at', 'DESC')->findAll();
    }
}
