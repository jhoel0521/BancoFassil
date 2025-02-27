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