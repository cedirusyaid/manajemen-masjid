<?php

namespace App\Models;

use CodeIgniter\Model;

class ImamKhatibModel extends Model
{
    protected $table            = 'mst_imam_khatib';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'personil_id', 'jabatan', 'bio'];

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
        'personil_id' => 'required',
        'jabatan'     => 'required|in_list[imam,khatib,muadzin,imam_khatib]',
        'bio'         => 'permit_empty'
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
     * Ambil data petugas jumat lengkap dengan data personilnya, opsional difilter jabatan
     */
    public function getPetugasWithPersonil($jabatan = null)
    {
        $builder = $this->select('mst_imam_khatib.*, mst_personil.nama, mst_personil.no_hp, mst_personil.foto, mst_personil.email')
                    ->join('mst_personil', 'mst_personil.id = mst_imam_khatib.personil_id')
                    ->where('mst_imam_khatib.deleted_at', null);

        if ($jabatan !== null) {
            if (is_array($jabatan)) {
                $builder->whereIn('mst_imam_khatib.jabatan', $jabatan);
            } else {
                $builder->where('mst_imam_khatib.jabatan', $jabatan);
            }
        }

        return $builder->findAll();
    }
}
