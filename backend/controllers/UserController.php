<?php

require_once __DIR__ . '/../services/UserService.php';

class UserController
{
    private UserService $service;

    public function __construct()
    {
        $this->service = new UserService();
    }

    public function index(): void
    {
        try {
            $users = array_map([$this, 'hidePassword'], $this->service->getAllUsers());
            Flight::json(['status' => 'success', 'data' => $users], 200);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function show(string $id): void
    {
        try {
            $user = $this->service->getUserById((int) $id);
            Flight::json(['status' => 'success', 'data' => $this->hidePassword($user)], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function store(): void
    {
        try {
            $id = $this->service->createUser(Flight::request()->data->getData());
            Flight::json(['status' => 'success', 'message' => 'User created successfully.', 'user_id' => $id], 201);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function update(string $id): void
    {
        try {
            $this->service->updateUser((int) $id, Flight::request()->data->getData());
            Flight::json(['status' => 'success', 'message' => 'User updated successfully.'], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function destroy(string $id): void
    {
        try {
            $this->service->deleteUser((int) $id);
            Flight::json(['status' => 'success', 'message' => 'User deleted successfully.'], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    private function hidePassword(array $user): array
    {
        unset($user['password']);
        return $user;
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
