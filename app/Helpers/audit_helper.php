<?php

/**
 * 🛡️ Audit Trail Helper - Standar v2.5
 * Digunakan untuk mencatat jejak perubahan data (Before vs After) ke tabel log_activities.
 */

if (!function_exists('log_activity')) {
    /**
     * Mencatat aktivitas perubahan data
     * 
     * @param string $action    Aksi yang dilakukan (INSERT, UPDATE, DELETE)
     * @param string $tableName Nama tabel target
     * @param string $recordId  ID unik baris (UUID)
     * @param array|null $beforeData Data sebelum perubahan (untuk UPDATE/DELETE)
     * @param array|null $afterData  Data sesudah perubahan (untuk INSERT/UPDATE)
     * @return bool
     */
    function log_activity(string $action, string $tableName, string $recordId, array $beforeData = null, array $afterData = null): bool
    {
        try {
            $db      = \Config\Database::connect();
            $request = \Config\Services::request();
            $session = \Config\Services::session();

            // Ambil User ID dari session login
            $userId = $session->get('user_id') ?: null;

            // Dapatkan IP dan User Agent
            $ipAddress = $request->getIPAddress();
            $userAgent = $request->getUserAgent()->getAgentString();

            // Siapkan format JSON
            $beforeJson = $beforeData ? json_encode($beforeData) : null;
            $afterJson  = $afterData ? json_encode($afterData) : null;

            $db->table('log_activities')->insert([
                'user_id'     => $userId,
                'action'      => strtoupper($action),
                'table_name'  => $tableName,
                'record_id'   => $recordId,
                'before_data' => $beforeJson,
                'after_data'  => $afterJson,
                'ip_address'  => $ipAddress,
                'user_agent'  => $userAgent,
                'created_at'  => date('Y-m-d H:i:s')
            ]);

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Audit Log Failed: ' . $e->getMessage());
            return false;
        }
    }
}
