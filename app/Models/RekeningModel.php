<?php

namespace App\Models;

use CodeIgniter\Model;

class RekeningModel extends Model
{
    protected $table            = 'mst_rekening';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['id', 'nama_bank', 'nomor_rekening', 'atas_nama', 'jenis', 'logo', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Mengambil daftar metode donasi yang aktif
     */
    public function getActiveChannels(): array
    {
        return $this->where('status', 'active')
                    ->orderBy('jenis', 'ASC') // qris, lalu transfer
                    ->orderBy('nama_bank', 'ASC')
                    ->findAll();
    }
}
