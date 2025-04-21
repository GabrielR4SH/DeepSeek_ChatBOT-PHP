<?php
require_once __DIR__.'/../vendor/autoload.php';

session_start();

// Configuração de roteamento básico
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/login':
        require __DIR__ . '/../templates/auth/login.php';
        break;
    case '/register':
        require __DIR__ . '/../templates/auth/register.php';
        break;
    case '/chat':
        require __DIR__ . '/../templates/chat/index.php';
        break;
    default:
        header('Location: /login');
        exit;
}