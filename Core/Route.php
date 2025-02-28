<?php

namespace Core;

class Route
{
    protected $uri;
    protected $action;
    protected $method;
    protected $middleware = [];
    protected $name;

    public function __construct($method, $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    /**
     * Agrega un middleware a la ruta.
     *
     * @param string|array $middleware
     * @return self
     */
    public function middleware($middleware)
    {
        $this->middleware = array_merge($this->middleware, (array) $middleware);
        return $this;
    }

    /**
     * Asigna un nombre a la ruta.
     *
     * @param string $name
     * @return self
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Obtiene el método HTTP de la ruta.
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Obtiene la URI de la ruta.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Obtiene la acción de la ruta.
     *
     * @return array
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Obtiene los middlewares de la ruta.
     *
     * @return array
     */
    public function getMiddleware()
    {
        return $this->middleware;
    }

    /**
     * Obtiene el nombre de la ruta.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }
}
