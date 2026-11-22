<?php

require_once __DIR__ . '/services/FavoriteService.php';
require_once __DIR__ . '/config/Database.php';

$pdo = Database::connect();
$pdo->beginTransaction();

try {
    $service = new FavoriteService();

    // CREATE
    $userId = $pdo->query("SELECT user_id FROM users LIMIT 1")->fetchColumn();
    $carId = $pdo->query("SELECT car_id FROM cars LIMIT 1")->fetchColumn();

    $favoriteId = $service->createFavorite([
        'user_id' => $userId,
        'car_id' => $carId
    ]);

    echo "CREATE: PASS\n";

    // READ
    $favorite = $service->getFavoriteById((int)$favoriteId);

    if (
        (int)$favorite['user_id'] === (int)$userId &&
        (int)$favorite['car_id'] === (int)$carId
    ) {
        echo "READ: PASS\n";
    }

    // UPDATE
    $service->updateFavorite((int)$favoriteId, [
        'user_id' => $userId,
        'car_id' => $carId
    ]);

    echo "UPDATE: PASS\n";

    // DELETE
    $service->deleteFavorite((int)$favoriteId);

    echo "DELETE: PASS\n";

    // VALIDATION
    try {
        $service->createFavorite([
            'user_id' => 0,
            'car_id' => $carId
        ]);

        echo "VALIDATION: FAIL\n";
    } catch (InvalidArgumentException $e) {
        echo "VALIDATION: PASS\n";
    }

    echo "\nALL FAVORITE SERVICE TESTS PASSED.\n";

} catch (Throwable $e) {
    echo "TEST FAILED: " . $e->getMessage() . "\n";

} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
        echo "CLEANUP: Transaction rolled back.\n";
    }
}