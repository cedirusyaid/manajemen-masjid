<?php

namespace App\Models;

use CodeIgniter\Model;

class PengurusModel extends Model
{
    protected $table            = 'trn_pengurus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'periode_id', 'personil_id', 'parent_id', 'jabatan', 'urutan'];

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
        'periode_id'  => 'required',
        'personil_id' => 'required',
        'parent_id'   => 'permit_empty',
        'jabatan'     => 'required|min_length[2]|max_length[100]',
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

    public function getPengurusWithPeriode()
    {
        return $this->select('
                        trn_pengurus.*, 
                        mst_periode_pengurus.nama_periode, 
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email, mst_personil.foto,
                        parent_p.nama as nama_atasan, parent_pengurus.jabatan as jabatan_atasan
                    ')
                    ->join('mst_periode_pengurus', 'mst_periode_pengurus.id = trn_pengurus.periode_id')
                    ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                    ->join('trn_pengurus as parent_pengurus', 'parent_pengurus.id = trn_pengurus.parent_id', 'left')
                    ->join('mst_personil as parent_p', 'parent_p.id = parent_pengurus.personil_id', 'left')
                    ->where('trn_pengurus.deleted_at', null)
                    ->orderBy('mst_periode_pengurus.tahun_mulai', 'DESC')
                    ->orderBy('trn_pengurus.urutan', 'ASC')
                    ->findAll();
    }

    public function getPengurusByPeriode(string $periodeId)
    {
        return $this->select('
                        trn_pengurus.*, 
                        mst_periode_pengurus.nama_periode, 
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email, mst_personil.foto,
                        parent_p.nama as nama_atasan, parent_pengurus.jabatan as jabatan_atasan
                    ')
                    ->join('mst_periode_pengurus', 'mst_periode_pengurus.id = trn_pengurus.periode_id')
                    ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                    ->join('trn_pengurus as parent_pengurus', 'parent_pengurus.id = trn_pengurus.parent_id', 'left')
                    ->join('mst_personil as parent_p', 'parent_p.id = parent_pengurus.personil_id', 'left')
                    ->where('trn_pengurus.periode_id', $periodeId)
                    ->where('trn_pengurus.deleted_at', null)
                    ->orderBy('trn_pengurus.urutan', 'ASC')
                    ->findAll();
    }
}
