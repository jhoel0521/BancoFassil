<?php

namespace Core;

class Request
{
    /**
     * Obtiene el método HTTP de la solicitud.
     *
     * @return string
     */
    public function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Obtiene la URL de la solicitud.
     *
     * @return string
     */
    public function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Obtiene un parámetro de la solicitud (query string o cuerpo).
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function input($key, $default = null)
    {
        if ($this->method() === 'GET') {
            return $_GET[$key] ?? $default;
        }

        return $_POST[$key] ?? $default;
    }

    /**
     * Obtiene todas las entradas de la solicitud.
     *
     * @return array
     */
    public function all()
    {
        if ($this->method() === 'GET') {
            return $_GET;
        }

        return $_POST;
    }

    /**
     * Obtiene una cabecera HTTP.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function header($key, $default = null)
    {
        $headers = getallheaders();
        return $headers[$key] ?? $default;
    }

    /**
     * Obtiene una cookie.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function cookie($key, $default = null)
    {
        return $_COOKIE[$key] ?? $default;
    }
}
