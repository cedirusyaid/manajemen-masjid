<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'sys_settings';
    protected $primaryKey       = 'key';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = ['key', 'value', 'group'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Static cache memory agar tidak query berulang kali pada single request lifecycle
    private static $settingsCache = null;

    /**
     * Mengambil seluruh data pengaturan dalam bentuk array asosiatif key-value
     */
    public function getSettings(): array
    {
        if (self::$settingsCache !== null) {
            return self::$settingsCache;
        }

        // Ambil dari Cache Driver CI4 (jika ada) untuk optimalisasi performa tinggi
        $cache = \Config\Services::cache();
        $cacheKey = 'sys_app_settings_all';
        $cachedData = $cache->get($cacheKey);

        if ($cachedData !== null && is_array($cachedData)) {
            self::$settingsCache = $cachedData;
            return self::$settingsCache;
        }

        // Jika cache kosong, ambil dari database
        try {
            $rawSettings = $this->findAll();
            $settings = [];
            foreach ($rawSettings as $row) {
                $settings[$row['key']] = $row['value'];
            }

            self::$settingsCache = $settings;
            
            // Simpan ke Cache Driver selama 1 hari agar database tidak terbebani query statis
            $cache->save($cacheKey, $settings, 86400);

            return $settings;
        } catch (\Exception $e) {
            // Log error jika tabel belum dimigrasi tetapi helper dipanggil
            log_message('error', 'SettingModel error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Mendapatkan nilai setting berdasarkan key dengan fallback value
     */
    public function getSetting(string $key, $default = null)
    {
        $settings = $this->getSettings();
        return $settings[$key] ?? $default;
    }

    /**
     * Menyimpan atau memperbarui setting tertentu
     */
    public function setSetting(string $key, $value, string $group = 'general'): bool
    {
        $data = [
            'key'   => $key,
            'value' => $value,
            'group' => $group
        ];

        // Ganti data di DB
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        $result = $builder->replace($data);

        if ($result) {
            // Hapus cache agar pembaruan data langsung aktif
            self::$settingsCache = null;
            $cache = \Config\Services::cache();
            $cache->delete('sys_app_settings_all');
            return true;
        }

        return false;
    }
}
