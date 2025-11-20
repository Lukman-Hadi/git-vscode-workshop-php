<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controllers\UserController;
use App\Services\AuthService;
use App\Utils\Logger;

$router = new Router();
$userController = new UserController();
$authService = new AuthService();

$router->get('/health', function() {
    header('Content-Type: application/json');
    echo json_encode(['status' => 'ok', 'timestamp' => time()]);
});

$router->get('/users', function() use ($userController) {
    header('Content-Type: application/json');
    $sort = $_GET['sortBy'] ?? null;
    $options = $sort ? ['sortBy' => $sort] : [];
    echo json_encode($userController->listUsers($options));
});

$router->post('/users', function() use ($userController) {
    header('Content-Type: application/json');
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid JSON body']);
        return;
    }
    try {
        $new = $userController->addUser($data);
        http_response_code(201);
        echo json_encode($new);
    } catch (InvalidArgumentException $e) {
        http_response_code(422);
        echo json_encode(['error' => $e->getMessage()]);
    } catch (Throwable $e) {
        Logger::error('Add user failed', ['exception' => $e->getMessage()]);
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
    }
});

$router->post('/users/login', function() use ($authService) {
    header('Content-Type: application/json');
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true) ?: [];
    $token = $data['token'] ?? '';
    if (!$authService->verifyToken($token)) {
        http_response_code(401);
        echo json_encode(['error' => 'Invalid token']);
        return;
    }
    echo json_encode(['status' => 'authenticated']);
});

try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
} catch (Throwable $e) {
    Logger::error('Unhandled exception: '.$e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Internal Server Error']);
}