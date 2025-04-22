<?php

use App\Core\Router;
use App\Application\Auth\AuthController;
use App\Application\Message\MessageController;

// Carrega automaticamente as classes
require_once __DIR__.'/../vendor/autoload.php';

// Cria o roteador com o base path correto
$router = new Router('/php_chat/public');

$router = new Router();

// Rota raiz - redireciona para login
$router->addRoute('GET', '/', function() {
    header('Location: /login');
    exit;
});

// Rota para /index.php explicitamente
$router->addRoute('GET', '/index.php', function() {
    header('Location: /');
    exit;
});

// ... outras rotas permanecem iguais

$router->addRoute('GET', '/register', function() {
    require __DIR__.'/../../templates/auth/register.php';
});

// Rotas Protegidas
$router->addRoute('GET', '/chat', function() {
    require __DIR__.'/../app/Infrastructure/Auth/AuthMiddleware.php';
    $middleware = new App\Infrastructure\Auth\AuthMiddleware();
    $middleware->handle();
    
    require __DIR__.'/../../templates/chat/index.php';
});

// Rotas API
$router->addRoute('POST', '/api/auth/login', [AuthController::class, 'login']);
//$router->addRoute('POST', '/api/messages', [MessageController::class, 'sendMessage']);

// Para depuração - mostra as rotas registradas
if (isset($_GET['debug_routes'])) {
    echo "<pre>";
    print_r($router->getRoutes());
    echo "</pre>";
    exit;
}

error_log("Rotas registradas: " . print_r($router->getRoutes(), true));
return $router;