<?php

namespace Core;

class Router
{
    private static $routes = [];
    private static $namedRoutes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
        return new static; // Permite encadenar métodos como ->name()
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][$uri] = $action;
        return new static;
    }

    public static function put($uri, $action)
    {
        self::$routes['PUT'][$uri] = $action;
        return new static;
    }

    public static function delete($uri, $action)
    {
        self::$routes['DELETE'][$uri] = $action;
        return new static;
    }
    public static function loadRoutes($directory)
    {
        foreach (glob($directory . '/*.php') as $file) {
            require_once $file;
        }
    }
    public static function name($name)
    {
        // Encuentra la última ruta agregada
        $lastMethod = array_key_last(self::$routes);
        $lastUri = array_key_last(self::$routes[$lastMethod]);

        // Almacena el nombre de la ruta
        self::$namedRoutes[$name] = $lastUri;
    }

    public static function route($name)
    {
        return self::$namedRoutes[$name] ?? null;
    }

    public static function dispatch($uri, $method)
    {
        $method = strtoupper($method);

        if (isset(self::$routes[$method][$uri])) {
            $action = self::$routes[$method][$uri];

            if (is_callable($action)) {
                return call_user_func($action);
            } elseif (is_array($action)) {
                [$controller, $method] = $action;
                if (class_exists($controller) && method_exists($controller, $method)) {
                    $instance = new $controller();
                    return call_user_func([$instance, $method]);
                }
            }
        }

        return view('404');
    }
}
