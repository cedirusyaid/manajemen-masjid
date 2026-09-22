<?php

/**
 * 📢 Telegram Helper - Standar v2.5 & v2.6
 * Digunakan untuk logging error kritis, monitoring transaksi, dan notifikasi pengurus.
 */

if (!function_exists('telegram_send_msg')) {
    /**
     * Mengirim pesan teks ke Telegram Chat ID yang dikonfigurasi di .env
     */
    function telegram_send_msg(string $message): bool
    {
        $token  = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (empty($token) || empty($chatId)) {
            log_message('warning', 'Telegram Helper: Token atau Chat ID kosong di .env');
            return false;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = [
            'chat_id'    => $chatId,
            'text'       => $message,
            'parse_mode' => 'HTML'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        $status = ($httpCode === 200) ? 'success' : 'failed';

        // Log request & response ke tabel log_telegram
        try {
            $db = \Config\Database::connect();
            $db->table('log_telegram')->insert([
                'bot_action'    => 'sendMessage',
                'request_data'  => json_encode($data),
                'response_data' => $response ?: $curlError,
                'status'        => $status,
                'created_at'    => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Telegram Helper Database Log Failed: ' . $e->getMessage());
        }

        if ($status === 'failed') {
            log_message('error', "Telegram HTTP Error [Code: {$httpCode}]: " . ($response ?: $curlError));
            return false;
        }

        return true;
    }
}

if (!function_exists('telegram_log_error')) {
    /**
     * Logging otomatis error kritis/exception ke Telegram Chat
     */
    function telegram_log_error(Throwable $exception): bool
    {
        $envMode = env('CI_ENVIRONMENT') ?: 'production';
        $currentTime = date('Y-m-d H:i:s');

        $message = "🚨 <b>KRITIS: SYSTEM ERROR DETECTED</b> 🚨\n\n";
        $message .= "<b>Project:</b> " . site_name() . "\n";
        $message .= "<b>Environment:</b> " . strtoupper($envMode) . "\n";
        $message .= "<b>Waktu:</b> {$currentTime}\n";
        $message .= "<b>File:</b> <code>" . esc($exception->getFile()) . "</code>\n";
        $message .= "<b>Line:</b> " . esc($exception->getLine()) . "\n\n";
        $message .= "<b>Pesan Error:</b>\n<pre>" . esc($exception->getMessage()) . "</pre>\n\n";
        $message .= "#Error #MasjidAgung #SystemAlert #" . ucfirst(strtolower($envMode));

        return telegram_send_msg($message);
    }
}

if (!function_exists('telegram_notify_change')) {
    /**
     * Notifikasi aktivitas perubahan data (INSERT, UPDATE, DELETE, LOGIN) ke Telegram
     *
     * @param string $action    Aksi: INSERT / UPDATE / DELETE / LOGIN / dsb
     * @param string $module    Nama Modul / Tabel target (misal: Kas Keuangan, Jadwal Jumat)
     * @param string $detail    Ringkasan rincian perubahan (misal: judul, nominal, nama orang)
     * @param string|null $actor Nama / Username yang melakukan perubahan
     * @return bool
     */
    function telegram_notify_change(string $action, string $module, string $detail = '', ?string $actor = null): bool
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();

        if (empty($actor)) {
            $actor = $session->get('username') ?: ($session->get('user_name') ?: 'System/Guest');
        }
        $ip = $request->getIPAddress();
        $waktu = date('d-m-Y H:i:s');

        $icons = [
            'INSERT' => '✨',
            'CREATE' => '✨',
            'UPDATE' => '📝',
            'EDIT'   => '📝',
            'DELETE' => '🗑️',
            'LOGIN'  => '🔑',
            'LOGOUT' => '🚪',
        ];
        $actUpper = strtoupper($action);
        $icon = $icons[$actUpper] ?? '🔔';

        // Mapping module/table name ke nama yang rapi dan tag
        $moduleTagMap = [
            'mst_berita'         => ['name' => 'Berita & Pengumuman', 'tag' => '#Berita'],
            'trn_kas'            => ['name' => 'Kas Keuangan', 'tag' => '#Keuangan'],
            'mst_petugas_jumat'  => ['name' => 'Pelaksana Shalat Jumat', 'tag' => '#JadwalJumat'],
            'mst_layanan'        => ['name' => 'Master Layanan', 'tag' => '#Layanan'],
            'trn_pelayanan'      => ['name' => 'Permohonan Layanan', 'tag' => '#Pelayanan'],
            'mst_agenda'         => ['name' => 'Agenda Kegiatan', 'tag' => '#Agenda'],
            'mst_pengurus'       => ['name' => 'Pengurus Masjid', 'tag' => '#Pengurus'],
            'mst_inventaris'     => ['name' => 'Inventaris Aset', 'tag' => '#Inventaris'],
            'mst_users'          => ['name' => 'Manajemen Pengguna', 'tag' => '#User'],
            'sys_settings'       => ['name' => 'Pengaturan Sistem', 'tag' => '#Pengaturan'],
        ];

        $moduleKey = strtolower(trim($module));
        $moduleDisplay = $moduleTagMap[$moduleKey]['name'] ?? ucwords(str_replace(['mst_', 'trn_', 'sys_', '_'], ['', '', '', ' '], $module));
        $moduleTag = $moduleTagMap[$moduleKey]['tag'] ?? ('#' . preg_replace('/[^a-zA-Z0-9]/', '', ucwords($moduleDisplay)));

        // Buat tag aksi
        $actionTag = '#' . ucfirst(strtolower($actUpper));

        $msg  = "{$icon} <b>AKTIVITAS SISTEM - " . site_name() . "</b>\n\n";
        $msg .= "<b>Aksi:</b> {$actUpper}\n";
        $msg .= "<b>Modul:</b> " . esc($moduleDisplay) . "\n";
        if (!empty($detail)) {
            $msg .= "<b>Rincian:</b> " . esc($detail) . "\n";
        }
        $msg .= "<b>Oleh:</b> " . esc($actor) . "\n";
        $msg .= "<b>IP:</b> <code>{$ip}</code>\n";
        $msg .= "<b>Waktu:</b> {$waktu}\n\n";
        $msg .= "#MasjidAgung {$actionTag} {$moduleTag} #AuditLog";

        return telegram_send_msg($msg);
    }
}
