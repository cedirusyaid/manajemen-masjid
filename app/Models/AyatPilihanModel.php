<?php

namespace App\Models;

use CodeIgniter\Model;

class AyatPilihanModel extends Model
{
    protected $table            = 'mst_ayat_pilihan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'surah', 'nomor_ayat', 'teks_arab', 'terjemahan', 'tema', 'is_active', 'urutan'
    ];

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
        'surah'      => 'required|max_length[100]',
        'nomor_ayat' => 'required|max_length[50]',
        'teks_arab'  => 'required',
        'terjemahan' => 'required',
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
     * Mengambil daftar ayat aktif untuk display
     */
    public function getAyatAktif()
    {
        return $this->where('is_active', 1)
                    ->where('deleted_at', null)
                    ->orderBy('urutan', 'ASC')
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}
