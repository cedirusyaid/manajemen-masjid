<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalJumatModel extends Model
{
    protected $table            = 'trn_jadwal_jumat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 'tanggal', 'khatib_id', 'imam_id', 
        'muadzin_id', 'judul_khotbah', 'keterangan'
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
        'tanggal'    => 'required|valid_date[Y-m-d]',
        'khatib_id'  => 'required|alpha_dash|min_length[36]|max_length[36]',
        'imam_id'    => 'required|alpha_dash|min_length[36]|max_length[36]',
        'muadzin_id' => 'required|alpha_dash|min_length[36]|max_length[36]',
        'judul_khotbah' => 'permit_empty|max_length[255]'
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
     * Dapatkan jadwal Jumat lengkap beserta data detail petugas (Khatib, Imam, Muadzin)
     */
    public function getJadwalLengkap(string $tanggal = null)
    {
        $builder = $this->select('
            trn_jadwal_jumat.*,
            khatib_p.nama as khatib_nama, khatib_p.foto as khatib_foto,
            imam_p.nama as imam_nama, imam_p.foto as imam_foto,
            muadzin_p.nama as muadzin_nama, muadzin_p.foto as muadzin_foto
        ')
        ->join('mst_imam_khatib as khatib', 'khatib.id = trn_jadwal_jumat.khatib_id')
        ->join('mst_personil as khatib_p', 'khatib_p.id = khatib.personil_id')
        ->join('mst_imam_khatib as imam', 'imam.id = trn_jadwal_jumat.imam_id')
        ->join('mst_personil as imam_p', 'imam_p.id = imam.personil_id')
        ->join('mst_imam_khatib as muadzin', 'muadzin.id = trn_jadwal_jumat.muadzin_id')
        ->join('mst_personil as muadzin_p', 'muadzin_p.id = muadzin.personil_id')
        ->where('trn_jadwal_jumat.deleted_at', null);

        if ($tanggal) {
            $builder->where('trn_jadwal_jumat.tanggal', $tanggal);
        } else {
            $builder->orderBy('trn_jadwal_jumat.tanggal', 'DESC');
        }

        return $builder->findAll();
    }

    /**
     * Dapatkan jadwal Jumat terdekat/mendatang
     */
    public function getJadwalTerdekat()
    {
        return $this->select('
            trn_jadwal_jumat.*,
            khatib_p.nama as khatib_nama, khatib_p.foto as khatib_foto, khatib.bio as khatib_bio,
            imam_p.nama as imam_nama, imam_p.foto as imam_foto,
            muadzin_p.nama as muadzin_nama, muadzin_p.foto as muadzin_foto
        ')
        ->join('mst_imam_khatib as khatib', 'khatib.id = trn_jadwal_jumat.khatib_id')
        ->join('mst_personil as khatib_p', 'khatib_p.id = khatib.personil_id')
        ->join('mst_imam_khatib as imam', 'imam.id = trn_jadwal_jumat.imam_id')
        ->join('mst_personil as imam_p', 'imam_p.id = imam.personil_id')
        ->join('mst_imam_khatib as muadzin', 'muadzin.id = trn_jadwal_jumat.muadzin_id')
        ->join('mst_personil as muadzin_p', 'muadzin_p.id = muadzin.personil_id')
        ->where('trn_jadwal_jumat.tanggal >=', date('Y-m-d'))
        ->where('trn_jadwal_jumat.deleted_at', null)
        ->orderBy('trn_jadwal_jumat.tanggal', 'ASC')
        ->first();
    }
}
