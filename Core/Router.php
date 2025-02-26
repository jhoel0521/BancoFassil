<?php
namespace Core;

class Router {
    private $routes = [];

    public function addRoute($route, $handler) {
        $this->routes[$route] = $handler;
    }

    public function dispatch($requestedRoute) {
        $relativeRoute = str_replace(BASE_URL, '', $requestedRoute);
        
        if (array_key_exists($relativeRoute, $this->routes)) {
            $handler = $this->routes[$relativeRoute];
            if (is_callable($handler)) {
                $handler();
            } elseif (is_array($handler) && count($handler) === 2) {
                [$controller, $method] = $handler;
                if (class_exists($controller) && method_exists($controller, $method)) {
                    $controllerInstance = new $controller();
                    $controllerInstance->$method();
                } else {
                    echo "404 - Controlador o método no encontrado.";
                }
            }
        } else {
            echo "404 - Ruta no encontrada.";
        }
    }
}
