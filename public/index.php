<?php
// Ativa modo debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<!-- DEBUG: Sistema iniciado -->";

require_once __DIR__.'/../vendor/autoload.php';

// Corrige o REQUEST_URI removendo o path base
$requestUri = str_replace('/php_chat/public', '', $_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = $requestUri ?: '/';

// Debug
echo "<!-- REQUEST_URI: ".$_SERVER['REQUEST_URI']." -->";

$router = require __DIR__.'/../routes/web.php';
$router->dispatch();