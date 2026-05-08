<?php
declare(strict_types=1);

require_once __DIR__ . '/config.php';

class Connection
{
    public static function pdo(): PDO
    {
        static $pdo = null;
        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $cfg = require __DIR__ . '/config.php';

        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $cfg['DB_HOST'], $cfg['DB_NAME']);
        $pdo = new PDO($dsn, $cfg['DB_USER'], $cfg['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    }
}

