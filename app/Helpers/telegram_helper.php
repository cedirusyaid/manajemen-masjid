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
        $message .= "<b>Project:</b> Website " . site_name() . "\n";
        $message .= "<b>Environment:</b> " . strtoupper($envMode) . "\n";
        $message .= "<b>Waktu:</b> {$currentTime}\n";
        $message .= "<b>File:</b> <code>" . esc($exception->getFile()) . "</code>\n";
        $message .= "<b>Line:</b> " . esc($exception->getLine()) . "\n\n";
        $message .= "<b>Pesan Error:</b>\n<pre>" . esc($exception->getMessage()) . "</pre>\n";

        return telegram_send_msg($message);
    }
}
