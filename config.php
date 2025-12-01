
<?php
// src/config.php

declare(strict_types=1);

$DB_HOST = 'localhost';
$DB_NAME = 'adoptapals_db';
$DB_USER = 'root';
$DB_PASS = ''; // change if needed

try {
    $pdo = new PDO(
        "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    // In real production, log this to a file instead of echo
    http_response_code(500);
    echo "Database connection error.";
    exit;
}
