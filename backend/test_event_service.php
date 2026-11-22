<?php

require_once __DIR__ . '/services/EventService.php';
require_once __DIR__ . '/config/Database.php';

$pdo = Database::connect();
$pdo->beginTransaction();

try {
    $service = new EventService();

    // CREATE
    $userId = $pdo->query("SELECT user_id FROM users LIMIT 1")->fetchColumn();

    if (!$userId) {
        throw new RuntimeException('No user found for testing.');
    }

    $eventId = $service->createEvent([
        'user_id' => $userId,
        'title' => 'Test Car Event',
        'description' => 'Temporary test event',
        'location' => 'Sarajevo',
        'event_date' => '2027-06-15 12:00:00'
    ]);

    echo "CREATE: PASS\n";

    // READ
    $event = $service->getEventById((int)$eventId);

    if (
        $event['title'] === 'Test Car Event' &&
        $event['location'] === 'Sarajevo'
    ) {
        echo "READ: PASS\n";
    } else {
        throw new RuntimeException('Event read test failed.');
    }

    // UPDATE
    $service->updateEvent((int)$eventId, [
        'user_id' => $userId,
        'title' => 'Updated Car Event',
        'description' => 'Updated test event',
        'location' => 'Mostar',
        'event_date' => '2027-06-16 12:00:00'
    ]);

    $updatedEvent = $service->getEventById((int)$eventId);

    if ($updatedEvent['title'] === 'Updated Car Event') {
        echo "UPDATE: PASS\n";
    } else {
        throw new RuntimeException('Event update test failed.');
    }

    // DELETE
    $service->deleteEvent((int)$eventId);

    try {
        $service->getEventById((int)$eventId);
        throw new RuntimeException('Deleted event was still found.');
    } catch (InvalidArgumentException $e) {
        echo "DELETE: PASS\n";
    }

    // VALIDATION
    try {
        $service->createEvent([
            'user_id' => $userId,
            'title' => '',
            'location' => 'Sarajevo',
            'event_date' => '2027-06-15 12:00:00'
        ]);

        throw new RuntimeException('Invalid event data was accepted.');
    } catch (InvalidArgumentException $e) {
        echo "VALIDATION: PASS\n";
    }

    echo "\nALL EVENT SERVICE TESTS PASSED.\n";

} catch (Throwable $e) {
    echo "TEST FAILED: " . $e->getMessage() . "\n";

} finally {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
        echo "CLEANUP: Transaction rolled back.\n";
    }
}