<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'mst_berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'judul', 'slug', 'konten', 
        'banner', 'status', 'created_by'
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
        'judul'  => 'required|min_length[5]|max_length[255]',
        'konten' => 'required',
        'status' => 'required|in_list[draft,published]',
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
     * Otomatis generate URL slug ramah SEO dari judul berita
     */
    protected function generateSlug(array $data)
    {
        if (isset($data['data']['judul'])) {
            $slug = url_title($data['data']['judul'], '-', true);
            
            // Cek keunikan slug di DB
            $db = \Config\Database::connect();
            $builder = $db->table($this->table)->where('slug', $slug);
            if (isset($data['id'])) {
                // Kecualikan ID saat update
                $builder->where('id !=', $data['id'][0]);
            }
            
            $count = $builder->countAllResults();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
            
            $data['data']['slug'] = $slug;
        }
        return $data;
    }

    /**
     * Mengambil daftar berita lengkap dengan nama pembuatnya (user)
     */
    public function getBeritaLengkap()
    {
        return $this->select('mst_berita.*, sys_users.username as author_name')
                    ->join('sys_users', 'sys_users.id = mst_berita.created_by')
                    ->where('mst_berita.deleted_at', null)
                    ->orderBy('mst_berita.created_at', 'DESC')
                    ->findAll();
    }
}
