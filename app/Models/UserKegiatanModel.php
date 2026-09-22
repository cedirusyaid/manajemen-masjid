<?php

namespace App\Models;

use CodeIgniter\Model;

class UserKegiatanModel extends Model
{
    protected $table            = 'trn_user_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'user_id', 'kegiatan_id', 'peran', 'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Dapatkan daftar kepanitiaan yang ditugaskan kepada seorang user
     */
    public function getKegiatanByUser(string $userId): array
    {
        return $this->select('trn_user_kegiatan.*, mst_kegiatan.nama_kegiatan, mst_kegiatan.status as status_kegiatan, mst_kegiatan.tanggal_mulai, mst_kegiatan.tanggal_selesai')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_user_kegiatan.kegiatan_id')
                    ->where('trn_user_kegiatan.user_id', $userId)
                    ->where('trn_user_kegiatan.status', 'active')
                    ->where('trn_user_kegiatan.deleted_at', null)
                    ->where('mst_kegiatan.deleted_at', null)
                    ->orderBy('mst_kegiatan.created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Dapatkan ID saja dari kepanitiaan yang ditugaskan kepada user
     */
    public function getKegiatanIdsByUser(string $userId): array
    {
        $rows = $this->select('kegiatan_id')
                     ->where('user_id', $userId)
                     ->where('status', 'active')
                     ->where('deleted_at', null)
                     ->findAll();

        return array_column($rows, 'kegiatan_id');
    }

    /**
     * Dapatkan daftar akun user pengelola untuk sebuah kepanitiaan
     */
    public function getUsersByKegiatan(string $kegiatanId): array
    {
        return $this->select('trn_user_kegiatan.*, sys_users.username, sys_users.email, sys_users.role_id, mst_personil.nama as nama_personil')
                    ->join('sys_users', 'sys_users.id = trn_user_kegiatan.user_id')
                    ->join('mst_personil', 'mst_personil.id = sys_users.personil_id', 'left')
                    ->where('trn_user_kegiatan.kegiatan_id', $kegiatanId)
                    ->where('trn_user_kegiatan.status', 'active')
                    ->where('trn_user_kegiatan.deleted_at', null)
                    ->where('sys_users.deleted_at', null)
                    ->findAll();
    }

    /**
     * Cek apakah user memiliki akses ke ID kegiatan tertentu
     */
    public function hasAccess(string $userId, string $kegiatanId): bool
    {
        $exists = $this->where('user_id', $userId)
                       ->where('kegiatan_id', $kegiatanId)
                       ->where('status', 'active')
                       ->where('deleted_at', null)
                       ->first();

        return !empty($exists);
    }

    /**
     * Sinkronisasi penugasan banyak kepanitiaan ke seorang user (Many-to-Many Sync)
     */
    public function syncUserKegiatan(string $userId, array $kegiatanIds, string $peran = 'bendahara'): void
    {
        // 1. Soft delete assignment lama
        $this->where('user_id', $userId)->delete();

        // 2. Insert assignment baru
        foreach ($kegiatanIds as $kegId) {
            $kegId = trim($kegId);
            if (empty($kegId)) continue;

            $newId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            // Cek jika ada record yang sebelumnya ter-soft-delete untuk di-restore
            $existing = $this->onlyDeleted()->where('user_id', $userId)->where('kegiatan_id', $kegId)->first();
            if ($existing) {
                $this->update($existing['id'], [
                    'deleted_at' => null,
                    'peran'      => $peran,
                    'status'     => 'active'
                ]);
            } else {
                $this->insert([
                    'id'          => $newId,
                    'user_id'     => $userId,
                    'kegiatan_id' => $kegId,
                    'peran'       => $peran,
                    'status'      => 'active'
                ]);
            }
        }
    }
}
