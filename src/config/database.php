<?php

function getEnvVar($key, $default = null) {
    static $env = null;
    if ($env === null) {
        $envPath = __DIR__ . '/../../.env';
        $env = [];
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($name, $value) = explode('=', $line, 2);
                    $env[trim($name)] = trim(trim($value), '"\'');
                }
            }
        }
    }
    return isset($env[$key]) ? $env[$key] : (isset($_ENV[$key]) ? $_ENV[$key] : (getenv($key) !== false ? getenv($key) : $default));
}

function getDB() {
    // Sesuaikan key dengan yang ada di GitHub Secrets (image_e540fd.png)
    $host = 'dblaporku.cn6woysaumir.ap-southeast-1.rds.amazonaws.com'; 
    $db   = 'laporku';
    $user = 'admin';
    $pass = 'uts12345678';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        // Line 40 yang menyebabkan error[cite: 1]
        throw new \PDOException("Gagal konek ke DB di host '$host': " . $e->getMessage(), (int)$e->getCode());
    }
}
