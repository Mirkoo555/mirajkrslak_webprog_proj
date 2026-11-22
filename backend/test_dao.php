<?php

require_once __DIR__ . '/dao/UserDAO.php';
require_once __DIR__ . '/dao/BrandDAO.php';
require_once __DIR__ . '/dao/CarDAO.php';
require_once __DIR__ . '/dao/FavoriteDAO.php';
require_once __DIR__ . '/dao/EventDAO.php';
require_once __DIR__ . '/dao/ReviewDAO.php';

$pdo = Database::connect();

$daos = [
    'users' => new UserDAO(),
    'brands' => new BrandDAO(),
    'cars' => new CarDAO(),
    'favorites' => new FavoriteDAO(),
    'events' => new EventDAO(),
    'reviews' => new ReviewDAO(),
];

$created = [];

try {
    $pdo->beginTransaction();

    // CREATE: temporary user
    $userId = $daos['users']->create([
        'full_name' => 'DAO Test User',
        'email' => 'dao_test_' . uniqid() . '@example.com',
        'password' => password_hash('test123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]);
    $created['user'] = $userId;

    // CREATE: temporary brand
    $brandId = $daos['brands']->create([
        'brand_name' => 'DAO Test Brand ' . uniqid(),
        'country' => 'Test Country',
        'logo_url' => null
    ]);
    $created['brand'] = $brandId;

    // CREATE: temporary car
    $carId = $daos['cars']->create([
        'user_id' => $userId,
        'brand_id' => $brandId,
        'model' => 'DAO Test Model',
        'year' => 2024,
        'price' => 10000,
        'fuel_type' => 'Diesel',
        'transmission' => 'Manual',
        'description' => 'Temporary DAO test car'
    ]);
    $created['car'] = $carId;

    // CREATE: favorite
    $favoriteId = $daos['favorites']->create([
        'user_id' => $userId,
        'car_id' => $carId
    ]);
    $created['favorite'] = $favoriteId;

    // CREATE: event
    $eventId = $daos['events']->create([
        'user_id' => $userId,
        'title' => 'DAO Test Event',
        'description' => 'Temporary test event',
        'location' => 'Sarajevo',
        'event_date' => '2027-01-01 12:00:00'
    ]);
    $created['event'] = $eventId;

    // CREATE: review
    $reviewId = $daos['reviews']->create([
        'user_id' => $userId,
        'car_id' => $carId,
        'rating' => 5,
        'comment' => 'Temporary DAO test review'
    ]);
    $created['review'] = $reviewId;

    echo "CREATE: PASS - all six records created.\n";

    // READ
    foreach ($daos as $name => $dao) {
        if (!$dao->getById((int) $created[$name === 'users' ? 'user' :
            ($name === 'brands' ? 'brand' :
            ($name === 'cars' ? 'car' :
            ($name === 'favorites' ? 'favorite' :
            ($name === 'events' ? 'event' : 'review'))))])) {
            throw new Exception("READ failed for {$name}.");
        }

        if (!is_array($dao->getAll())) {
            throw new Exception("READ ALL failed for {$name}.");
        }
    }

    echo "READ: PASS - getById and getAll work for all six tables.\n";

    // UPDATE: update user
    $daos['users']->update((int) $userId, [
        'full_name' => 'DAO Test User Updated'
    ]);

    $updatedUser = $daos['users']->getById((int) $userId);

    if ($updatedUser['full_name'] !== 'DAO Test User Updated') {
        throw new Exception("UPDATE failed.");
    }

    echo "UPDATE: PASS - user record updated.\n";

    // DELETE: explicitly test delete, then rollback remaining records
    $daos['reviews']->delete((int) $reviewId);

    if ($daos['reviews']->getById((int) $reviewId) !== false) {
        throw new Exception("DELETE failed.");
    }

    echo "DELETE: PASS - review record deleted.\n";

    $pdo->rollBack();

    echo "CLEANUP: PASS - transaction rolled back; original database preserved.\n";
    echo "\nALL CRUD TESTS PASSED.\n";

} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}
