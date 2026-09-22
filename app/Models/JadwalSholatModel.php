<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalSholatModel extends Model
{
    protected $table            = 'mst_jadwal_sholat';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'id', 'bulan', 'tanggal', 'imsak', 'subuh', 'terbit', 'dhuha',
        'dzuhur', 'ashar', 'maghrib', 'isya', 'keterangan'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Dapatkan jadwal sholat per bulan (1 - 12)
     */
    public function getByBulan(int $bulan): array
    {
        return $this->where('bulan', $bulan)
                    ->where('deleted_at', null)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }

    /**
     * Dapatkan jadwal sholat untuk tanggal spesifik
     */
    public function getByTanggal(int $bulan, int $tanggal): ?array
    {
        return $this->where('bulan', $bulan)
                    ->where('tanggal', $tanggal)
                    ->where('deleted_at', null)
                    ->first();
    }

    /**
     * Dapatkan jadwal sholat hari ini
     */
    public function getHariIni(): ?array
    {
        $bulan   = (int) date('n');
        $tanggal = (int) date('j');

        return $this->getByTanggal($bulan, $tanggal);
    }

    /**
     * Dataset Master 5-harian rujukan Masjid Agung
     * Format per entri: [maghrib, isya, subuh, dzuhur, ashar]
     */
    public static function getMasterAnchors(): array
    {
        return [
            1 => [
                1  => ["18:20", "19:31", "04:36", "12:09", "15:32"],
                6  => ["18:21", "19:32", "04:39", "12:11", "15:34"],
                11 => ["18:23", "19:34", "04:42", "12:13", "15:35"],
                16 => ["18:25", "19:36", "04:44", "12:15", "15:36"],
                21 => ["18:27", "19:37", "04:46", "12:17", "15:37"],
                26 => ["18:27", "19:37", "04:50", "12:18", "15:37"]
            ],
            2 => [
                1  => ["18:28", "19:36", "04:51", "12:19", "15:37"],
                6  => ["18:28", "19:36", "04:52", "12:19", "15:36"],
                11 => ["18:28", "19:36", "04:53", "12:20", "15:36"],
                16 => ["18:27", "19:35", "04:54", "12:20", "15:33"],
                21 => ["18:27", "19:32", "04:57", "12:19", "15:30"],
                26 => ["18:26", "19:31", "04:57", "12:19", "15:26"]
            ],
            3 => [
                3  => ["18:23", "19:29", "04:59", "12:18", "15:22"],
                8  => ["18:20", "19:26", "04:58", "12:16", "15:17"],
                13 => ["18:17", "19:23", "04:57", "12:15", "15:17"],
                18 => ["18:16", "19:21", "04:56", "12:14", "15:18"],
                23 => ["18:14", "19:20", "04:55", "12:12", "15:18"],
                28 => ["18:12", "19:17", "04:55", "12:11", "15:19"]
            ],
            4 => [
                2  => ["18:10", "19:15", "04:53", "12:09", "15:20"],
                7  => ["18:08", "19:14", "04:51", "12:08", "15:20"],
                12 => ["18:07", "19:13", "04:51", "12:07", "15:20"],
                17 => ["18:05", "19:10", "04:51", "12:06", "15:20"],
                22 => ["18:02", "19:09", "04:50", "12:05", "15:20"],
                27 => ["18:01", "19:08", "04:50", "12:04", "15:20"]
            ],
            5 => [
                2  => ["17:59", "19:08", "04:49", "12:03", "15:20"],
                7  => ["17:58", "19:07", "04:49", "12:02", "15:21"],
                12 => ["17:58", "19:05", "04:49", "12:02", "15:21"],
                17 => ["17:57", "19:03", "04:48", "12:02", "15:21"],
                22 => ["17:56", "19:06", "04:47", "12:02", "15:21"],
                27 => ["17:56", "19:07", "04:47", "12:03", "15:22"]
            ],
            6 => [
                1  => ["17:57", "19:08", "04:47", "12:03", "15:23"],
                6  => ["17:58", "19:09", "04:48", "12:04", "15:24"],
                11 => ["17:59", "19:09", "04:50", "12:05", "15:25"],
                16 => ["18:00", "19:10", "04:51", "12:06", "15:26"],
                21 => ["18:02", "19:11", "04:52", "12:07", "15:27"],
                26 => ["18:02", "19:12", "04:54", "12:08", "15:28"]
            ],
            7 => [
                1  => ["18:03", "19:13", "04:55", "12:09", "15:29"],
                6  => ["18:05", "19:13", "04:56", "12:10", "15:30"],
                11 => ["18:05", "19:14", "04:56", "12:11", "15:31"],
                16 => ["18:06", "19:16", "04:57", "12:11", "15:31"],
                21 => ["18:06", "19:16", "04:57", "12:12", "15:31"],
                26 => ["18:07", "19:16", "04:58", "12:12", "15:31"],
                31 => ["18:08", "19:17", "04:58", "12:12", "15:31"]
            ],
            8 => [
                5  => ["18:08", "19:17", "04:55", "12:11", "15:30"],
                10 => ["18:08", "19:16", "04:57", "12:11", "15:30"],
                15 => ["18:08", "19:15", "04:56", "12:10", "15:25"],
                20 => ["18:07", "19:15", "04:54", "12:09", "15:26"],
                25 => ["18:06", "19:13", "04:53", "12:09", "15:24"],
                30 => ["18:06", "19:11", "04:52", "12:07", "15:22"]
            ],
            9 => [
                4  => ["18:04", "19:09", "04:51", "12:05", "15:19"],
                9  => ["18:03", "19:06", "04:47", "12:05", "15:15"],
                14 => ["18:01", "19:07", "04:44", "12:02", "15:13"],
                19 => ["18:01", "19:06", "04:41", "12:00", "15:05"],
                24 => ["18:00", "19:05", "04:33", "11:58", "15:02"],
                29 => ["18:00", "19:03", "04:36", "11:56", "15:01"]
            ],
            10 => [
                4  => ["17:58", "19:03", "04:35", "11:53", "14:29"],
                9  => ["17:57", "19:03", "04:34", "11:53", "14:55"],
                14 => ["17:56", "19:03", "04:32", "11:52", "14:56"],
                19 => ["17:56", "19:04", "04:30", "11:51", "14:58"],
                24 => ["17:56", "19:04", "04:27", "11:50", "15:01"],
                29 => ["17:55", "19:04", "04:26", "11:49", "15:02"]
            ],
            11 => [
                3  => ["17:57", "19:05", "04:23", "11:49", "15:05"],
                8  => ["17:59", "19:05", "04:23", "11:49", "15:06"],
                13 => ["17:59", "19:07", "04:22", "11:50", "15:03"],
                18 => ["17:59", "19:08", "04:21", "11:51", "15:10"],
                23 => ["18:02", "19:12", "04:21", "11:52", "15:12"],
                28 => ["18:05", "19:14", "04:22", "11:53", "15:13"]
            ],
            12 => [
                3  => ["18:07", "19:17", "04:22", "11:55", "15:16"],
                8  => ["18:08", "19:18", "04:25", "11:57", "15:20"],
                13 => ["18:12", "19:21", "04:27", "12:00", "15:23"],
                18 => ["18:14", "19:24", "04:29", "12:02", "15:25"],
                23 => ["18:15", "19:27", "04:31", "12:06", "15:29"],
                28 => ["18:19", "19:28", "04:34", "12:07", "15:31"]
            ]
        ];
    }

    /**
     * Konversi string "HH:MM" atau "HH.MM" ke total menit dari 00:00
     */
    public static function timeToMinutes(string $timeStr): int
    {
        $timeStr = str_replace('.', ':', trim($timeStr));
        $parts   = explode(':', $timeStr);
        $h       = (int) ($parts[0] ?? 0);
        $m       = (int) ($parts[1] ?? 0);
        return ($h * 60) + $m;
    }

    /**
     * Konversi menit ke format "HH:MM"
     */
    public static function minutesToTime(int $minutes): string
    {
        $minutes = ($minutes % 1440 + 1440) % 1440;
        $h       = floor($minutes / 60);
        $m       = $minutes % 60;
        return sprintf('%02d:%02d', $h, $m);
    }

    /**
     * Generate seluruh jadwal 366 hari tahunan secara otomatis berbasis interpolasi data hisab
     */
    public function generateTahunan(bool $force = false): int
    {
        $existingCount = $this->countAllResults();
        if ($existingCount > 0 && !$force) {
            return $existingCount;
        }

        if ($force) {
            $this->db->table($this->table)->truncate();
        }

        $anchors = self::getMasterAnchors();
        $daysInMonths = [
            1 => 31, 2 => 29, 3 => 31, 4 => 30, 5 => 31, 6 => 30,
            7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31
        ];

        // Buat timeline linier 366 hari
        $timeline = [];
        $dayOfYear = 0;
        for ($m = 1; $m <= 12; $m++) {
            for ($d = 1; $d <= $daysInMonths[$m]; $d++) {
                $dayOfYear++;
                $timeline[$dayOfYear] = [
                    'bulan'   => $m,
                    'tanggal' => $d,
                    'data'    => null
                ];

                if (isset($anchors[$m][$d])) {
                    $raw = $anchors[$m][$d];
                    $timeline[$dayOfYear]['data'] = [
                        'maghrib' => self::timeToMinutes($raw[0]),
                        'isya'    => self::timeToMinutes($raw[1]),
                        'subuh'   => self::timeToMinutes($raw[2]),
                        'dzuhur'  => self::timeToMinutes($raw[3]),
                        'ashar'   => self::timeToMinutes($raw[4])
                    ];
                }
            }
        }

        $totalDays = count($timeline);
        $knownDays = [];
        foreach ($timeline as $idx => $t) {
            if ($t['data'] !== null) {
                $knownDays[] = $idx;
            }
        }

        // Interpolasi linier antar titik jangkar
        $fields = ['maghrib', 'isya', 'subuh', 'dzuhur', 'ashar'];

        for ($idx = 1; $idx <= $totalDays; $idx++) {
            if ($timeline[$idx]['data'] !== null) {
                continue;
            }

            // Cari known prev & known next
            $prev = null;
            $next = null;

            for ($k = $idx - 1; $k >= 1; $k--) {
                if ($timeline[$k]['data'] !== null) {
                    $prev = $k;
                    break;
                }
            }
            for ($k = $idx + 1; $k <= $totalDays; $k++) {
                if ($timeline[$k]['data'] !== null) {
                    $next = $k;
                    break;
                }
            }

            // Boundary wrap around jika di awal Jan atau akhir Des
            if ($prev === null) {
                $prev = end($knownDays) - $totalDays;
                $prevData = $timeline[end($knownDays)]['data'];
            } else {
                $prevData = $timeline[$prev]['data'];
            }

            if ($next === null) {
                $next = $knownDays[0] + $totalDays;
                $nextData = $timeline[$knownDays[0]]['data'];
            } else {
                $nextData = $timeline[$next]['data'];
            }

            $span  = $next - $prev;
            $delta = $idx - $prev;
            $ratio = $span > 0 ? ($delta / $span) : 0;

            $interp = [];
            foreach ($fields as $f) {
                $val = round($prevData[$f] + (($nextData[$f] - $prevData[$f]) * $ratio));
                $interp[$f] = (int) $val;
            }

            $timeline[$idx]['data'] = $interp;
        }

        // Simpan ke database
        $inserted = 0;
        foreach ($timeline as $t) {
            $m   = $t['bulan'];
            $d   = $t['tanggal'];
            $dat = $t['data'];

            $subuhMin = $dat['subuh'];
            $imsakMin = $subuhMin - 10;
            $terbitMin = $subuhMin + 75;
            $dhuhaMin  = $terbitMin + 25;

            $newId = sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $record = [
                'id'         => $newId,
                'bulan'      => $m,
                'tanggal'    => $d,
                'imsak'      => self::minutesToTime($imsakMin),
                'subuh'      => self::minutesToTime($subuhMin),
                'terbit'     => self::minutesToTime($terbitMin),
                'dhuha'      => self::minutesToTime($dhuhaMin),
                'dzuhur'     => self::minutesToTime($dat['dzuhur']),
                'ashar'      => self::minutesToTime($dat['ashar']),
                'maghrib'    => self::minutesToTime($dat['maghrib']),
                'isya'       => self::minutesToTime($dat['isya']),
                'keterangan' => 'Rujukan Hisab Masjid Agung'
            ];

            $this->insert($record);
            $inserted++;
        }

        return $inserted;
    }
}
