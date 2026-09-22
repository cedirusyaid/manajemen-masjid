<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananModel extends Model
{
    protected $table            = 'mst_layanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'nama_layanan', 'slug', 'deskripsi', 'icon', 'warna_tema',
        'kontak_wa', 'pesan_wa_default', 'pj_personil_id', 'urutan', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks
    protected $beforeInsert = ['generateUuid', 'generateSlug'];
    protected $beforeUpdate = ['generateSlug'];

    // Validation Rules
    protected $validationRules = [
        'nama_layanan' => 'required|min_length[3]|max_length[150]',
        'deskripsi'    => 'permit_empty',
        'icon'         => 'permit_empty|max_length[100]',
        'warna_tema'   => 'permit_empty|in_list[success,primary,warning,danger,info,secondary]',
        'kontak_wa'    => 'permit_empty|max_length[50]',
        'urutan'       => 'permit_empty|integer',
        'status'       => 'required|in_list[aktif,nonaktif]'
    ];

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

    protected function generateSlug(array $data)
    {
        if (!empty($data['data']['nama_layanan'])) {
            $slug = url_title($data['data']['nama_layanan'], '-', true);
            $data['data']['slug'] = $slug ?: 'layanan-' . time();
        }
        return $data;
    }

    /**
     * Ambil daftar layanan aktif untuk halaman publik
     */
    public function getLayananAktif()
    {
        return $this->select('mst_layanan.*, mst_personil.nama as nama_pj')
                    ->join('mst_personil', 'mst_personil.id = mst_layanan.pj_personil_id', 'left')
                    ->where('mst_layanan.status', 'aktif')
                    ->where('mst_layanan.deleted_at', null)
                    ->orderBy('mst_layanan.urutan', 'ASC')
                    ->orderBy('mst_layanan.created_at', 'ASC')
                    ->findAll();
    }
}
