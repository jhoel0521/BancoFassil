<?php

namespace Core;

class Router
{
    protected static $routes = [];

    /**
     * Define una ruta GET.
     *
     * @param string $uri
     * @param array $action
     * @return Route
     */
    public static function get($uri, $action)
    {
        return self::addRoute('GET', $uri, $action);
    }

    /**
     * Define una ruta POST.
     *
     * @param string $uri
     * @param array $action
     * @return Route
     */
    public static function post($uri, $action)
    {
        return self::addRoute('POST', $uri, $action);
    }

    /**
     * Agrega una ruta a la lista de rutas.
     *
     * @param string $method
     * @param string $uri
     * @param array $action
     * @return Route
     */
    protected static function addRoute($method, $uri, $action)
    {
        $route = new Route($method, $uri, $action);
        self::$routes[$method][$uri] = $route;
        return $route;
    }

    /**
     * Despacha la solicitud.
     *
     * @param Request $request
     * @return Response
     */
    public static function dispatch(Request $request)
    {
        $uri = $request->uri();
        $uri = self::normalizeUri($uri);
        $method = $request->method();
        // Buscar la ruta correspondiente
        if (isset(self::$routes[$method][$uri])) {
            $route = self::$routes[$method][$uri];

            // Ejecutar middlewares
            foreach ($route->getMiddleware() as $middleware) {
                $middlewareInstance = new $middleware;
                $response = $middlewareInstance->handle($request, function ($request) use ($route) {
                    return self::resolveAction($route->getAction(), $request);
                });
                // Si el middleware devuelve una respuesta, la retornamos
                if ($response instanceof Response) {
                    return $response;
                }
            }
            // Si no hay middlewares o todos pasaron, ejecutar la acción
            return self::resolveAction($route->getAction(), $request);
        }

        // Si no se encuentra la ruta, devolver un error 404
        return new Response('Página no encontrada', 404);
    }
    /**
     * Normaliza la URI eliminando el BASE_URL
     */
    private static function normalizeUri(string $uri): string
    {
        return '/' . trim(str_replace(BASE_URL, '', $uri), '/');
    }
    /**
     * Resuelve la acción (controlador y método).
     *
     * @param array $action
     * @param Request $request
     * @return Response
     */
    protected static function resolveAction($action, Request $request)
    {
        list($controller, $method) = $action;

        // Verificar si el controlador y el método existen
        if (class_exists($controller) && method_exists($controller, $method)) {
            $controllerInstance = new $controller;
            return $controllerInstance->$method($request);
        }
        // Si no existe, devolver un error 404
        return new Response('Página no encontrada', 404);
    }
    /**
     * Obtiene la URL de una ruta por su nombre.
     *
     * @param string $name
     * @param array $parameters
     * @return string
     * @throws \Exception Si la ruta no existe.
     */
    public static function route($name, $parameters = [])
    {


        $route = null;
        foreach (self::$routes as $method => $routes) {
            foreach ($routes as $r) {
                if ($r->getName() === $name) {
                    $route = $r;
                    break;
                }
            }
        }
        if (!isset($route)) {
            throw new \Exception("La ruta con nombre '$name' no existe.");
        }
        $uri = $route->getUri();

        // Reemplazar parámetros en la URI
        foreach ($parameters as $key => $value) {
            $uri = str_replace("{{$key}}", $value, $uri);
        }

        return $uri;
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
}
