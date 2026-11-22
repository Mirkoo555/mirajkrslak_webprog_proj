<?php

require_once __DIR__ . '/../services/VehicleLookupService.php';

class VehicleLookupController
{
    private VehicleLookupService $vehicleLookupService;

    public function __construct()
    {
        $this->vehicleLookupService = new VehicleLookupService();
    }

    public function models(): void
    {
        $make = trim((string) ($_GET['make'] ?? ''));

        try {
            $models = $this->vehicleLookupService->getModelsByMake($make);

            Flight::json([
                'status' => 'success',
                'make' => $make,
                'count' => count($models),
                'data' => $models
            ], 200);

        } catch (InvalidArgumentException $e) {
            Flight::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);

        } catch (RuntimeException $e) {
            Flight::json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 503);

        } catch (Throwable $e) {
            error_log('Vehicle lookup controller error: ' . $e->getMessage());

            Flight::json([
                'status' => 'error',
                'message' => 'An unexpected error occurred.'
            ], 500);
        }
    }
}
