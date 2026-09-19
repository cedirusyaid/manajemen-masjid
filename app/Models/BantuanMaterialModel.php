<?php

namespace App\Models;

use CodeIgniter\Model;

class BantuanMaterialModel extends Model
{
    protected $table            = 'trn_bantuan_material';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'kegiatan_id', 'tanggal', 'nama_donatur', 'uraian_material',
        'kategori_material', 'volume', 'satuan', 'harga_satuan', 'total_nilai',
        'penerima_personil_id', 'keterangan', 'bukti_foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks
    protected $beforeInsert = ['generateUuid', 'calculateTotalNilai'];
    protected $beforeUpdate = ['calculateTotalNilai'];

    // Validation Rules
    protected $validationRules = [
        'kegiatan_id'       => 'required|max_length[36]',
        'tanggal'           => 'required|valid_date[Y-m-d]',
        'uraian_material'   => 'required|max_length[255]',
        'kategori_material' => 'required|in_list[material_konstruksi,inventaris_elektronik,perlengkapan_ibadah,lainnya]',
        'volume'            => 'required|numeric|greater_than[0]',
        'satuan'            => 'required|max_length[50]',
        'harga_satuan'      => 'permit_empty|numeric|greater_than_equal_to[0]'
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Hitung total nilai otomatis jika tidak diisi manual
     */
    protected function calculateTotalNilai(array $data)
    {
        if (isset($data['data']['volume']) && isset($data['data']['harga_satuan'])) {
            $data['data']['total_nilai'] = (float)$data['data']['volume'] * (float)$data['data']['harga_satuan'];
        }
        return $data;
    }

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
     * Ambil data bantuan material berdasarkan ID kegiatan
     */
    public function getMaterialByKegiatan($kegiatanId)
    {
        return $this->select('trn_bantuan_material.*, mst_personil.nama as nama_penerima')
                    ->join('mst_personil', 'mst_personil.id = trn_bantuan_material.penerima_personil_id', 'left')
                    ->where('trn_bantuan_material.kegiatan_id', $kegiatanId)
                    ->where('trn_bantuan_material.deleted_at', null)
                    ->orderBy('trn_bantuan_material.tanggal', 'DESC')
                    ->orderBy('trn_bantuan_material.created_at', 'DESC')
                    ->findAll();
    }
}
