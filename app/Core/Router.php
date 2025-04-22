<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $basePath = '';

    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    public function addRoute(string $method, string $path, $handler): void
    {
        // Normaliza o caminho da rota
        $normalizedPath = $this->normalizePath($path);
        $this->routes[$method][$normalizedPath] = $handler;
    }

    
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
        
        // Debug
        error_log("Dispatching: $method $path");
    
        // Verifica rota exata
        if (isset($this->routes[$method][$path])) {
            $this->executeHandler($this->routes[$method][$path]);
            return;
        }
    
        // Rota não encontrada
        $this->notFound();
    }
    
    
private function matchPath(string $routePath, string $requestPath): bool
{
    // Implementação básica - pode ser expandida para parâmetros dinâmicos
    return $routePath === $requestPath;
}

    private function executeHandler($handler): void
    {
        if (is_array($handler)) {
            [$class, $method] = $handler;
            
            if (!class_exists($class)) {
                throw new \RuntimeException("Classe $class não encontrada");
            }
            
            $instance = new $class();
            
            if (!method_exists($instance, $method)) {
                throw new \RuntimeException("Método $method não existe na classe $class");
            }
            
            $instance->$method();
        } elseif (is_callable($handler)) {
            $handler();
        } else {
            throw new \RuntimeException("Handler inválido");
        }
    }

    private function normalizePath(string $path): string
    {
        $path = trim($path, '/');
        return $path === '' ? '/' : '/' . $path;
    }

    private function notFound(): void
    {
        http_response_code(404);
        
        if (file_exists(__DIR__.'/../../templates/errors/404.php')) {
            require __DIR__.'/../../templates/errors/404.php';
        } else {
            echo "Página não encontrada";
        }
        
        exit;
    }

    // Método para depuração
    public function getRoutes(): array
    {
        return $this->routes;
    }
}