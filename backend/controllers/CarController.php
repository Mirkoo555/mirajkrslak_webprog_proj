<?php

require_once __DIR__ . '/../services/CarService.php';

class CarController
{
    private CarService $carService;

    public function __construct()
    {
        $this->carService = new CarService();
    }

    public function index(): void
    {
        try {
            Flight::json([
                'status' => 'success',
                'data' => $this->carService->getAllCars()
            ], 200);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function show(string $id): void
    {
        try {
            Flight::json([
                'status' => 'success',
                'data' => $this->carService->getCarById((int) $id)
            ], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function store(): void
    {
        try {
            $data = Flight::request()->data->getData();

            $id = $this->carService->createCar($data);

            Flight::json([
                'status' => 'success',
                'message' => 'Car created successfully.',
                'car_id' => $id
            ], 201);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function update(string $id): void
    {
        try {
            $data = Flight::request()->data->getData();

            $this->carService->updateCar((int) $id, $data);

            Flight::json([
                'status' => 'success',
                'message' => 'Car updated successfully.'
            ], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    public function destroy(string $id): void
    {
        try {
            $this->carService->deleteCar((int) $id);

            Flight::json([
                'status' => 'success',
                'message' => 'Car deleted successfully.'
            ], 200);
        } catch (InvalidArgumentException $e) {
            $this->clientError($e);
        } catch (Throwable $e) {
            $this->serverError($e);
        }
    }

    private function clientError(InvalidArgumentException $e): void
    {
        $status = str_contains(strtolower($e->getMessage()), 'not found')
            ? 404
            : 400;

        Flight::json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], $status);
    }

    private function serverError(Throwable $e): void
    {
        error_log($e->getMessage());

        Flight::json([
            'status' => 'error',
            'message' => 'An internal server error occurred.'
        ], 500);
    }
}