<?php

require_once __DIR__ . '/../dao/EventDAO.php';

class EventService
{
    private EventDAO $eventDAO;

    public function __construct()
    {
        $this->eventDAO = new EventDAO();
    }

    public function getAllEvents(): array
    {
        return $this->eventDAO->getAll();
    }

    public function getEventById(int $id): array
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('Invalid event ID.');
        }

        $event = $this->eventDAO->getById($id);

        if (!$event) {
            throw new InvalidArgumentException('Event not found.');
        }

        return $event;
    }

    public function createEvent(array $data): string
    {
        $this->validateEventData($data);

        return $this->eventDAO->create($data);
    }

    public function updateEvent(int $id, array $data): bool
    {
        $this->getEventById($id);
        $this->validateEventData($data);

        return $this->eventDAO->update($id, $data);
    }

    public function deleteEvent(int $id): bool
    {
        $this->getEventById($id);

        return $this->eventDAO->delete($id);
    }

    private function validateEventData(array $data): void
    {
        if (empty($data)) {
            throw new InvalidArgumentException('Event data cannot be empty.');
        }

        if (
            !isset($data['user_id']) ||
            (int)$data['user_id'] <= 0
        ) {
            throw new InvalidArgumentException('Invalid user ID.');
        }

        if (empty(trim($data['title'] ?? ''))) {
            throw new InvalidArgumentException('Event title is required.');
        }

        if (empty(trim($data['location'] ?? ''))) {
            throw new InvalidArgumentException('Event location is required.');
        }

        if (empty($data['event_date'])) {
            throw new InvalidArgumentException('Event date is required.');
        }

        $date = strtotime($data['event_date']);

        if ($date === false) {
            throw new InvalidArgumentException('Invalid event date.');
        }
    }
}