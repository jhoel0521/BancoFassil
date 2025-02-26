<?php

namespace Core;

class Router
{
    private static $routes = [];

    public static function get($uri, $action)
    {
        self::$routes['GET'][$uri] = $action;
    }

    public static function post($uri, $action)
    {
        self::$routes['POST'][$uri] = $action;
    }

    public static function put($uri, $action)
    {
        self::$routes['PUT'][$uri] = $action;
    }

    public static function delete($uri, $action)
    {
        self::$routes['DELETE'][$uri] = $action;
    }

    public static function loadRoutes($directory)
    {
        foreach (glob($directory . '/*.php') as $file) {
            require_once $file;
        }
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
