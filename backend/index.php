<?php

header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$_SERVER['SCRIPT_NAME'] = '/api/index.php';

require_once __DIR__ . '/../vendor/autoload.php';

Flight::set('flight.debug', false);

require_once __DIR__ . '/controllers/CarController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/BrandController.php';
require_once __DIR__ . '/controllers/FavoriteController.php';
require_once __DIR__ . '/controllers/EventController.php';
require_once __DIR__ . '/controllers/ReviewController.php';
require_once __DIR__ . '/controllers/VehicleLookupController.php';

$controllers = [
    'cars' => new CarController(),
    'users' => new UserController(),
    'brands' => new BrandController(),
    'favorites' => new FavoriteController(),
    'events' => new EventController(),
    'reviews' => new ReviewController()
];

Flight::route('GET /vehicle-models', [new VehicleLookupController(), 'models']);

Flight::route('GET /health', function () {
    Flight::json([
        'status' => 'success',
        'message' => 'CarHub API is running.'
    ], 200);
});

foreach ($controllers as $resource => $controller) {
    Flight::route("GET /{$resource}", [$controller, 'index']);
    Flight::route("GET /{$resource}/@id", [$controller, 'show']);
    Flight::route("POST /{$resource}", [$controller, 'store']);
    Flight::route("PUT /{$resource}/@id", [$controller, 'update']);
    Flight::route("DELETE /{$resource}/@id", [$controller, 'destroy']);
}

Flight::start();
