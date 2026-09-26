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

    /**
     * Ambil seluruh petugas/personil masjid tanpa membedakan klasifikasi (pengurus, panitia, imam/khatib, personil umum).
     * Otomatis mendaftarkan personil ke mst_imam_khatib jika belum terdaftar agar relasi database tetap valid.
     */
    public function getAllPetugasUnified()
    {
        $db = \Config\Database::connect();

        // Ambil semua personil aktif dari mst_personil
        $allPersonil = $db->table('mst_personil')
            ->where('deleted_at', null)
            ->orderBy('nama', 'ASC')
            ->get()
            ->getResultArray();

        $petugasList = [];
        foreach ($allPersonil as $p) {
            // Cek apakah personil sudah ada di mst_imam_khatib
            $existing = $this->where('personil_id', $p['id'])
                             ->where('deleted_at', null)
                             ->first();

            if (!$existing) {
                // Auto-create entri imam_khatib untuk personil ini
                $newId = sprintf(
                    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                    mt_rand(0, 0xffff),
                    mt_rand(0, 0x0fff) | 0x4000,
                    mt_rand(0, 0x3fff) | 0x8000,
                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
                );
                $newRecord = [
                    'id'          => $newId,
                    'personil_id' => $p['id'],
                    'jabatan'     => 'imam_khatib',
                    'bio'         => 'Personil Masjid'
                ];
                $this->insert($newRecord);
                $petugasId = $newId;
                $jabatan   = 'imam_khatib';
            } else {
                $petugasId = $existing['id'];
                $jabatan   = $existing['jabatan'];
            }

            $petugasList[] = [
                'id'          => $petugasId,
                'personil_id' => $p['id'],
                'nama'        => $p['nama'],
                'no_hp'       => $p['no_hp'] ?? null,
                'foto'        => $p['foto'] ?? null,
                'jabatan'     => $jabatan
            ];
        }

        return $petugasList;
    }
}
