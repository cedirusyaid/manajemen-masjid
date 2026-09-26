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
        'id', 'kegiatan_id', 'tipe_jadwal', 'hari_rutin', 'pekan_rutin',
        'judul', 'deskripsi', 'tanggal', 'waktu', 
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
        'tipe_jadwal'   => 'permit_empty|in_list[sekali,rutin]',
        'hari_rutin'    => 'permit_empty|max_length[20]',
        'pekan_rutin'   => 'permit_empty|max_length[50]',
        'judul'         => 'required|min_length[5]|max_length[255]',
        'deskripsi'     => 'required',
        'tanggal'       => 'permit_empty',
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
     * Hitung tanggal pelaksanaan terdekat untuk jadwal rutin
     */
    public static function getNextRecurringDate(string $hari, ?string $pekan = null, ?string $fromDate = null): string
    {
        $hariMap = [
            'ahad'   => 0,
            'minggu' => 0,
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6
        ];

        $targetDay = $hariMap[strtolower(trim($hari))] ?? 0;
        $targetWeeks = ($pekan === 'setiap_pekan' || empty($pekan)) 
            ? [1, 2, 3, 4, 5] 
            : array_map('intval', explode(',', $pekan));

        $from = $fromDate ? new \DateTime($fromDate) : new \DateTime();
        $from->setTime(0, 0, 0);

        $currentYear = (int)$from->format('Y');
        $currentMonth = (int)$from->format('n');

        // Cek bulan ini dan hingga 3 bulan ke depan
        for ($mOffset = 0; $mOffset <= 3; $mOffset++) {
            $year = $currentYear + (int)floor(($currentMonth - 1 + $mOffset) / 12);
            $month = (($currentMonth - 1 + $mOffset) % 12) + 1;

            $firstDayOfMonth = new \DateTime(sprintf('%04d-%02d-01', $year, $month));
            $daysInMonth = (int)$firstDayOfMonth->format('t');

            $weekCount = 0;
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = new \DateTime(sprintf('%04d-%02d-%02d', $year, $month, $day));
                $dayOfWeek = (int)$date->format('w'); // 0 (Sun) to 6 (Sat)

                if ($dayOfWeek === $targetDay) {
                    $weekCount++;
                    if (in_array($weekCount, $targetWeeks)) {
                        if ($date >= $from) {
                            return $date->format('Y-m-d');
                        }
                    }
                }
            }
        }

        return $from->format('Y-m-d');
    }

    /**
     * Format label representasi jadwal rutin
     */
    public static function getRecurringLabel(?string $hari, ?string $pekan): string
    {
        if (empty($hari)) return '';
        $namaHari = ucfirst($hari);
        if (strtolower($hari) === 'ahad' || strtolower($hari) === 'minggu') {
            $namaHari = 'Ahad';
        }

        if ($pekan === 'setiap_pekan' || empty($pekan)) {
            return "Setiap $namaHari";
        }

        if ($pekan === '1,3') {
            return "Setiap $namaHari Pekan Ke-1 & Ke-3";
        }

        if ($pekan === '2,4') {
            return "Setiap $namaHari Pekan Ke-2 & Ke-4";
        }

        $pekanArr = explode(',', $pekan);
        $pekanLabels = array_map(function($p) { return "Ke-$p"; }, $pekanArr);
        return "Setiap $namaHari Pekan " . implode(' & ', $pekanLabels);
    }

    /**
     * Mengambil daftar agenda lengkap dengan nama narasumber, kegiatan, dan perhitungan tanggal rutin
     */
    public function getAgendaLengkap()
    {
        $raw = $this->select('mst_agenda.*, mst_personil.nama as nama_ustadz, mst_personil.foto as foto_ustadz, mst_kegiatan.nama_kegiatan')
                    ->join('mst_personil', 'mst_personil.id = mst_agenda.narasumber_id', 'left')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = mst_agenda.kegiatan_id', 'left')
                    ->where('mst_agenda.deleted_at', null)
                    ->orderBy('mst_agenda.created_at', 'DESC')
                    ->findAll();

        foreach ($raw as &$item) {
            $item['is_rutin'] = ($item['tipe_jadwal'] ?? 'sekali') === 'rutin';
            if ($item['is_rutin'] && !empty($item['hari_rutin'])) {
                $item['label_rutin'] = self::getRecurringLabel($item['hari_rutin'], $item['pekan_rutin']);
                $item['tanggal_terdekat'] = self::getNextRecurringDate($item['hari_rutin'], $item['pekan_rutin']);
            } else {
                $item['label_rutin'] = null;
                $item['tanggal_terdekat'] = $item['tanggal'];
            }
        }
        unset($item);

        return $raw;
    }

    /**
     * Dapatkan agenda mendatang/terdekat dengan detail kegiatan & kalkulasi tanggal rutin
     */
    public function getAgendaTerdekat(int $limit = 5)
    {
        $raw = $this->select('mst_agenda.*, mst_personil.nama as nama_ustadz, mst_personil.foto as foto_ustadz, mst_kegiatan.nama_kegiatan')
                    ->join('mst_personil', 'mst_personil.id = mst_agenda.narasumber_id', 'left')
                    ->join('mst_kegiatan', 'mst_kegiatan.id = mst_agenda.kegiatan_id', 'left')
                    ->where('mst_agenda.deleted_at', null)
                    ->findAll();

        $today = date('Y-m-d');
        $processed = [];

        foreach ($raw as $item) {
            $isRutin = ($item['tipe_jadwal'] ?? 'sekali') === 'rutin';
            $item['is_rutin'] = $isRutin;

            if ($isRutin && !empty($item['hari_rutin'])) {
                $nextDate = self::getNextRecurringDate($item['hari_rutin'], $item['pekan_rutin'], $today);
                $item['tanggal_terdekat'] = $nextDate;
                $item['tanggal'] = $nextDate; // Sync tanggal efektif untuk display
                $item['label_rutin'] = self::getRecurringLabel($item['hari_rutin'], $item['pekan_rutin']);
                $processed[] = $item;
            } else {
                if (!empty($item['tanggal']) && $item['tanggal'] >= $today) {
                    $item['tanggal_terdekat'] = $item['tanggal'];
                    $item['label_rutin'] = null;
                    $processed[] = $item;
                }
            }
        }

        // Urutkan berdasarkan tanggal terdekat dan waktu
        usort($processed, function($a, $b) {
            $dateDiff = strcmp($a['tanggal_terdekat'], $b['tanggal_terdekat']);
            if ($dateDiff !== 0) return $dateDiff;
            return strcmp($a['waktu'] ?? '', $b['waktu'] ?? '');
        });

        return array_slice($processed, 0, $limit);
    }
}
