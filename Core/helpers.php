<?php
// Generar CSRF Token
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Verificar CSRF Token
function csrf_verify($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Sistema de sesiones flash
class Session
{
    public static function flash($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function destroy()
    {
        session_destroy();
    }
}
// auth()
function auth()
{
    return Session::get('user');
}
function isAuth()
{
    return auth() !== null;
}

function flashGet($key)
{
    if (!isset($_SESSION['_flash'])) {
        return null;
    }
    return $_SESSION['_flash'][$key] ?? null;
}
function clearFlash()
{
    unset($_SESSION['_flash']);
}
if (!function_exists('class_basename')) {
    function class_basename($class)
    {
        // Si el parámetro es un objeto, obtén su clase
        if (is_object($class)) {
            $class = get_class($class);
        }

        // Devuelve el nombre de la clase sin el namespace
        return basename(str_replace('\\', '/', $class));
    }
}
