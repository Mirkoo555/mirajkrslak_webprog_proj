<?php

require_once __DIR__ . '/../services/EventService.php';

class EventController
{
    private EventService $service;

    public function __construct()
    {
        $this->service = new EventService();
    }

    public function index(): void
    {
        try {
            Flight::json(['status' => 'success', 'data' => $this->service->getAllEvents()], 200);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function show(string $id): void
    {
        try {
            Flight::json(['status' => 'success', 'data' => $this->service->getEventById((int) $id)], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function store(): void
    {
        try {
            $id = $this->service->createEvent(Flight::request()->data->getData());
            Flight::json(['status' => 'success', 'message' => 'Event created successfully.', 'event_id' => $id], 201);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function update(string $id): void
    {
        try {
            $this->service->updateEvent((int) $id, Flight::request()->data->getData());
            Flight::json(['status' => 'success', 'message' => 'Event updated successfully.'], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function destroy(string $id): void
    {
        try {
            $this->service->deleteEvent((int) $id);
            Flight::json(['status' => 'success', 'message' => 'Event deleted successfully.'], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    private function clientError(InvalidArgumentException $e): void
    {
        $status = str_contains(strtolower($e->getMessage()), 'not found') ? 404 : 400;
        Flight::json(['status' => 'error', 'message' => $e->getMessage()], $status);
    }

    private function serverError(Throwable $e): void
    {
        error_log($e->getMessage());
        Flight::json(['status' => 'error', 'message' => 'An internal server error occurred.'], 500);
    }
}
