<?php

namespace App\Models;

use CodeIgniter\Model;

class PanitiaModel extends Model
{
    protected $table            = 'trn_panitia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'jabatan_kegiatan_id', 'personil_id'];

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
        'jabatan_kegiatan_id' => 'required',
        'personil_id'         => 'required'
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

    public function getPanitiaWithKegiatan()
    {
        return $this->select('
                        trn_panitia.*, 
                        trn_jabatan_kegiatan.nama_jabatan, trn_jabatan_kegiatan.tugas, trn_jabatan_kegiatan.urutan, trn_jabatan_kegiatan.parent_id,
                        mst_kegiatan.nama_kegiatan, mst_kegiatan.id as kegiatan_id,
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email,
                        parent_jabatan.nama_jabatan as jabatan_atasan
                    ')
                    ->join('trn_jabatan_kegiatan', 'trn_jabatan_kegiatan.id = trn_panitia.jabatan_kegiatan_id')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_jabatan_kegiatan.kegiatan_id')
                    ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                    ->join('trn_jabatan_kegiatan as parent_jabatan', 'parent_jabatan.id = trn_jabatan_kegiatan.parent_id', 'left')
                    ->where('trn_panitia.deleted_at', null)
                    ->orderBy('mst_kegiatan.tanggal_mulai', 'DESC')
                    ->orderBy('trn_jabatan_kegiatan.urutan', 'ASC')
                    ->findAll();
    }

    public function getPanitiaByKegiatan($kegiatanId)
    {
        return $this->select('
                        trn_panitia.*, 
                        trn_jabatan_kegiatan.nama_jabatan, trn_jabatan_kegiatan.tugas, trn_jabatan_kegiatan.urutan, trn_jabatan_kegiatan.parent_id,
                        mst_kegiatan.nama_kegiatan, mst_kegiatan.id as kegiatan_id,
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email,
                        parent_jabatan.nama_jabatan as jabatan_atasan
                    ')
                    ->join('trn_jabatan_kegiatan', 'trn_jabatan_kegiatan.id = trn_panitia.jabatan_kegiatan_id')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_jabatan_kegiatan.kegiatan_id')
                    ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                    ->join('trn_jabatan_kegiatan as parent_jabatan', 'parent_jabatan.id = trn_jabatan_kegiatan.parent_id', 'left')
                    ->where('trn_jabatan_kegiatan.kegiatan_id', $kegiatanId)
                    ->where('trn_panitia.deleted_at', null)
                    ->orderBy('trn_jabatan_kegiatan.urutan', 'ASC')
                    ->findAll();
    }
}
