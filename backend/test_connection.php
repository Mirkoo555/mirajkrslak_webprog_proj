<?php

require_once __DIR__ . '/config/Database.php';

try {
    $pdo = Database::connect();

    $result = $pdo->query("SELECT DATABASE()")->fetchColumn();

    echo "Database connection successful!\n";
    echo "Connected database: " . $result . "\n";
} catch (PDOException $e) {
    echo "Database connection failed.\n";
    echo $e->getMessage() . "\n";
}
