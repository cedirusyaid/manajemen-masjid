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
    protected $allowedFields    = ['id', 'kegiatan_id', 'personil_id', 'parent_id', 'jabatan', 'tugas', 'urutan'];

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
        'kegiatan_id' => 'required',
        'personil_id' => 'required',
        'parent_id'   => 'permit_empty',
        'jabatan'     => 'required|min_length[2]|max_length[100]',
        'tugas'       => 'permit_empty',
        'urutan'      => 'permit_empty|integer'
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
                        mst_kegiatan.nama_kegiatan, 
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email,
                        parent_p.nama as nama_atasan, parent_panitia.jabatan as jabatan_atasan
                    ')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_panitia.kegiatan_id')
                    ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                    ->join('trn_panitia as parent_panitia', 'parent_panitia.id = trn_panitia.parent_id', 'left')
                    ->join('mst_personil as parent_p', 'parent_p.id = parent_panitia.personil_id', 'left')
                    ->where('trn_panitia.deleted_at', null)
                    ->orderBy('mst_kegiatan.tanggal_mulai', 'DESC')
                    ->orderBy('trn_panitia.urutan', 'ASC')
                    ->findAll();
    }

    public function getPanitiaByKegiatan($kegiatanId)
    {
        return $this->select('
                        trn_panitia.*, 
                        mst_kegiatan.nama_kegiatan, 
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email,
                        parent_p.nama as nama_atasan, parent_panitia.jabatan as jabatan_atasan
                    ')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = trn_panitia.kegiatan_id')
                    ->join('mst_personil', 'mst_personil.id = trn_panitia.personil_id')
                    ->join('trn_panitia as parent_panitia', 'parent_panitia.id = trn_panitia.parent_id', 'left')
                    ->join('mst_personil as parent_p', 'parent_p.id = parent_panitia.personil_id', 'left')
                    ->where('trn_panitia.kegiatan_id', $kegiatanId)
                    ->where('trn_panitia.deleted_at', null)
                    ->orderBy('trn_panitia.urutan', 'ASC')
                    ->findAll();
    }
}
