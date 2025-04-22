<?php
require_once __DIR__.'/../vendor/autoload.php';

header('Content-Type: application/json');

use App\Application\Auth\AuthController;

$authController = new AuthController();

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($method) {
    case 'POST':
        if ($path === '/api/auth/register') {
            $data = json_decode(file_get_contents('php://input'), true);
            try {
                $response = $authController->register(
                    $data['username'] ?? '',
                    $data['email'] ?? '',
                    $data['password'] ?? ''
                );
                echo json_encode($response);
            } catch (\InvalidArgumentException $e) {
                http_response_code(400);
                echo json_encode(['error' => $e->getMessage()]);
            }
        } elseif ($path === '/api/auth/login') {
            $data = json_decode(file_get_contents('php://input'), true);
            $response = $authController->login(
                $data['username'] ?? '',
                $data['password'] ?? ''
            );
            if ($response) {
                echo json_encode($response);
            } else {
                http_response_code(401);
                echo json_encode(['error' => 'Credenciais inválidas']);
            }
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método não permitido']);
}