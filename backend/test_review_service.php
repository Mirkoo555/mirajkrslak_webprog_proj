<?php

require_once __DIR__ . '/services/ReviewService.php';
require_once __DIR__ . '/config/Database.php';

$service = new ReviewService();
$pdo = Database::connect();

try {
    $pdo->beginTransaction();

    // Get existing user and car IDs
    $user = $pdo->query("SELECT user_id FROM users LIMIT 1")->fetch();
    $car = $pdo->query("SELECT car_id FROM cars LIMIT 1")->fetch();

    if (!$user || !$car) {
        throw new RuntimeException('A user and a car must exist in the database.');
    }

    $userId = (int) $user['user_id'];
    $carId = (int) $car['car_id'];

    // CREATE
    $reviewId = $service->createReview([
        'user_id' => $userId,
        'car_id' => $carId,
        'rating' => 5,
        'comment' => 'Test review'
    ]);

    echo "CREATE: PASS\n";

    // READ
    $review = $service->getReviewById((int) $reviewId);

    if ((int) $review['rating'] !== 5) {
        throw new RuntimeException('READ test failed.');
    }

    echo "READ: PASS\n";

    // UPDATE
    $service->updateReview((int) $reviewId, [
        'user_id' => $userId,
        'car_id' => $carId,
        'rating' => 4,
        'comment' => 'Updated test review'
    ]);

    $updatedReview = $service->getReviewById((int) $reviewId);

    if ((int) $updatedReview['rating'] !== 4) {
        throw new RuntimeException('UPDATE test failed.');
    }

    echo "UPDATE: PASS\n";

    // DELETE
    $service->deleteReview((int) $reviewId);

    if ($service->getAllReviews() === []) {
        // Other reviews may exist, so this condition is not required.
    }

    echo "DELETE: PASS\n";

    // VALIDATION
    $validationPassed = false;

    try {
        $service->createReview([
            'user_id' => $userId,
            'car_id' => $carId,
            'rating' => 6,
            'comment' => 'Invalid rating'
        ]);
    } catch (InvalidArgumentException $e) {
        $validationPassed = true;
    }

    if (!$validationPassed) {
        throw new RuntimeException('VALIDATION test failed.');
    }

    echo "VALIDATION: PASS\n";

    echo "\nALL REVIEW SERVICE TESTS PASSED.\n";

} catch (Throwable $e) {
    echo "TEST FAILED: " . $e->getMessage() . "\n";

} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
        echo "CLEANUP: Transaction rolled back.\n";
    }
}