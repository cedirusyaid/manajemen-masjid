<?php

namespace App\Models;

use CodeIgniter\Model;

class KelompokKegiatanModel extends Model
{
    protected $table            = 'mst_kelompok_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'kegiatan_id', 'nama_kelompok', 'keterangan'];

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
        'kegiatan_id'   => 'required',
        'nama_kelompok' => 'required|min_length[3]|max_length[255]'
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
     * Ambil daftar kelompok berdasarkan kegiatan_id
     */
    public function getKelompokByKegiatan($kegiatanId)
    {
        return $this->where('kegiatan_id', $kegiatanId)
                    ->where('deleted_at', null)
                    ->orderBy('nama_kelompok', 'ASC')
                    ->findAll();
    }
}
