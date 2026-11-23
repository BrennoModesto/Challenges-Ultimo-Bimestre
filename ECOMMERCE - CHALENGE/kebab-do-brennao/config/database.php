<?php
// config/database.php

require_once __DIR__ . '/env.php';

$dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    env('DB_HOST', 'localhost'),
    env('DB_NAME', 'kebab_do_brenao'),
    env('DB_CHARSET', 'utf8mb4')
);

try {
    $pdo = new PDO($dsn, env('DB_USER', 'root'), env('DB_PASS', ''), [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Erro ao conectar ao banco de dados. Verifique o arquivo .env.');
}
