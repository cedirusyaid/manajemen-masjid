<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 'mst_agenda';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'kegiatan_id', 'judul', 'deskripsi', 'tanggal', 'waktu', 
        'lokasi', 'narasumber_id', 'narasumber', 'banner'
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
        'kegiatan_id'   => 'permit_empty|max_length[36]',
        'judul'         => 'required|min_length[5]|max_length[255]',
        'deskripsi'     => 'required',
        'tanggal'       => 'required|valid_date[Y-m-d]',
        'waktu'         => 'required',
        'lokasi'        => 'permit_empty|max_length[255]',
        'narasumber_id' => 'permit_empty',
        'narasumber'    => 'permit_empty|max_length[150]',
        'banner'        => 'permit_empty'
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
     * Mengambil daftar agenda lengkap dengan nama narasumber dan nama kegiatan
     */
    public function getAgendaLengkap()
    {
        return $this->select('mst_agenda.*, mst_personil.nama as nama_ustadz, mst_personil.foto as foto_ustadz, mst_kegiatan.nama_kegiatan')
                    ->join('mst_personil', 'mst_personil.id = mst_agenda.narasumber_id', 'left')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = mst_agenda.kegiatan_id', 'left')
                    ->where('mst_agenda.deleted_at', null)
                    ->orderBy('mst_agenda.tanggal', 'DESC')
                    ->orderBy('mst_agenda.waktu', 'ASC')
                    ->findAll();
    }

    /**
     * Dapatkan agenda mendatang/terdekat dengan detail kegiatan
     */
    public function getAgendaTerdekat(int $limit = 3)
    {
        return $this->select('mst_agenda.*, mst_personil.nama as nama_ustadz, mst_personil.foto as foto_ustadz, mst_kegiatan.nama_kegiatan')
                    ->join('mst_personil', 'mst_personil.id = mst_agenda.narasumber_id', 'left')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = mst_agenda.kegiatan_id', 'left')
                    ->where('mst_agenda.tanggal >=', date('Y-m-d'))
                    ->where('mst_agenda.deleted_at', null)
                    ->orderBy('mst_agenda.tanggal', 'ASC')
                    ->orderBy('mst_agenda.waktu', 'ASC')
                    ->findAll($limit);
    }
}
