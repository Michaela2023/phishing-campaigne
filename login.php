<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '0');

$email = trim((string)($_POST['email'] ?? ''));

if ($email === '') {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Chybí e-mail.']);
  exit;
}

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
$time = date('Y-m-d H:i:s');

$line = $time . " | LOGIN_OK | email=" . $email . " | ip=" . $ip . " | ua=" . $ua . "\n";

$logFile = __DIR__ . '/log/login_success.txt';

file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);

echo json_encode([
  'ok' => true,
  'redirect' => 'learn.html'
]);
