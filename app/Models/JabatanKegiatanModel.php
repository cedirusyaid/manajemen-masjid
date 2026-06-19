<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanKegiatanModel extends Model
{
    protected $table            = 'trn_jabatan_kegiatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'kegiatan_id', 'nama_jabatan', 'parent_id', 'tugas', 'urutan'];

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
        'kegiatan_id'  => 'required',
        'nama_jabatan' => 'required|min_length[2]|max_length[100]',
        'parent_id'    => 'permit_empty',
        'tugas'        => 'permit_empty',
        'urutan'       => 'permit_empty|integer'
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
     * Ambil daftar jabatan lengkap dengan nama kegiatan dan nama atasan
     */
    public function getJabatanByKegiatan($kegiatanId)
    {
        return $this->select('
                        trn_jabatan_kegiatan.*, 
                        mst_kegiatan.nama_kegiatan,
                        parent_j.nama_jabatan as nama_atasan
                    ')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_jabatan_kegiatan.kegiatan_id')
                    ->join('trn_jabatan_kegiatan as parent_j', 'parent_j.id = trn_jabatan_kegiatan.parent_id', 'left')
                    ->where('trn_jabatan_kegiatan.kegiatan_id', $kegiatanId)
                    ->where('trn_jabatan_kegiatan.deleted_at', null)
                    ->orderBy('trn_jabatan_kegiatan.urutan', 'ASC')
                    ->findAll();
    }
}
