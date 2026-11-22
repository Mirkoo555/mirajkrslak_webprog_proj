<?php

require_once __DIR__ . '/dao/BrandDAO.php';
require_once __DIR__ . '/services/BrandService.php';

$pdo = Database::connect();
$brandService = new BrandService();

try {
    $pdo->beginTransaction();

    // CREATE
    $brandId = $brandService->createBrand([
        'brand_name' => 'Service Test Brand ' . uniqid(),
        'country' => 'Germany',
        'logo_url' => null
    ]);

    echo "CREATE: PASS\n";

    // READ
    $brand = $brandService->getBrandById((int)$brandId);

    if ($brand['country'] !== 'Germany') {
        throw new Exception('READ failed.');
    }

    echo "READ: PASS\n";

    // UPDATE
    $brandService->updateBrand((int)$brandId, [
        'country' => 'Italy'
    ]);

    $updatedBrand = $brandService->getBrandById((int)$brandId);

    if ($updatedBrand['country'] !== 'Italy') {
        throw new Exception('UPDATE failed.');
    }

    echo "UPDATE: PASS\n";

    // DELETE
    $brandService->deleteBrand((int)$brandId);

    try {
        $brandService->getBrandById((int)$brandId);
        throw new Exception('DELETE failed.');
    } catch (InvalidArgumentException $e) {
        echo "DELETE: PASS\n";
    }

    // VALIDATION
    try {
        $brandService->createBrand([
            'brand_name' => '',
            'country' => 'Germany'
        ]);

        throw new Exception('VALIDATION failed.');
    } catch (InvalidArgumentException $e) {
        echo "VALIDATION: PASS\n";
    }

    $pdo->rollBack();

    echo "\nALL BRAND SERVICE TESTS PASSED.\n";
    echo "CLEANUP: Transaction rolled back.\n";

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}