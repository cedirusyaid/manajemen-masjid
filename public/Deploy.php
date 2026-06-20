<?php
/**
 * Auto-Deployment Script for production Debian server
 * Standar v2.5 - Website Masjid Agung Nujumul Ittihad Sinjai
 */

// 1. Tentukan header JSON
header('Content-Type: application/json');

// 2. Load Composer Autoloader & Dotenv untuk membaca .env
$autoloadPath = __DIR__ . '/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'Composer autoloader not found. Please run composer install first.'
    ]);
    exit;
}

require $autoloadPath;

// Load .env file
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad();
}

// 3. Verifikasi Token Keamanan untuk menghindari trigger tidak sah
$expectedToken = $_ENV['DEPLOY_TOKEN'] ?? getenv('DEPLOY_TOKEN') ?? null;
$receivedToken = $_GET['token'] ?? $_POST['token'] ?? null;

if (empty($expectedToken)) {
    http_response_code(500);
    echo json_encode([
        'status' => false,
        'message' => 'DEPLOY_TOKEN is not configured in the server environment/.env file.'
    ]);
    exit;
}

if ($receivedToken !== $expectedToken) {
    http_response_code(403);
    echo json_encode([
        'status' => false,
        'message' => 'Unauthorized: Invalid deployment token.'
    ]);
    exit;
}

// 4. Eksekusi Perintah Deployment
$commands = [
    'git_pull' => 'git pull origin main 2>&1',
    'composer_install' => 'composer install --no-dev --optimize-autoloader 2>&1',
    'optimize_cache' => 'php spark optimize 2>&1'
];

$output = [];
$status = true;

// Pastikan command cd tidak dijalankan di runner asisten, 
// namun di server target ini aman karena dijalankan via php exec di OS target.
foreach ($commands as $name => $cmd) {
    $cmdOutput = [];
    $returnVar = 0;
    
    exec("cd " . escapeshellarg(__DIR__ . '/..') . " && $cmd", $cmdOutput, $returnVar);
    
    $output[$name] = [
        'command' => $cmd,
        'output' => $cmdOutput,
        'exit_code' => $returnVar
    ];
    
    if ($returnVar !== 0) {
        $status = false;
        sendTelegramAlert("⚠️ *Deployment Error on Command:* `" . $cmd . "`\nExit Code: " . $returnVar . "\nOutput:\n```\n" . implode("\n", array_slice($cmdOutput, -10)) . "\n```");
    }
}

// 5. Response Hasil Deployment
http_response_code($status ? 200 : 500);
echo json_encode([
    'status' => $status,
    'message' => $status ? 'Deployment completed successfully.' : 'Deployment failed.',
    'details' => $output
]);

/**
 * Helper untuk mengirim alert Telegram langsung jika deploy error (sesuai Standard Bot)
 */
function sendTelegramAlert($message) {
    $token = $_ENV['TELEGRAM_BOT_TOKEN'] ?? getenv('TELEGRAM_BOT_TOKEN');
    $chatId = $_ENV['TELEGRAM_CHAT_ID'] ?? getenv('TELEGRAM_CHAT_ID');
    
    if (!$token || !$chatId) {
        return;
    }
    
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message,
        'parse_mode' => 'Markdown'
    ];
    
    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
            'ignore_errors' => true
        ]
    ];
    
    $context = stream_context_create($options);
    @file_get_contents($url, false, $context);
}
