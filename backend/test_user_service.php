<?php

require_once __DIR__ . '/dao/UserDAO.php';
require_once __DIR__ . '/services/UserService.php';

$pdo = Database::connect();
$userDAO = new UserDAO();
$userService = new UserService();

try {
    $pdo->beginTransaction();

    // CREATE
    $userId = $userService->createUser([
        'full_name' => 'Service Test User',
        'email' => 'service_test_' . uniqid() . '@example.com',
        'password' => 'test123456',
        'role' => 'user'
    ]);

    echo "CREATE: PASS\n";

    // READ
    $user = $userService->getUserById((int)$userId);

    if ($user['full_name'] !== 'Service Test User') {
        throw new Exception('READ failed.');
    }

    echo "READ: PASS\n";

    // PASSWORD HASH
    if (!password_verify('test123456', $user['password'])) {
        throw new Exception('PASSWORD HASH failed.');
    }

    echo "PASSWORD HASH: PASS\n";

    // UPDATE
    $userService->updateUser((int)$userId, [
        'full_name' => 'Updated Service User'
    ]);

    $updatedUser = $userService->getUserById((int)$userId);

    if ($updatedUser['full_name'] !== 'Updated Service User') {
        throw new Exception('UPDATE failed.');
    }

    echo "UPDATE: PASS\n";

    // DELETE
    $userService->deleteUser((int)$userId);

    try {
        $userService->getUserById((int)$userId);
        throw new Exception('DELETE failed.');
    } catch (InvalidArgumentException $e) {
        echo "DELETE: PASS\n";
    }

    // VALIDATION
    try {
        $userService->createUser([
            'full_name' => 'Invalid User',
            'email' => 'not-an-email',
            'password' => 'test123456',
            'role' => 'user'
        ]);

        throw new Exception('VALIDATION failed.');
    } catch (InvalidArgumentException $e) {
        echo "VALIDATION: PASS\n";
    }

    $pdo->rollBack();

    echo "\nALL USER SERVICE TESTS PASSED.\n";
    echo "CLEANUP: Transaction rolled back.\n";

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo "TEST FAILED: " . $e->getMessage() . "\n";
    exit(1);
}