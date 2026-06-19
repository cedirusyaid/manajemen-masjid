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
    protected $allowedFields    = ['id', 'jabatan_periode_id', 'personil_id'];

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
        'jabatan_periode_id' => 'required',
        'personil_id'        => 'required'
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
                        trn_jabatan_periode.nama_jabatan, trn_jabatan_periode.urutan, trn_jabatan_periode.parent_id,
                        mst_periode_pengurus.nama_periode, mst_periode_pengurus.id as periode_id,
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email, mst_personil.foto,
                        parent_jabatan.nama_jabatan as jabatan_atasan
                    ')
                    ->join('trn_jabatan_periode', 'trn_jabatan_periode.id = trn_pengurus.jabatan_periode_id')
                    ->join('mst_periode_pengurus', 'mst_periode_pengurus.id = trn_jabatan_periode.periode_id')
                    ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                    ->join('trn_jabatan_periode as parent_jabatan', 'parent_jabatan.id = trn_jabatan_periode.parent_id', 'left')
                    ->where('trn_pengurus.deleted_at', null)
                    ->orderBy('mst_periode_pengurus.tahun_mulai', 'DESC')
                    ->orderBy('trn_jabatan_periode.urutan', 'ASC')
                    ->findAll();
    }

    public function getPengurusByPeriode(string $periodeId)
    {
        return $this->select('
                        trn_pengurus.*, 
                        trn_jabatan_periode.nama_jabatan, trn_jabatan_periode.urutan, trn_jabatan_periode.parent_id,
                        mst_periode_pengurus.nama_periode, mst_periode_pengurus.id as periode_id,
                        mst_personil.nama, mst_personil.no_hp, mst_personil.email, mst_personil.foto,
                        parent_jabatan.nama_jabatan as jabatan_atasan
                    ')
                    ->join('trn_jabatan_periode', 'trn_jabatan_periode.id = trn_pengurus.jabatan_periode_id')
                    ->join('mst_periode_pengurus', 'mst_periode_pengurus.id = trn_jabatan_periode.periode_id')
                    ->join('mst_personil', 'mst_personil.id = trn_pengurus.personil_id')
                    ->join('trn_jabatan_periode as parent_jabatan', 'parent_jabatan.id = trn_jabatan_periode.parent_id', 'left')
                    ->where('trn_jabatan_periode.periode_id', $periodeId)
                    ->where('trn_pengurus.deleted_at', null)
                    ->orderBy('trn_jabatan_periode.urutan', 'ASC')
                    ->findAll();
    }
}
