<?php
declare(strict_types=1);

header('Content-Type: text/plain; charset=utf-8');

@mkdir(__DIR__ . '/log', 0700, true);

$hash = (string)($_POST['hash'] ?? '');
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

$line = date('c') . " | ACCESS | hash=" . $hash . " | ip=" . $ip . " | ua=" . $ua . "\n";
file_put_contents(__DIR__ . '/log/access.txt', $line, FILE_APPEND);

echo "OK";
