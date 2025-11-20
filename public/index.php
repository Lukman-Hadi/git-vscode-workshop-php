<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\UserController;
use App\Utils\Logger;

// INIT (Latihan: nanti refactor ke bootstrap terpisah)
$router = new Router();
$userController = new UserController();

// HEALTH
$router->get('/health', function() {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'timestamp' => time()]);
});

// USERS ENDPOINT
$router->get('/users', function() use ($userController) {
    header('Content-Type: application/json');
    echo json_encode($userController->listUsers());
});

// TODO (Latihan Fitur): Tambah endpoint POST /users untuk menambah user baru (commit feat terpisah).

// TODO (Latihan Refactor): Pindahkan inisialisasi Router & Controller ke file bootstrap (commit refactor).

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (Throwable $e) {
    Logger::error("Unhandled exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}