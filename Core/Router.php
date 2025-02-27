<?php

namespace Core;

class Router
{
    private static $routes = [];
    private static $namedRoutes = [];
    private static $currentRoute = [];

    /**
     * Registra una ruta GET
     */
    public static function get(string $uri, $action): self
    {
        return self::addRoute('GET', $uri, $action);
    }

    /**
     * Registra una ruta POST
     */
    public static function post(string $uri, $action): self
    {
        return self::addRoute('POST', $uri, $action);
    }

    /**
     * Registra una ruta PUT
     */
    public static function put(string $uri, $action): self
    {
        return self::addRoute('PUT', $uri, $action);
    }

    /**
     * Registra una ruta DELETE
     */
    public static function delete(string $uri, $action): self
    {
        return self::addRoute('DELETE', $uri, $action);
    }

    /**
     * Carga las rutas desde un directorio
     */
    public static function loadRoutes(string $directory): void
    {
        foreach (glob($directory . '/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * Asigna un nombre a la ruta actual
     */
    public static function name(string $name): self
    {
        if (!empty(self::$currentRoute)) {
            self::$namedRoutes[$name] = self::$currentRoute;
            self::$currentRoute = [];
        }
        return new static;
    }

    /**
     * Obtiene la URL de una ruta nombrada
     */
    public static function route(string $name): ?string
    {
        return self::$namedRoutes[$name]['uri'] ?? null;
    }

    /**
     * Maneja la solicitud y ejecuta la acción correspondiente
     */
    public static function dispatch(string $uri, string $method): mixed
    {
        $method = strtoupper($method);
        $relativeRoute = self::normalizeUri($uri);

        try {
            if (isset(self::$routes[$method][$relativeRoute])) {
                return self::resolveAction(self::$routes[$method][$relativeRoute]);
            }
            throw new Exceptions\RouteNotFoundException($relativeRoute);
        } catch (Exceptions\RouteNotFoundException $e) {
            error_log($e->getMessage());
            return view('404');
        }
    }

    /**
     * Añade una nueva ruta
     */
    private static function addRoute(string $method, string $uri, $action): self
    {
        self::$routes[$method][$uri] = $action;
        self::$currentRoute = ['method' => $method, 'uri' => $uri];
        return new static;
    }

    /**
     * Resuelve la acción de la ruta
     */
    private static function resolveAction($action): mixed
    {
        if (is_callable($action)) {
            return call_user_func($action);
        }

        if (is_array($action)) {
            [$controller, $method] = $action;
            if (class_exists($controller) && method_exists($controller, $method)) {
                return call_user_func([new $controller(), $method]);
            }
        }

        throw new \InvalidArgumentException("Invalid route action");
    }

    /**
     * Normaliza la URI eliminando el BASE_URL
     */
    private static function normalizeUri(string $uri): string
    {
        return '/' . trim(str_replace(BASE_URL, '', $uri), '/');
    }
}
