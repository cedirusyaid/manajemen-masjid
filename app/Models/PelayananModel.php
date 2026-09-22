<?php

namespace App\Models;

use CodeIgniter\Model;

class PelayananModel extends Model
{
    protected $table            = 'trn_pelayanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'layanan_id', 'user_id', 'tanggal', 'nama_pemohon', 'nik_pemohon',
        'no_hp_pemohon', 'alamat_pemohon', 'rincian_kebutuhan', 'tindakan_petugas',
        'petugas_personil_id', 'biaya_infaq', 'status_layanan', 'lampiran_dokumen'
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
        'layanan_id'        => 'required|max_length[36]',
        'user_id'           => 'required|max_length[36]',
        'tanggal'           => 'required|valid_date[Y-m-d]',
        'nama_pemohon'      => 'required|min_length[3]|max_length[150]',
        'rincian_kebutuhan' => 'required',
        'status_layanan'    => 'required|in_list[diajukan,diproses,selesai,ditolak]'
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

    /**
     * Ambil daftar transaksi pelayanan lengkap dengan relasi layanan, inputter user, dan petugas
     */
    public function getPelayananLengkap($limit = null, $layananId = null)
    {
        $builder = $this->select('
                            trn_pelayanan.*, 
                            mst_layanan.nama_layanan, 
                            mst_layanan.warna_tema,
                            mst_layanan.icon as layanan_icon,
                            sys_users.username as input_by_user,
                            mst_personil.nama as nama_petugas
                        ')
                        ->join('mst_layanan', 'mst_layanan.id = trn_pelayanan.layanan_id')
                        ->join('sys_users', 'sys_users.id = trn_pelayanan.user_id')
                        ->join('mst_personil', 'mst_personil.id = trn_pelayanan.petugas_personil_id', 'left')
                        ->where('trn_pelayanan.deleted_at', null);

        if (!empty($layananId)) {
            $builder->where('trn_pelayanan.layanan_id', $layananId);
        }

        $builder->orderBy('trn_pelayanan.tanggal', 'DESC')
                ->orderBy('trn_pelayanan.created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit);
        }

        return $builder->findAll();
    }
}
