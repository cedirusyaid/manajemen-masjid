<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaKelompokModel extends Model
{
    protected $table            = 'trn_anggota_kelompok';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'kelompok_id', 'personil_id', 'peran'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks
    protected $beforeInsert = ['generateUuid'];

    // Validation Rules
    protected $validationRules = [
        'kelompok_id' => 'required',
        'personil_id' => 'required',
        'peran'       => 'required|min_length[2]|max_length[100]'
    ];

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
     * Dapatkan daftar anggota untuk kelompok tertentu
     */
    public function getAnggotaByKelompok($kelompokId)
    {
        return $this->select('trn_anggota_kelompok.*, mst_personil.nama, mst_personil.no_hp, mst_personil.email')
                    ->join('mst_personil', 'mst_personil.id = trn_anggota_kelompok.personil_id')
                    ->where('trn_anggota_kelompok.kelompok_id', $kelompokId)
                    ->where('trn_anggota_kelompok.deleted_at', null)
                    ->where('mst_personil.deleted_at', null)
                    ->orderBy('mst_personil.nama', 'ASC')
                    ->findAll();
    }
}
