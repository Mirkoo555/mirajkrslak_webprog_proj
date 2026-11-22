<?php

require_once __DIR__ . '/dao/UserDAO.php';
require_once __DIR__ . '/dao/BrandDAO.php';
require_once __DIR__ . '/services/CarService.php';

$pdo = Database::connect();

$userDAO = new UserDAO();
$brandDAO = new BrandDAO();
$carService = new CarService();

try {
    $pdo->beginTransaction();

    // CREATE temporary user
    $userId = $userDAO->create([
        'full_name' => 'Service Test User',
        'email' => 'service_test_' . uniqid() . '@example.com',
        'password' => password_hash('test123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]);

    // CREATE temporary brand
    $brandId = $brandDAO->create([
        'brand_name' => 'Service Test Brand ' . uniqid(),
        'country' => 'Test Country',
        'logo_url' => null
    ]);

    // CREATE car through CarService
    $carId = (int) $carService->createCar([
        'user_id' => $userId,
        'brand_id' => $brandId,
        'model' => 'Service Test Model',
        'year' => 2024,
        'price' => 15000,
        'fuel_type' => 'Diesel',
        'transmission' => 'Manual',
        'description' => 'Temporary service test car'
    ]);

    echo "CREATE: PASS\n";

    // READ
    $car = $carService->getCarById($carId);

    if ($car['model'] !== 'Service Test Model') {
        throw new Exception('READ failed.');
    }

    if (!is_array($carService->getAllCars())) {
        throw new Exception('READ ALL failed.');
    }

    echo "READ: PASS\n";

    // UPDATE
    $carService->updateCar($carId, [
        'price' => 18000
    ]);

    $updatedCar = $carService->getCarById($carId);

    if ((float) $updatedCar['price'] !== 18000.0) {
        throw new Exception('UPDATE failed.');
    }

    echo "UPDATE: PASS\n";

    // DELETE
    $carService->deleteCar($carId);

    try {
        $carService->getCarById($carId);
        throw new Exception('DELETE failed.');
    } catch (InvalidArgumentException $e) {
        echo "DELETE: PASS\n";
    }

    // VALIDATION
    try {
        $carService->createCar([
            'user_id' => $userId,
            'brand_id' => $brandId,
            'model' => '',
            'year' => 2024,
            'price' => 15000
        ]);

        throw new Exception('VALIDATION failed.');
    } catch (InvalidArgumentException $e) {
        echo "VALIDATION: PASS\n";
    }

    $pdo->rollBack();

    echo "\nALL CAR SERVICE TESTS PASSED.\n";
    echo "CLEANUP: Transaction rolled back.\n";

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}